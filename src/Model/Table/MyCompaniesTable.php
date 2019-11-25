<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MyCompanies Model
 *
 * @method \App\Model\Entity\MyCompany get($primaryKey, $options = [])
 * @method \App\Model\Entity\MyCompany newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MyCompany[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MyCompany|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyCompany patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MyCompany[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MyCompany findOrCreate($search, callable $callback = null)
 */
class MyCompaniesTable extends Table
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

        $this->table('my_companies');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('kana', 'create')
            ->notEmpty('kana');

        $validator
            ->allowEmpty('tel');

        $validator
            ->allowEmpty('fax');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('postal_code');

        $validator
            ->allowEmpty('address');

        $validator
            ->allowEmpty('banchi');

        $validator
            ->allowEmpty('tatemono');

        $validator
            ->allowEmpty('url');

        $validator
            ->allowEmpty('notes');

        $validator
            ->integer('owner')
            ->allowEmpty('owner');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
