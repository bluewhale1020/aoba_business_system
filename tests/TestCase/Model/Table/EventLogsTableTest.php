<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;

/**
 * App\Model\Table\EventLogsTable Test Case
 */
class EventLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventLogsTable
     */
    public $EventLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EventLogs2',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EventLogs') ? [] : ['className' => EventLogsTable::class];
        $this->EventLogs = TableRegistry::getTableLocator()->get('EventLogs', $config);
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test loginOut method
     *
     * @return void
     */
    public function testLoginOut()
    {

        $mode = 'login';$user_id = 4;
        $result = $this->EventLogs->loginOut($user_id,$mode);
 
        $desc = "ログイン";        
        $expected = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>null,
            'record_id'=>null,
            'user_id'=>$user_id,
            'new_val'=>null,
            'old_val'=>null,         
        ];
        $eventLog = $this->EventLogs->find()->order(['id'=>'DESC'])->first();
        foreach ($expected as $key => $value) {
            $this->assertEquals($expected[$key], $eventLog->$key);            
        }

        $mode = 'logout';$user_id = 4;
        $result = $this->EventLogs->loginOut($user_id,$mode);
 
        $desc = "ログアウト";        
        $expected = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>null,
            'record_id'=>null,
            'user_id'=>$user_id,
            'new_val'=>null,
            'old_val'=>null,         
        ];
        $eventLog = $this->EventLogs->find()->order(['id'=>'DESC'])->first();
        foreach ($expected as $key => $value) {
            $this->assertEquals($expected[$key], $eventLog->$key);            
        }
    }

    /**
     * Test beforeSave method
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $this->EventLogs->max_size = 3;

        $options = new ArrayObject();

        $eventLog = $this->EventLogs->newEntity();

        $event = new Event('Model.beforeSave', $this->EventLogs,[
            'entity'=>$eventLog,'options'=> $options
        ]);

        $result = $this->EventLogs->beforeSave($event, $eventLog, $options);

        $count = $this->EventLogs->find()->count();

        $this->assertEquals(2,$count);
    }
}
