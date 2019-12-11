<?php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Core\Configure;

/**
 * Log behavior
 * 
 * ユーザーのテーブル更新履歴をイベントログとして記録する
 */
class LogBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // テーブルオブジェクトを取得
        // テーブル名を取得
        $table = $event->subject();
        $tb_name = $table->alias();
        // ユーザーID取得
        $user_id = Configure::read('user_id');
        // 新規保存・更新対象フィールドデータを作成
        if($entity->isNew()){
            $old_val = null;
            $new_val = $entity->extract($entity->visibleProperties(),true);
            $new_val = $this->formatDateTimeObject($new_val);
            $mode = "insert";
            $desc = "データの新規登録";
        }else{
            $old_val = $entity->extractOriginalChanged($entity->visibleProperties());
            $changed_fields = array_keys($old_val);
            $old_val = $this->formatDateTimeObject($old_val);
            $new_val = $entity->extract($changed_fields,true);
            $new_val = $this->formatDateTimeObject($new_val);
            $mode = "update";
            $desc = "データの更新";
        }
        // ログデータの作成
        $data = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>$tb_name,
            'record_id'=>$entity->id,
            'user_id'=>$user_id,
            'old_val'=>(\is_null($old_val)?  null : \serialize($old_val)),
            'new_val'=>\serialize($new_val),
            'remote_addr'=>env('REMOTE_ADDR'),
        ];

        return $this->saveLog($data);
        
    }

    // 更新データの中で、日時オブジェクトは、日時書式の文字列に変換
    protected function formatDateTimeObject($values)
    {
        foreach($values as $key => $value){
            if(!is_object($value)){
                continue;
            }
            if(in_array(basename(get_class($value)),['FrozenTime','FrozenDate'])){
                $values[$key] = $value->format("Y/m/d H:i:s");
            }
        }

        return $values;

    }

    public function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // テーブルオブジェクトを取得
        // テーブル名を取得
        $table = $event->subject();
        $tb_name = $table->alias();
        // ユーザーID取得
        $user_id = Configure::read('user_id');
        // 削除するフィールドデータを作成
        $old_val = $entity->extract($entity->visibleProperties(),false);
        $old_val = $this->formatDateTimeObject($old_val);

        $mode = "delete";
        $desc = "データの削除";       
        // ログデータの作成
        $data = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>$tb_name,
            'record_id'=>$entity->id,
            'user_id'=>$user_id,
            'old_val'=>\serialize($old_val),
            'new_val'=>null,
            'remote_addr'=>env('REMOTE_ADDR'),
        ];
        
        return $this->saveLog($data);
        
    }

    // ログデータをイベントログテーブルに保存する
    protected function saveLog($data)
    {
        $logTable = TableRegistry::get('EventLogs');

        $newLog = $logTable->newEntity();

        $newLog = $logTable->patchEntity($newLog,$data);

        return $logTable->save($newLog);

    }


}
