<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportDataConversions Model
 *
 * @method \App\Model\Entity\ImportDataConversion get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportDataConversion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImportDataConversion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportDataConversion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportDataConversion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportDataConversion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportDataConversion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportDataConversion findOrCreate($search, callable $callback = null, $options = [])
 */
class ImportDataConversionsTable extends Table
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

        $this->setTable('import_data_conversions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->scalar('category')
            ->maxLength('category', 25)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('item_name')
            ->maxLength('item_name', 45)
            ->requirePresence('item_name', 'create')
            ->notEmptyString('item_name');

        $validator
            ->scalar('tb_name')
            ->maxLength('tb_name', 45)
            ->requirePresence('tb_name', 'create')
            ->notEmptyString('tb_name');

        $validator
            ->allowEmptyString('is_id_number');

        $validator
            ->scalar('id_tb_name')
            ->maxLength('id_tb_name', 45)
            ->allowEmptyString('id_tb_name');

        return $validator;
    }
}
