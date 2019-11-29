<?php
namespace App\Test\TestCase\Controller;

use App\Controller\WorksController;
use Cake\TestSuite\IntegrationTestCase;

use Cake\ORM\TableRegistry;

/**
 * App\Controller\WorksController Test Case
 */
class WorksControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.works',
        'app.orders',
        // 'app.clients',
        // 'app.work_places',
        // 'app.bills',
        'app.business_partners',
        'app.contract_rates',
        'app.work_contents',
        'app.capturing_regions',
        'app.film_sizes',
        'app.equipments',
        'app.equipment_types',
        'app.equipment_rentals',
        'app.staffs',

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
        $this->Works = TableRegistry::get('Works');
        $this->BusinessPartners = TableRegistry::get('BusinessPartners');
        $this->WorkContents = TableRegistry::get('WorkContents');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Works);
        unset($this->BusinessPartners);
        unset($this->WorkContents);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/works/index');
        $this->assertResponseOk();
        $this->assertResponseContains('作業一覧');
        $this->assertCount(10, $this->viewVariable('works'));

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '請負元' => 1,
            '_csrfToken' => $token
        ];
        $this->post('/works/index', $data);
        $this->assertCount(3, $this->viewVariable('works'));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/works/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('作業内容の閲覧');
        $work = $this->viewVariable('work');
        // debug($staff);
        $this->assertEquals(3,$work->operation_number);
        $this->assertEquals(1,$work->done);
        $this->assertEquals('吉本 里佳',$work->staff1->name);
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
            'id' => 1,
            'order_id' => 1,
            'staff2_id' => 3,
            'done' => 0,
            '_csrfToken' => $token            
        ];
        // $work = $this->Works->get(1, [
        //     'contain' => ['Orders']
        // ]);
        // $work = $this->Works->patchEntity($work, $data, ['associated' => ['Orders']]);
        // debug($work);
        $this->post('/works/edit/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'view',1]);    
        $query = $this->Works->find()->where(['id' => 1])->first();
        $this->assertEquals($data['staff2_id'], $query->staff2_id);
        $this->assertEquals($data['done'], $query->done);
    }

    /**
     * Test ajaxsaveworksatus method
     *
     * @return void
     */
    public function testAjaxsaveworksatus()
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
            'work_id' => 1,          
            'value' => 0,          
        ];
        $this->post('/works/ajaxsaveworksatus', $data);  
        $query = $this->Works->find()->where(['id' => 1])->first();
        $this->assertEquals($data['value'], $query->done);
    }




}
