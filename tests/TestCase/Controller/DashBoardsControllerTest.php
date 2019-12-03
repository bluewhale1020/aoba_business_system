<?php
namespace App\Test\TestCase\Controller;

use App\Controller\DashboardsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\DashboardsController Test Case
 *
 * @uses \App\Controller\DashboardsController
 */
class DashboardsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders_dash',    
        'app.bills3',    
        'app.works_dash',
        'app.BusinessPartners',
        'app.WorkContents',

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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/Dashboards/index');
        $this->assertResponseOk();
        $this->assertResponseContains('システム上の各種データの集計・管理を行います');
        $this->assertCount(7, $this->viewVariable('orders'));

        $stat = [
            'order_count'=> 2,
            'ongoing_count'=> 1,
            'not_charged_count'=> 2,
        ];

        $this->assertEquals($stat, $this->viewVariable('stat'));

    }

    /**
     * Test ajaxloadsalesdata method
     *
     * @return void
     */
    public function testAjaxloadsalesdata()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);
        $today = new \DateTime();
        $early = clone $today;
        $early->modify("-1 month");
        $data = [
            'start_year'=>$early->format("Y"),    
            'start_mon'=>$early->format("m"),    
            'end_year'=>$today->format("Y"),    
            'end_mon'=>$today->format("m"),    
        ];

        $this->post('/dashboards/ajaxloadsalesdata', $data);
        $this->assertResponseCode(200);
        $response = json_decode($this->_response->getBody(), true);

        $chart = [
            ["year"=>$early->format("Y"),"month"=>$early->format("m"),"sales"=>20000],
            ["year"=>$today->format("Y"),"month"=>$today->format("m"),"sales"=>20000],
        ];
        $order_count = ["total"=>4,"charged"=>2];
        $total_sales = ["cost"=>4000,"sales"=>40000];

        $this->assertEquals($chart,$response['chartdata']);
        $this->assertEquals($order_count,$response['order_count']);
        $this->assertEquals($total_sales,$response['total_sales']);
    }

    /**
     * Test ajaxgetcalendarevents method
     *
     * @return void
     */
    public function testAjaxgetcalendarevents()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);
        $today = new \DateTime();
        $data = [
            'startDate'=>$today->format("Y-m-1"),
            'endDate'=>$today->format("Y-m-t"),
        ];
        $this->post('/dashboards/ajaxgetcalendarevents', $data);
        $this->assertResponseCode(200);
        $response = json_decode($this->_response->getBody(), true);
        $this->assertEquals(5,count($response));
    }
}
