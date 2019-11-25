<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $EquipmentTypes
 * @property \Cake\ORM\Association\BelongsTo $Statuses
 *
 * @method \App\Model\Entity\Equipment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Equipment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Equipment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Equipment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Equipment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Equipment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Equipment findOrCreate($search, callable $callback = null)
 */
class EquipmentsTable extends Table
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

        $this->table('equipments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('EquipmentTypes', [
            'foreignKey' => 'equipment_type_id'
        ]);

        $this->belongsTo('XrayTypes', [
            'foreignKey' => 'xray_type_id'
        ]);

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id'
        ]);
        
        $this->hasMany('Work1', [
            'className' => 'Works',        
            'foreignKey' => 'equipmentA_id'
        ]);
        $this->hasMany('Work2', [
            'className' => 'Works',        
            'foreignKey' => 'equipmentB_id'
        ]);
        $this->hasMany('Work3', [
            'className' => 'Works',        
            'foreignKey' => 'equipmentC_id'
        ]);
        $this->hasMany('Work4', [
            'className' => 'Works',       
            'foreignKey' => 'equipmentD_id'
        ]);
        $this->hasMany('Work5', [
            'className' => 'Works',        
            'foreignKey' => 'equipmentE_id'
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

        $validator
            ->allowEmpty('xray_type');

        $validator
            ->integer('transportable')
            ->allowEmpty('transportable');

        $validator
            ->integer('number_of_times')
            ->allowEmpty('number_of_times');

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
        $rules->add($rules->existsIn(['equipment_type_id'], 'EquipmentTypes'));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));

        return $rules;
    }


    //作業完了時に、使用装置の使用頻度を１増やす
    public function incrementNumberOfTimes($work){

        $alphas = ['A','B','C','D','E'];
        $work_id = $work->id;
        $error = [];
        foreach ($alphas as $key => $alpha) {
            $equipment_id = $work->{'equipment'.$alpha . '_id'};
            if (empty($equipment_id)) {
                continue;
            }

            $equipment = $this->get($equipment_id);
            $equipment->number_of_times += 1;

           if(!$this->save($equipment)){
            $error[] = $equipment->equipment_no . "号車：装置の使用頻度更新エラー";
           }

        }
    
        return $error;
    }

    //撮影部位から
    //作業編集フォームで使用する装置タイプと装置リストを返す
    public function getEquipmentData($capturing_region_id){

        $result = $this->find()
        ->contain(['EquipmentTypes'])
        ->where(['OR' => [
            'EquipmentTypes.capturing_region_id' => $capturing_region_id,
            'EquipmentTypes.capturing_region_id IS' => null
        ]])
        ->select(['id','EquipmentTypes.name','equipment_no'])
        ->all();
        $equipment_types = [];
         foreach ($result as $key => $edata) {
             $equipment_types[] = $edata->equipment_type->name;
            $equipments[$edata->id] = $edata->equipment_type->name . " " . $edata->equipment_no . "号車"; 
             
         }
         
         return [\array_unique($equipment_types),$equipments ];
    }
}
