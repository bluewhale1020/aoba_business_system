<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CostManagementsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;


/**
 * App\Controller\CostManagementsController Test Case
 */
class CostManagementsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders',
        'app.business_partners',
        'app.contract_rates',
        'app.work_contents',
        'app.capturing_regions',
        'app.works',
        'app.film_sizes'
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
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orders);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/CostManagements/index');
        $this->assertResponseOk();
        $this->assertResponseContains('費用データ一覧');
        $this->assertCount(10, $this->viewVariable('orders'));

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '請負元' => 1,
            '_csrfToken' => $token
        ];
        $this->post('/CostManagements/index', $data);
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
        $this->get('/CostManagements/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('費用閲覧');
        $order = $this->viewVariable('order');
        // debug($order);
        $this->assertEquals('order1',$order->order_no);
        $this->assertEquals(35000,$order->transportable_equipment_cost);
        $this->assertEquals(50000,$order->labor_cost);
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
            'transportable_equipment_cost' => 3500,
            'transportation_cost' => 200,
            'travel_cost' => 100,
            'image_reading_cost' => 70,
            'labor_cost' => 20,         
            '_csrfToken' => $token            
        ];
        $this->post('/CostManagements/edit/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'view',1]);    
        $query = $this->Orders->find()->where(['id' => 1])->first();
        $this->assertEquals($data['transportation_cost'], $query->transportation_cost);
        $this->assertEquals($data['travel_cost'], $query->travel_cost);
        $this->assertEquals($data['labor_cost'], $query->labor_cost);
    }


}
