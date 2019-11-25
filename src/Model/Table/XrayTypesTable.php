<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * XrayTypes Model
 *
 * @property \App\Model\Table\EquipmentsTable&\Cake\ORM\Association\HasMany $Equipments
 *
 * @method \App\Model\Entity\XrayType get($primaryKey, $options = [])
 * @method \App\Model\Entity\XrayType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\XrayType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\XrayType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\XrayType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\XrayType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\XrayType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\XrayType findOrCreate($search, callable $callback = null, $options = [])
 */
class XrayTypesTable extends Table
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

        $this->setTable('xray_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Equipments', [
            'foreignKey' => 'xray_type_id'
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
