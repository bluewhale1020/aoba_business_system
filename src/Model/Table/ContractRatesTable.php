<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContractRates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BusinessPartners
 *
 * @method \App\Model\Entity\ContractRate get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContractRate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContractRate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContractRate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContractRate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContractRate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContractRate findOrCreate($search, callable $callback = null)
 */
class ContractRatesTable extends Table
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

        $this->table('contract_rates');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('BusinessPartners', [
            'foreignKey' => 'business_partner_id'
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
            ->integer('guaranty_charge_chest_i_por')
            ->allowEmpty('guaranty_charge_chest_i_por');

        $validator
            ->integer('guaranty_count_chest_i_por')
            ->allowEmpty('guaranty_count_chest_i_por');

        $validator
            ->integer('additional_unit_price_chest_i_por')
            ->allowEmpty('additional_unit_price_chest_i_por');

        $validator
            ->integer('transportable_equipment_cost_chest_i_por')
            ->allowEmpty('transportable_equipment_cost_chest_i_por');

        $validator
            ->integer('appointed_day_cost_chest_i_por')
            ->allowEmpty('appointed_day_cost_chest_i_por');

        $validator
            ->integer('guaranty_charge_chest_dg_por')
            ->allowEmpty('guaranty_charge_chest_dg_por');

        $validator
            ->integer('guaranty_count_chest_dg_por')
            ->allowEmpty('guaranty_count_chest_dg_por');

        $validator
            ->integer('additional_unit_price_chest_dg_por')
            ->allowEmpty('additional_unit_price_chest_dg_por');

        $validator
            ->integer('transportable_equipment_cost_chest_dg_por')
            ->allowEmpty('transportable_equipment_cost_chest_dg_por');

        $validator
            ->integer('appointed_day_cost_chest_dg_por')
            ->allowEmpty('appointed_day_cost_chest_dg_por');

        $validator
            ->integer('guaranty_charge_chest_dr_por')
            ->allowEmpty('guaranty_charge_chest_dr_por');

        $validator
            ->integer('guaranty_count_chest_dr_por')
            ->allowEmpty('guaranty_count_chest_dr_por');

        $validator
            ->integer('additional_unit_price_chest_dr_por')
            ->allowEmpty('additional_unit_price_chest_dr_por');

        $validator
            ->integer('transportable_equipment_cost_chest_dr_por')
            ->allowEmpty('transportable_equipment_cost_chest_dr_por');

        $validator
            ->integer('appointed_day_cost_chest_dr_por')
            ->allowEmpty('appointed_day_cost_chest_dr_por');

        $validator
            ->integer('guaranty_charge_chest_i_car')
            ->allowEmpty('guaranty_charge_chest_i_car');

        $validator
            ->integer('guaranty_count_chest_i_car')
            ->allowEmpty('guaranty_count_chest_i_car');

        $validator
            ->integer('additional_unit_price_chest_i_car')
            ->allowEmpty('additional_unit_price_chest_i_car');

        $validator
            ->integer('guaranty_charge_chest_dg_car')
            ->allowEmpty('guaranty_charge_chest_dg_car');

        $validator
            ->integer('guaranty_count_chest_dg_car')
            ->allowEmpty('guaranty_count_chest_dg_car');

        $validator
            ->integer('additional_unit_price_chest_dg_car')
            ->allowEmpty('additional_unit_price_chest_dg_car');

        $validator
            ->integer('guaranty_charge_chest_dr_car')
            ->allowEmpty('guaranty_charge_chest_dr_car');

        $validator
            ->integer('guaranty_count_chest_dr_car')
            ->allowEmpty('guaranty_count_chest_dr_car');

        $validator
            ->integer('additional_unit_price_chest_dr_car')
            ->allowEmpty('additional_unit_price_chest_dr_car');

        $validator
            ->integer('guaranty_charge_stom_i_car')
            ->allowEmpty('guaranty_charge_stom_i_car');

        $validator
            ->integer('guaranty_count_stom_i_car')
            ->allowEmpty('guaranty_count_stom_i_car');

        $validator
            ->integer('additional_unit_price_stom_i_car')
            ->allowEmpty('additional_unit_price_stom_i_car');

        $validator
            ->integer('guaranty_charge_stom_dr_car')
            ->allowEmpty('guaranty_charge_stom_dr_car');

        $validator
            ->integer('guaranty_count_stom_dr_car')
            ->allowEmpty('guaranty_count_stom_dr_car');

        $validator
            ->integer('additional_unit_price_stom_dr_car')
            ->allowEmpty('additional_unit_price_stom_dr_car');

        $validator
            ->integer('operating_cost')
            ->allowEmpty('operating_cost');

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
