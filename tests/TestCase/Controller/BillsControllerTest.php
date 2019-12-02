<?php
namespace App\Test\TestCase\Controller;

use App\Controller\BillsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\BillsController Test Case
 *
 * @uses \App\Controller\BillsController
 */
class BillsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bills',
        'app.BusinessPartners',
        'app.Orders',
        'app.Works',
        'app.WorkContents',
        'app.MyCompanies',
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
        $this->Bills = TableRegistry::get('Bills');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bills);

        parent::tearDown();
    }


    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test indexAll method
     *
     * @return void
     */
    public function testIndexAll()
    {
        $this->get('/Bills/index-all');
        $this->assertResponseOk();
        $this->assertResponseContains('請求書一括管理 ');
        $this->assertCount(1, $this->viewVariable('bills'));


        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '_csrfToken' => $token
        ];

        $this->get('/Bills/index-all/1/2019/11/未回収', $data);
        $bills =  $this->viewVariable('bills');
        $this->assertEquals(2,count($bills)); 
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '_csrfToken' => $token
        ];

        $this->get('/Bills/index/1/2019/10');
        $bills =  $this->viewVariable('bills');
        debug($bills);
        $bill_no = 'A1235';
        foreach ($bills as $key => $bill) { 
            $this->assertEquals($bill_no,$bill->bill_no);
        }
 
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/Bills/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('請求書内容閲覧');
        $bill = $this->viewVariable('bill');

        $this->assertEquals('B3333',$bill->bill_no);
        $this->assertEquals(150000,$bill->total_value);
        $this->assertEquals(165000,$bill->total_charge);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $count = $this->Bills->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'bill_no' => 'C234',
            'is_sent' => null,
            'business_partner_id' => 1,
            // 'total_value' => 1000,
            'consumption_tax' => 200,
            'total_charge' => 800,
            'data'=>['year'=>2019,'month'=>10,'check_str'=>'','Orders'=>[['order_id'=>1]]],
            '_csrfToken' => $token            
        ];
        $this->post('/Bills/add', $data);
        $this->assertRedirectContains('/bills/view');    
        $this->assertEquals($count+1, $this->Bills->find()->count());
    }

    /**
     * Test ajaxcreatebilldetails method
     *
     * @return void
     */
    public function testAjaxcreatebilldetails()
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
            'rows'=>400,
            'page'=>1,
            'sidx'=>null,
            'sord'=>'asc',
        ];
        $this->post('/Bills/ajaxcreatebilldetails/1,2', $data);
        $this->assertResponseCode(200);    

        $expected = [
            ['id'=>1, 'cell'=> [1, 1, "order1", "片栗学園　教職員 撮影 胸部 四つ切 Bレ車", 500000, 100, 
            6, 150, 0, 500900]],
            ['id'=>2, 'cell'=> [2, 2, "order2", "片栗学園　教職員 撮影 胸部 DR", 2800, 120, 
            20, 3000, 0, 62800]],          
        ];      
        $response = json_decode($this->_response->getBody());
        debug($response->rows);
        $this->assertEquals(563700,$response->userdata->sub_total);
        foreach ($response->rows as $key => $row) {
            $this->assertEquals($expected[$key]['cell'],$row->cell);            
        }        
    }

    /**
     * Test ajaxloadbilldetails method
     *
     * @return void
     */
    public function testAjaxloadbilldetails()
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
            'rows'=>400,
            'page'=>1,
            'sidx'=>null,
            'sord'=>'asc',
        ];
        $this->post('/Bills/ajaxloadbilldetails/2', $data);
        $this->assertResponseCode(200);    

        $expected = [
            ['id'=>1, 'cell'=> [1, 1, "order1", "片栗学園　教職員 撮影 胸部 四つ切 Bレ車", 500000, 100, 
            6, 150, 0, 500900]],         
        ];
        $response = json_decode($this->_response->getBody());
        debug($response->rows);
        $this->assertEquals(500900,$response->userdata->sub_total);
        foreach ($response->rows as $key => $row) {
            $this->assertEquals($expected[$key]['cell'],$row->cell);            
        }     
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
            'bill_no' => 'C234',
            'is_sent' => null,
            'business_partner_id' => 1,
            // 'total_value' => 600,
            'consumption_tax' => 200,
            'total_charge' => 800,
            'data'=>['year'=>2019,'month'=>10,'check_str'=>'','Orders'=>[['order_id'=>1]]],
            '_csrfToken' => $token          
        ];
        $this->post('/Bills/edit/2/2019/10', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'view',2,2019,10]);    
        $query = $this->Bills->find()->where(['id' => 2])->first();
        $this->assertEquals(600, $query->total_value);
        $this->assertEquals($data['total_charge'], $query->total_charge);
        $this->assertEquals($data['bill_no'], $query->bill_no);
        
        $data = [
            'data'=>['year'=>2019,'month'=>10,'check_str'=>'','Orders'=>[['order_id'=>1]]],
            '_csrfToken' => $token          
        ];
        $this->post('/Bills/edit/1/2019/10', $data);
        $this->assertFlashElement('Flash/error');
        $this->assertRedirect(['action' => 'view',1,2019,10]);    
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
        $data = [
            'data'=>['id'=>2,'business_partner_id'=>1,'year'=>2019,'month'=>10],
            '_csrfToken' => $token          
        ];
        $this->delete('/Bills/delete/2',$data);
        $this->assertRedirect(['action' => 'index',1,2019,10]);    
        $query = $this->Staffs->find()->where(['id' => 2])->first();
        $this->assertEmpty($query);

        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ]
        ]);
        $data = [
            'data'=>['id'=>1,'business_partner_id'=>6,'year'=>2019,'month'=>10],
            '_csrfToken' => $token          
        ];
        $this->delete('/Bills/delete/1');
        $this->assertRedirect(['action' => 'index',6,2019,10]);    
        $query = $this->Staffs->find()->where(['id' => 1])->first();
        $this->assertNotEmpty($query);
    }

    /**
     * Test ajaxsavereceiveddate method
     *
     * @return void
     */
    public function testAjaxsavereceiveddate()
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
            'bill_id' => 1,          
            'value' => "2019-12-02",          
        ];
        $this->post('/Bills/ajaxsavereceiveddate', $data);  
        $query = $this->Bills->find()->where(['id' => 1])->first();
        $this->assertEquals($data['value'], $query->received_date->format('Y-m-d'));
    }

    /**
     * Test setbaddebt method
     *
     * @return void
     */
    public function testSetbaddebt()
    {
        $token = 'my-csrf-token';
        
        $this->cookie('csrfToken', $token);
            
        $data = [
            'data'=>['id'=>2,'business_partner_id'=>1,'year'=>2019,'month'=>10,'mode'=>'bad'],         
            '_csrfToken' => $token 
        ];
        $this->post('/Bills/setbaddebt', $data);  
        $query = $this->Bills->find()->where(['id' => 2])->first();
        $this->assertEquals(1, $query->uncollectible);
        $this->assertRedirect(['action' => 'index',1,2019,10]); 
            
        $data = [
            'data'=>['id'=>1,'business_partner_id'=>6,'year'=>2019,'month'=>10,'mode'=>'good'],         
            '_csrfToken' => $token 
        ];
        $this->post('/Bills/setbaddebt', $data);  
        $this->assertFlashElement('Flash/error');
        $this->assertRedirect(['action' => 'index',6,2019,10]); 
    }
}
