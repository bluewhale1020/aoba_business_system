<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventLogs Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EventLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventLogsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('event_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('event')
            ->maxLength('event', 100)
            ->requirePresence('event', 'create')
            ->notEmptyString('event');

        $validator
            ->scalar('action_type')
            ->maxLength('action_type', 10)
            ->allowEmptyString('action_type');

        $validator
            ->scalar('table_name')
            ->maxLength('table_name', 50)
            ->allowEmptyString('table_name');

        $validator
            ->scalar('remote_addr')
            ->maxLength('remote_addr', 20)
            ->allowEmptyString('remote_addr');

        $validator
            ->scalar('old_val')
            ->allowEmptyString('old_val');

        $validator
            ->scalar('new_val')
            ->allowEmptyString('new_val');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * ログイン・ログアウト時にログデータを保存
     * 
     * @param integer $user_id auth user id
     * @param string $mode login/logout
     */
    public function loginOut($user_id,$mode)
    {
        if($mode == 'login'){
            $desc = 'ログイン';
        }else{
            $desc = 'ログアウト';
        }

        // ログデータの作成
        $data = [
            'event'=>$desc,
            'action_type'=>$mode,
            'table_name'=>null,
            'record_id'=>null,
            'user_id'=>$user_id,
            'new_val'=>null,
            'old_val'=>null,
            'remote_addr'=>env('REMOTE_ADDR'),            
        ];

        // ログデータをイベントログテーブルに保存する
        $newLog = $this->newEntity();

        $newLog = $this->patchEntity($newLog,$data);

        return $this->save($newLog);

    }

}
