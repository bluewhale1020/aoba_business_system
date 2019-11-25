<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Staffs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Occupations1
 * @property \Cake\ORM\Association\BelongsTo $Occupations2
 * @property \Cake\ORM\Association\BelongsTo $Titles
 *
 * @method \App\Model\Entity\Staff get($primaryKey, $options = [])
 * @method \App\Model\Entity\Staff newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Staff[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Staff|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Staff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Staff[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Staff findOrCreate($search, callable $callback = null)
 */
class StaffsTable extends Table
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

        $this->table('staffs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Occupation1', [
            'className' => 'Occupations',
            'foreignKey' => 'occupation_id',
            'propertyName' => 'Occupation1'
        ]);
        $this->belongsTo('Occupation2', [
            'className' => 'Occupations',
            'foreignKey' => 'occupation2_id',
            'propertyName' => 'Occupation2'
        ]);
        $this->belongsTo('Titles', [
            'foreignKey' => 'title_id'
        ]);
        

        $this->hasMany('Work1', [
            'className' => 'Works',
            'foreignKey' => 'staff1_id'
        ]);
        $this->hasMany('Work2', [
            'className' => 'Works',        
            'foreignKey' => 'staff2_id'
        ]);
        $this->hasMany('Work3', [
            'className' => 'Works',        
            'foreignKey' => 'staff3_id'
        ]);
        $this->hasMany('Work4', [
            'className' => 'Works',        
            'foreignKey' => 'staff4_id'
        ]);
        $this->hasMany('Work5', [
            'className' => 'Works',        
            'foreignKey' => 'staff5_id'
        ]);
        $this->hasMany('Work6', [
            'className' => 'Works',        
            'foreignKey' => 'staff6_id'
        ]);
        $this->hasMany('Work7', [
            'className' => 'Works',        
            'foreignKey' => 'staff7_id'
        ]);
        $this->hasMany('Work8', [
            'className' => 'Works',        
            'foreignKey' => 'staff8_id'
        ]);
        $this->hasMany('Work9', [
            'className' => 'Works',        
            'foreignKey' => 'staff9_id'
        ]);
        $this->hasMany('Work10', [
            'className' => 'Works',        
            'foreignKey' => 'staff10_id'
        ]);
        $this->hasMany('Work11', [
            'className' => 'Works',        
            'foreignKey' => 'technician1_id'
        ]);
        $this->hasMany('Work12', [
            'className' => 'Works',        
            'foreignKey' => 'technician2_id'
        ]);
        $this->hasMany('Work13', [
            'className' => 'Works',        
            'foreignKey' => 'technician3_id'
        ]);
        $this->hasMany('Work14', [
            'className' => 'Works',        
            'foreignKey' => 'technician4_id'
        ]);
        $this->hasMany('Work15', [
            'className' => 'Works',        
            'foreignKey' => 'technician5_id'
        ]);
        $this->hasMany('Work16', [
            'className' => 'Works',        
            'foreignKey' => 'technician6_id'
        ]);
        $this->hasMany('Work17', [
            'className' => 'Works',        
            'foreignKey' => 'technician7_id'
        ]);
        $this->hasMany('Work18', [
            'className' => 'Works',        
            'foreignKey' => 'technician8_id'
        ]);
        $this->hasMany('Work19', [
            'className' => 'Works',        
            'foreignKey' => 'technician9_id'
        ]);
        $this->hasMany('Work20', [
            'className' => 'Works',        
            'foreignKey' => 'technician10_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name')
            ->notEmpty('name','名前は必須項目です。');

        $validator
            ->requirePresence('kana')
            ->notEmpty('kana','フリガナは必須項目です。');

        $validator
            ->requirePresence('birth_date')
            ->notEmpty('birth_date','生年月日は必須項目です。');        

        $validator
            ->requirePresence('sex')
            ->notEmpty('sex','性別は必須項目です。');    
            
        $validator
            ->allowEmpty('tel');

        $validator
            ->allowEmpty('postal_code');

        $validator
            ->allowEmpty('address');

        $validator
            ->allowEmpty('banchi');

        $validator
            ->allowEmpty('tatemono');

        $validator
            ->allowEmpty('notes');

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
        $rules->add($rules->existsIn(['occupation_id'], 'Occupation1'));
        $rules->add($rules->existsIn(['occupation2_id'], 'Occupation2'));
        $rules->add($rules->existsIn(['title_id'], 'Titles'));

        return $rules;
    }

    //カナ・生年月日で検索し、登録済みなら該当者のエンティティを、無ければ新規エンティティを返す
    public function findOrNew($kana,$birthdate){
        $result = $this->find()->where(['kana'=>$kana,'birth_date'=>$birthdate])->first();

        if($result){
            return $result;
        }else{
            return $this->newEntity();
        }

    }
}
