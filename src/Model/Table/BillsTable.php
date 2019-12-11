<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BusinessPartners
 * @property \Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\Bill get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bill findOrCreate($search, callable $callback = null)
 */
class BillsTable extends Table
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

        $this->addBehavior('Log');    

        $this->table('bills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('BusinessPartners', [
            'foreignKey' => 'business_partner_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'bill_id'
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
            ->notEmpty('bill_no');

        $validator
            ->date('bill_sent_date')
            ->notEmpty('bill_sent_date');

        $validator
            ->date('due_date')
            ->allowEmpty('due_date');

        $validator
            ->integer('is_sent')
            ->allowEmpty('is_sent');

        $validator
            ->allowEmpty('total_value');

        $validator
            ->integer('consumption_tax')
            ->notEmpty('consumption_tax');

        $validator
            ->notEmpty('total_charge');

        $validator
            ->date('received_date')
            ->allowEmpty('received_date');

        $validator
            ->integer('uncollectible')
            ->allowEmpty('uncollectible');

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
        $rules->add($rules->existsIn(['business_partner_id'], 'BusinessPartners'));

        return $rules;
    }
}
