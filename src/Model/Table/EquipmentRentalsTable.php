<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * EquipmentRentals Model
 *
 * @property \App\Model\Table\WorksTable&\Cake\ORM\Association\BelongsTo $Works
 * @property \App\Model\Table\EquipmentsTable&\Cake\ORM\Association\BelongsTo $Equipments
 *
 * @method \App\Model\Entity\EquipmentRental get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipmentRental newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipmentRental[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipmentRental|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipmentRental saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipmentRental patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipmentRental[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipmentRental findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipmentRentalsTable extends Table
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

        $this->setTable('equipment_rentals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Works', [
            'foreignKey' => 'work_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Equipments', [
            'foreignKey' => 'equipment_id',
            'joinType' => 'INNER'
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

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
        $rules->add($rules->existsIn(['work_id'], 'Works'));
        $rules->add($rules->existsIn(['equipment_id'], 'Equipments'));

        return $rules;
    }

    //作業データから装置貸出期間をテーブルに保存
    public function saveRentalPeriod($work){
        $error = [];
        $used_equipments = [];
        $alphas = ['A','B','C','D','E'];
        $work_id = $work->id;
        $this->Equipments = TableRegistry::get('Equipments');

        foreach ($alphas as $key => $alpha) {

            $equipment_id = $work->{'equipment'.$alpha . '_id'};
            if(empty($equipment_id)){
                continue;
            }
            $used_equipments[] = $equipment_id;
            $start_date= $work->{$alpha . '_start_date'};
            $end_date= $work->{$alpha . '_end_date'};

            //期間が重複するかチェック
            if($this->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date)){
                $equipment = $this->Equipments->find()->where(['id'=>$equipment_id])->first();
                $error[] = $equipment->equipment_no . "号車：${start_date} ~ ${end_date}　期間の重複エラー";
                continue;
            }
            //同じ装置のレンタル情報を取得
            $eRental = $this->find()->where(['work_id'=> $work_id])->where(['equipment_id' => $equipment_id])->first();
            if($eRental){//あれば更新
                if(empty($start_date)){
                    $this->delete($eRental);
                    continue;
                }

                $save_data = [
                    'start_date'=>$start_date,
                    'end_date'=>$end_date,
                ];   
            }else{//新規作成
                if(empty($start_date)){
                    continue;
                }                
                $eRental = $this->newEntity();
                
                $save_data = [
                    'work_id'=>$work_id,
                    'equipment_id'=>$equipment_id,
                    'start_date'=>$start_date,
                    'end_date'=>$end_date,
                ];
                
                
            }
            
            $eRental = $this->patchEntity($eRental,$save_data ); 
            
            $this->save($eRental);
        }

        //登録をはずした装置のレンタル情報を一括削除
        $this->deleteAll(['work_id'=> $work_id,'equipment_id NOT IN' => $used_equipments]);

        return $error;

    }

    //使用する装置の期間がほかの作業と重複しているか調べて返す
    public function hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date){

        if(empty($start_date)){
            return false;
        }
        //自分のレコード以外で、自分の開始日が終了日よりも遅いか自分の終了日が開始日よりも早い場合以外を検索
        $eRental = $this->find()->where(['work_id !='=> $work_id])->where(['equipment_id' => $equipment_id])
        ->where(function($exp) use ($start_date,$end_date) {
            $or_query = $exp->or_(function($or) use ($start_date,$end_date) {
                return $or->gt('start_date', $end_date)
                          ->lt('end_date', $start_date);
              });
              return $exp->not($or_query);

          })
        ->count();

        if($eRental>0){
            return true;
        }else{

            return false;
        }

    }

    //テーブルから装置貸出期間を取得して返す
    public function getRentalPeriod($work){

        $alphas = ['A','B','C','D','E'];
        // $work->A_start_date . "- " .$work->A_end_date

        foreach ($alphas as $key => $alpha) {
            $equipment_id = $work->{'equipment'.$alpha . '_id'}; 
            $eRental = $this->find()->where(['work_id' => $work->id])->where(['equipment_id' => $equipment_id])->first();

            if($eRental){                
                $work->{$alpha . '_start_date'} = $eRental->start_date;
                $work->{$alpha . '_end_date'} = $eRental->end_date;
            }

        }

        return $work;

    }


    //テーブルから装置の貸出履歴を取得して返す
    public function getRentalHistory($equipment_id){

        $eRentals = $this->find()->contain(['Works.Orders.WorkPlaces'], true)
        ->where(['equipment_id' => $equipment_id])->order(['EquipmentRentals.start_date' => 'DESC'])->all();

        return $eRentals;

    }

    // 期間中の装置稼働数を年月別に配列に入れて返す
    public function getOperationInfo($start_date, $end_date){


        $targetDate = new \DateTime();

        $conditions[] = ["EquipmentRentals.start_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

        $query = $this->find();
        $counts = $query
        ->contain(['Equipments','Works.Orders'])
       ->select(['year' => 'YEAR(EquipmentRentals.start_date)','month' => 'MONTH(EquipmentRentals.start_date)',
       'e_type_id'=>'Equipments.equipment_type_id','f_size_id'=>'Orders.film_size_id',
       'count' => $query->func()->count('*')             
       ])       
       ->where($conditions)
       ->group(['year' => 'YEAR(EquipmentRentals.start_date)','month' => 'MONTH(EquipmentRentals.start_date)','equipment_type_id','film_size_id'])
       ->all()->toArray(); 
        // debug($counts);die();
        return $this->createStatData($counts);
    
    }    

    protected function createStatData($counts){

        $data = [];
        // $record = [
        //    'year' => '2019',
        //    'month' => '10',
        //    'e_type_id' => (int) 2,//Bレ車
        //    'f_size_id' => (int) 4, //四つ切
        //    'count' => (int) 3,        ]
        foreach ($counts as $key => $record) {
            if(empty($data[$record['year']])){
                $data[$record['year']] = [];
            }
            if(empty($data[$record['year']][$record['month']])){
                $data[$record['year']][$record['month']] = ['counts'=>[0,0,0,0,0,0,0,0,0,0]];
            }
            $e_type_id = $record['e_type_id'];
            $f_size_id = $record['f_size_id'];
            
            $idx = $this->get_count_idx($e_type_id,$f_size_id);
            if($idx >= 0){
                $data[$record['year']][$record['month']]['counts'][$idx] = $record['count'];
            }

        }
        return $data;

    }

    //変換テーブルを使って与えられた装置とフィルムサイズの配列インデックスを返す
    protected function get_count_idx($e_type_id,$f_size_id){
        // f_size_id　　　// e_type_id
        // 1	100mm　　 // 1	可搬
        // 2	DR　　　　// 2	Bレ車
        // 3	大角　　　// 3	Mレ車
        // 4	四つ切　　// 4	P      

        // 1			2			3			4
        // 1	2	3	1	2	3	1	2	4	2
        // 0    1   2   3   4   5   6   7   8   9  
        
        // 変換テーブル
        //         1   2   3   4   f_size_id
        //     1   0   1   2   -1
        //     2   3   4   5   -1
        //     3   6   7   -1  8
        //     4   -1  9   -1  -1
        //e_type_id         
        
        $convTable = [   
            [0,1,2,-1],  
            [3,4,5,-1],  
            [6,7,-1,8],  
            [-1,9,-1,-1]
        ];

        return $idx = $convTable[$e_type_id-1][$f_size_id-1];       

    }


}
