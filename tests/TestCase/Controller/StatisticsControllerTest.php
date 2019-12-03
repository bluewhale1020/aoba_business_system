<?php
namespace App\Test\TestCase\Controller;

use App\Controller\StatisticsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\StatisticsController Test Case
 *
 * @uses \App\Controller\StatisticsController
 */
class StatisticsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EquipmentRentals',
        'app.Orders2',
        'app.Works',
        'app.Equipments'
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
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
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
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test ajaxloadoperationnumbers method
     *
     * @return void
     */
    public function testAjaxloadoperationnumbers()
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
        'start_year'=>2019,    
        'start_mon'=>10,    
        'end_year'=>2019,    
        'end_mon'=>12,    
        ];
        $this->post('/statistics/ajaxloadoperationnumbers', $data);
        $this->assertResponseCode(200);

        $expected =['chartdata'=>[
            ['year'=> 2019, 'month'=> 10, 'counts'=> [0,0,0,0,0,0,0,0,0,0]],
            ['year'=> 2019, 'month'=> 11, 'counts'=> [0,3,0,0,0,0,0,0,5,0]],
            ['year'=> 2019, 'month'=> 12, 'counts'=> [0,1,0,0,1,0,0,1,0,0]],
        ]];

        $response = json_decode($this->_response->getBody(),true);

        $this->assertEquals($expected,$response ); 

    }
}
