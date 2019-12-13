<?php
namespace App\Test\TestCase\Controller;

use App\Controller\EventLogsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\EventLogsController Test Case
 *
 * @uses \App\Controller\EventLogsController
 */
class EventLogsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EventLogs',
        'app.Users'
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
        $this->EventLogs = TableRegistry::get('EventLogs');

    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventLogs);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/EventLogs/index');
        $this->assertResponseOk();
        $this->assertResponseContains('ユーザーのデータ処理を記録したログを一覧で表示します');
        $this->assertCount(10, $this->viewVariable('eventLogs'));

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'アクション' => 'delete',
            'ユーザー' => 4,
            '_csrfToken' => $token
        ];
        $this->post('/EventLogs/index', $data);
        $eventLogs =  $this->viewVariable('eventLogs');
        $this->assertEquals(4,count($eventLogs)); 
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }



    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
