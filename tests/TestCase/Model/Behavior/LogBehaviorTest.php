<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\LogBehavior;
use Cake\TestSuite\TestCase;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

/**
 * App\Model\Behavior\LogBehavior Test Case
 */
class LogBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\LogBehavior
     */
    public $Log;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EventLogs',
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
        $this->Users = TableRegistry::get('Users');
        $this->Log = new LogBehavior($this->Users);
        $this->EventLogs = TableRegistry::get('EventLogs');

    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {      
        unset($this->Log);
        unset($this->EventLogs);        
        unset($this->Users);        

        parent::tearDown();
    }

    /**
     * Test afterSave method
     *
     * @return void
     */
    public function testAfterSave()
    {
        $data = [
            'formal_name' => 'test',
            'username' => 'test',
            'password' => 'pass',
            'role' => 'user',
        ];

        $options = new ArrayObject();

        $user = $this->Users->newEntity();
        $user = $this->Users->patchEntity($user, $data);

        $event = new Event('Model.afterSave', $this->Users,[
            'entity'=>$user,'options'=> $options
        ]);

        $result = $this->Log->afterSave($event, $user, $options);
 
        $new_val = $user->extract($user->visibleProperties(),true);
        $mode = "insert";
        $desc = "データの新規登録";        
        $expected = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>'Users',
            'old_val'=>null,
            'new_val'=>\serialize($new_val),          
        ];
        $eventLog = $this->EventLogs->find()->order(['id'=>'DESC'])->first();
        foreach ($expected as $key => $value) {
            $this->assertEquals($expected[$key], $eventLog->$key);            
        }

        
        $user2 = $this->Users->get(7);
        $user2 = $this->Users->patchEntity($user2, $data);

        $event = new Event('Model.afterSave', $this->Users,[
            'entity'=>$user2,'options'=> $options
        ]);

        $result = $this->Log->afterSave($event, $user2, $options);

        $old_val = $user2->extractOriginalChanged($user2->visibleProperties());        
        $changed_fields = array_keys($old_val);
        $new_val = $user2->extract($changed_fields,true);

        $mode = "update";
        $desc = "データの更新";     
        $expected = [
            'event'=>$desc,
            'action_type'=>$mode,            
            'table_name'=>'Users',
            'old_val'=>\serialize($old_val),
            'new_val'=>\serialize($new_val),          
        ];
        debug($old_val);
        $eventLog = $this->EventLogs->find()->order(['id'=>'DESC'])->first();
        foreach ($expected as $key => $value) {
            $this->assertEquals($expected[$key], $eventLog->$key);            
        }
    }


    /**
     * Test formatDateTimeObject method
     *
     * @return void
     */
    public function testFormatDateTimeObject()
    {
        $reflection = new \ReflectionClass($this->Log);
        $method = $reflection->getMethod('formatDateTimeObject');
        $method->setAccessible(true);
        $str_time = '2015/06/15 08:23:45';$str_date= '2016/11/12 00:00:00';
        $time = new FrozenTime($str_time);        
        $date = new FrozenDate($str_date);        
        $values = [
            'time'=>$time,
            'date'=>$date
        ];
        
        $result = $method->invoke($this->Log,$values);   
        $expected = [
            'time'=>$str_time,
            'date'=>$str_date
        ];
        
        foreach ($expected as $key => $value) {
            $this->assertEquals($value,$result[$key]);
        }        

    }

    /**
     * Test beforeDelete method
     *
     * @return void
     */
    public function testBeforeDelete()
    {

        $options = new ArrayObject();

        $user = $this->Users->get(7);

        $event = new Event('Model.beforeDelete', $this->Users,[
            'entity'=>$user,'options'=> $options
        ]);

        $result = $this->Log->beforeDelete($event, $user, $options);
        $user->created = "2019/10/24 09:56:01";
        $user->modified = "2019/10/24 14:27:47";
        $old_val = $user->extract($user->visibleProperties(),false);

        $mode = "delete";
        $desc = "データの削除";       
        // ログデータの作成
        $expected = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>'Users',
            'record_id'=>7,
            'old_val'=>\serialize($old_val),
            'new_val'=>null,
        ];        

        $eventLog = $this->EventLogs->find()->order(['id'=>'DESC'])->first();
        foreach ($expected as $key => $value) {
            $this->assertEquals($expected[$key], $eventLog->$key);            
        }        
    }
}
