<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AccountReceivablesController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;
/**
 * App\Controller\AccountReceivablesController Test Case
 */
class AccountReceivablesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders',
        'app.bills',
        'app.business_partners',
        'app.contract_rates',
        'app.work_contents',
        'app.capturing_regions',
        'app.works2'       
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
        
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);
        
        $data = [
            'date' =>[
                'year'=>2019,
                'month'=>10
            ],
            '_csrfToken' => $token
        ];
        $this->post('/AccountReceivables/index', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('売掛金データ一覧');
        $accountReceivables =  $this->viewVariable('accountReceivables');

        $expected = [
            '1' => [
                'payer_name'=>'一般財団法人野分記念医学財団　富井診療所',
                'sales'=>550990,
                'charged'=>550990,
                'received'=>0,
            ],
        ];

        debug($accountReceivables);
        $this->assertEquals($expected,$accountReceivables); 


    }


}
