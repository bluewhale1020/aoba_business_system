<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CapturingRegions Model
 *
 * @property \Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\CapturingRegion get($primaryKey, $options = [])
 * @method \App\Model\Entity\CapturingRegion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CapturingRegion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CapturingRegion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CapturingRegion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CapturingRegion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CapturingRegion findOrCreate($search, callable $callback = null)
 */
class CapturingRegionsTable extends Table
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

        $this->table('capturing_regions');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Orders', [
            'foreignKey' => 'capturing_region_id'
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
            ->allowEmpty('name');

        return $validator;
    }
}
