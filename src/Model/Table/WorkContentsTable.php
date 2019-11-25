<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkContents Model
 *
 * @property \Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\WorkContent get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkContent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WorkContent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkContent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkContent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkContent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkContent findOrCreate($search, callable $callback = null)
 */
class WorkContentsTable extends Table
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

        $this->table('work_contents');
        $this->displayField('description');
        $this->primaryKey('id');

        $this->hasMany('Orders', [
            'foreignKey' => 'work_content_id'
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
            ->allowEmpty('description');

        return $validator;
    }
}
