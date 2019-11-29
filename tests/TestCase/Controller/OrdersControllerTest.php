<?php
namespace App\Test\TestCase\Controller;

use App\Controller\OrdersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\OrdersController Test Case
 *
 * @uses \App\Controller\OrdersController
 */
class OrdersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Orders',
        'app.BusinessPartners',
        // 'app.WorkPlaces',
        // 'app.Payers',
        'app.Bills',
        'app.WorkContents',
        'app.CapturingRegions',
        'app.FilmSizes',
        'app.Works'
    ];

    protected function setUserSession()
    {
        $this->session(['Auth' => [
            'User' => [
                'id' => 4,
                'username' => 'admin',
                'role' => 'admin',
            ]
        ]]);
    }    
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->setUserSession();
        $this->Orders = TableRegistry::get('Orders');
        $this->Works = TableRegistry::get('Works');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orders);
        unset($this->Works);

        parent::tearDown();
    }


    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/Orders/index');
        $this->assertResponseOk();
        $this->assertResponseContains('注文一覧');
        $this->assertCount(10, $this->viewVariable('orders'));

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '請負元' => 1,
            '_csrfToken' => $token
        ];
        $this->post('/Orders/index', $data);
        $orders =  $this->viewVariable('orders');
        $this->assertEquals(3,count($orders));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/Orders/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('注文データ詳細');
        $order = $this->viewVariable('order');
        // debug($staff);
        $this->assertEquals('片栗学園　教職員 撮影 胸部 四つ切 Bレ車',$order->description);
        $this->assertEquals('依頼元',$order->payment);
        $this->assertEquals('一般財団法人野分記念医学財団　富井診療所',$order->client->name);
        
        $given_holidays = $this->viewVariable('given_holidays');
        $this->assertEquals(['2019/10/09','2019/10/08'],$given_holidays);        

    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $count = $this->Orders->find()->count();
        $count2 = $this->Works->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'order_no' => 'order20',
            'client_id' => 1,
            'work_place_id' => 3,
            'temporary_registration' => 0,
            'payment' => '依頼元',
            'start_date' => '2019/12/07',
            'end_date' => '2019/12/14',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'work_content_id' => 1,
            'capturing_region_id' => 1,
            'film_size_id' => 4,
            'patient_num' => 500,
            'need_image_reading' => 1,
            '_csrfToken' => $token            
        ];
        $this->post('/Orders/add', $data);
        $this->assertRedirectContains('/orders/view');    
        $this->assertEquals($count+1, $this->Orders->find()->count());
        $this->assertEquals($count2+1, $this->Works->find()->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $token = 'my-csrf-token';
        
        $this->cookie('csrfToken', $token);
        
        $data = [
            'id'=>1,
            'client_id' => 1,
            'work_place_id' => 3,
            'temporary_registration' => 1,
            'payment' => '依頼元',
            'start_date' => '2019/12/10',
            'start_time' => '11:00', 
            'work_content_id' => 1,
            'capturing_region_id' => 1,
            'film_size_id' => 2,                         
            '_csrfToken' => $token            
        ];
        $this->post('/Orders/edit/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'view',1]);    
        $query = $this->Orders->find()->where(['id' => 1])->first();
        $this->assertEquals(1, $query->payer_id);
        $this->assertEquals($data['temporary_registration'], $query->temporary_registration);
        $this->assertEquals($data['start_date'], $query->start_date);
        $this->assertEquals($data['film_size_id'], $query->film_size_id);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);
        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ]
        ]);

        $this->delete('/Orders/delete/2');
        $this->assertFlashMessage('指定した注文情報を削除しました。');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Orders->find()->where(['id' => 2])->first();
        $this->assertEmpty($query);
        
        
        $this->cookie('csrfToken', $token);
        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ]
        ]);
                
        $this->delete('/Orders/delete/1');
        $this->assertFlashMessage('その注文情報はすでに請求書を発行済みなので削除できません！');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Orders->find()->where(['id' => 1])->first();
        $this->assertNotEmpty($query);
    }

    /**
     * Test ajaxcalcnumodays method
     *
     * @return void
     */
    public function testAjaxcalcnumodays()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test ajaxsavetempregistry method
     *
     * @return void
     */
    public function testAjaxsavetempregistry()
    {
        $token = 'my-csrf-token';
        
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);        

        $data = [
            'order_id' => 1,          
            'value' => 0,          
        ];
        $this->post('/Orders/testAjaxsavetempregistry', $data);  
        $query = $this->Orders->find()->where(['id' => 1])->first();
        $this->assertEquals($data['value'], $query->temporary_registration);
    }
}
