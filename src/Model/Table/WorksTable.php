<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Works Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $EquipmentAs
 * @property \Cake\ORM\Association\BelongsTo $EquipmentBs
 * @property \Cake\ORM\Association\BelongsTo $EquipmentCs
 * @property \Cake\ORM\Association\BelongsTo $EquipmentDs
 * @property \Cake\ORM\Association\BelongsTo $EquipmentEs
 * @property \Cake\ORM\Association\BelongsTo $Staff1s
 * @property \Cake\ORM\Association\BelongsTo $Staff2s
 * @property \Cake\ORM\Association\BelongsTo $Staff3s
 * @property \Cake\ORM\Association\BelongsTo $Staff4s
 * @property \Cake\ORM\Association\BelongsTo $Staff5s
 * @property \Cake\ORM\Association\BelongsTo $Staff6s
 * @property \Cake\ORM\Association\BelongsTo $Staff7s
 * @property \Cake\ORM\Association\BelongsTo $Staff8s
 * @property \Cake\ORM\Association\BelongsTo $Staff9s
 * @property \Cake\ORM\Association\BelongsTo $Staff10s
 * @property \Cake\ORM\Association\BelongsTo $Technician1s
 * @property \Cake\ORM\Association\BelongsTo $Technician2s
 * @property \Cake\ORM\Association\BelongsTo $Technician3s
 * @property \Cake\ORM\Association\BelongsTo $Technician4s
 * @property \Cake\ORM\Association\BelongsTo $Technician5s
 * @property \Cake\ORM\Association\BelongsTo $Technician6s
 * @property \Cake\ORM\Association\BelongsTo $Technician7s
 * @property \Cake\ORM\Association\BelongsTo $Technician8s
 * @property \Cake\ORM\Association\BelongsTo $Technician9s
 * @property \Cake\ORM\Association\BelongsTo $Technician10s
 *
 * @method \App\Model\Entity\Work get($primaryKey, $options = [])
 * @method \App\Model\Entity\Work newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Work[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Work|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Work patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Work[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Work findOrCreate($search, callable $callback = null)
 */
class WorksTable extends Table
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

        $this->table('works');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('EquipmentRentals', [
            'foreignKey' => 'work_id',
            'dependent' => true
        ]);

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Equipment1', [
            'className' => 'Equipments',         
            'foreignKey' => 'equipmentA_id'
        ]);
        $this->belongsTo('Equipment2', [
            'className' => 'Equipments',         
            'foreignKey' => 'equipmentB_id'
        ]);
        $this->belongsTo('Equipment3', [
            'className' => 'Equipments',         
            'foreignKey' => 'equipmentC_id'
        ]);
        $this->belongsTo('Equipment4', [
            'className' => 'Equipments',         
            'foreignKey' => 'equipmentD_id'
        ]);
        $this->belongsTo('Equipment5', [
            'className' => 'Equipments',         
            'foreignKey' => 'equipmentE_id'
        ]);
        $this->belongsTo('Staff1', [
            'className' => 'Staffs',         
            'foreignKey' => 'staff1_id'
        ]);
        $this->belongsTo('Staff2', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff2_id'
        ]);
        $this->belongsTo('Staff3', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff3_id'
        ]);
        $this->belongsTo('Staff4', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff4_id'
        ]);
        $this->belongsTo('Staff5', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff5_id'
        ]);
        $this->belongsTo('Staff6', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff6_id'
        ]);
        $this->belongsTo('Staff7', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff7_id'
        ]);
        $this->belongsTo('Staff8', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff8_id'
        ]);
        $this->belongsTo('Staff9', [
            'className' => 'Staffs',        
            'foreignKey' => 'staff9_id'
        ]);
        $this->belongsTo('Staff10', [
            'className' => 'Staffs',
            'foreignKey' => 'staff10_id'
        ]);
        $this->belongsTo('Technician1', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician1_id'
        ]);
        $this->belongsTo('Technician2', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician2_id'
        ]);
        $this->belongsTo('Technician3', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician3_id'
        ]);
        $this->belongsTo('Technician4', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician4_id'
        ]);
        $this->belongsTo('Technician5', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician5_id'
        ]);
        $this->belongsTo('Technician6', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician6_id'
        ]);
        $this->belongsTo('Technician7', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician7_id'
        ]);
        $this->belongsTo('Technician8', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician8_id'
        ]);
        $this->belongsTo('Technician9', [
            'className' => 'Staffs',        
            'foreignKey' => 'technician9_id'
        ]);
        $this->belongsTo('Technician10', [
            'className' => 'Staffs',        
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
            ->integer('start_no')
            ->allowEmpty('start_no');

        $validator
            ->integer('end_no')
            ->allowEmpty('end_no');

        $validator
            ->allowEmpty('absent_nums');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['equipmentA_id'], 'Equipment1'));
        $rules->add($rules->existsIn(['equipmentB_id'], 'Equipment2'));
        $rules->add($rules->existsIn(['equipmentC_id'], 'Equipment3'));
        $rules->add($rules->existsIn(['equipmentD_id'], 'Equipment4'));
        $rules->add($rules->existsIn(['equipmentE_id'], 'Equipment5'));
        $rules->add($rules->existsIn(['staff1_id'], 'Staff1'));
        $rules->add($rules->existsIn(['staff2_id'], 'Staff2'));
        $rules->add($rules->existsIn(['staff3_id'], 'Staff3'));
        $rules->add($rules->existsIn(['staff4_id'], 'Staff4'));
        $rules->add($rules->existsIn(['staff5_id'], 'Staff5'));
        $rules->add($rules->existsIn(['staff6_id'], 'Staff6'));
        $rules->add($rules->existsIn(['staff7_id'], 'Staff7'));
        $rules->add($rules->existsIn(['staff8_id'], 'Staff8'));
        $rules->add($rules->existsIn(['staff9_id'], 'Staff9'));
        $rules->add($rules->existsIn(['staff10_id'], 'Staff10'));
        $rules->add($rules->existsIn(['technician1_id'], 'Technician1'));
        $rules->add($rules->existsIn(['technician2_id'], 'Technician2'));
        $rules->add($rules->existsIn(['technician3_id'], 'Technician3'));
        $rules->add($rules->existsIn(['technician4_id'], 'Technician4'));
        $rules->add($rules->existsIn(['technician5_id'], 'Technician5'));
        $rules->add($rules->existsIn(['technician6_id'], 'Technician6'));
        $rules->add($rules->existsIn(['technician7_id'], 'Technician7'));
        $rules->add($rules->existsIn(['technician8_id'], 'Technician8'));
        $rules->add($rules->existsIn(['technician9_id'], 'Technician9'));
        $rules->add($rules->existsIn(['technician10_id'], 'Technician10'));

        return $rules;
    }

    //保存データの追加
    public function addExtraData($work){

        $alphas = ['A','B','C','D','E'];
        // 'equipmentA_id' => '1',
        $op_num = 0;
        // $start_date= $work->{$alpha . '_start_date'};
        // $end_date= $work->{$alpha . '_end_date'};        
        // $work->A_start_date . " - " .$work->A_end_date

        foreach ($alphas as $key => $alpha) {
            $equipment_id = $work->{'equipment'.$alpha . '_id'}; 
            if(!empty($equipment_id)){
                $op_num += 1;
            }
            $start_date = $work->{$alpha . '_start_date'};
            $date_range = $work->{$alpha . '_date_range'};
            if(!empty($date_range) and empty($start_date)){
                list($start, $end) = \explode(' - ',$date_range);
                if($this->validateDate($start,"Y/m/d")){
                    $work->{$alpha . '_start_date'} = $start;
                }
                if($this->validateDate($end,"Y/m/d")){
                    $work->{$alpha . '_end_date'} = $end;
                }
            }


        }
        $work->operation_number = $op_num;

        return $work;

    }

    //https://www.php.net/manual/ja/function.checkdate.php#113205
    // With DateTime you can make the shortest date&time validator for all formats.
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


}
