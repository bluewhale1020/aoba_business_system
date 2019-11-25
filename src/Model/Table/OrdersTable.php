<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;
use Cake\I18n\Time;
/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $WorkPlaces
 * @property \Cake\ORM\Association\BelongsTo $Payers
 * @property \Cake\ORM\Association\BelongsTo $Bills
 * @property \Cake\ORM\Association\BelongsTo $WorkContents
 * @property \Cake\ORM\Association\BelongsTo $CapturingRegions
 * @property \Cake\ORM\Association\BelongsTo $FilmSizes
 * @property \Cake\ORM\Association\HasMany $Works
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null)
 */
class OrdersTable extends Table
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
        
        
        $this->table('orders');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clients', [
            'className' => 'BusinessPartners',         
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('WorkPlaces', [
            'className' => 'BusinessPartners',        
            'foreignKey' => 'work_place_id'
        ]);
        $this->belongsTo('Payers', [
            'className' => 'BusinessPartners',        
            'foreignKey' => 'payer_id'
        ]);
        $this->belongsTo('Bills', [
            'foreignKey' => 'bill_id'
        ]);
        $this->belongsTo('WorkContents', [
            'foreignKey' => 'work_content_id'
        ]);
        $this->belongsTo('CapturingRegions', [
            'foreignKey' => 'capturing_region_id'
        ]);
        $this->belongsTo('FilmSizes', [
            'foreignKey' => 'film_size_id'
        ]);
        $this->hasMany('Works', [
            'foreignKey' => 'order_id'
            ,'dependent' => true
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
            ->notEmpty('client_id','元請け情報は必須項目です。');
        $validator
            ->notEmpty('work_place_id','派遣先情報は必須項目です。');
        $validator
            ->allowEmpty('payer_id');


        $validator
            ->integer('cancel')
            ->allowEmpty('cancel');

        $validator
            ->integer('temporary_registration')
            ->allowEmpty('temporary_registration');

        $validator
            ->allowEmpty('notes');

        $validator
            ->date('start_date')
            ->allowEmpty('start_date');

        $validator
            ->date('end_date')
            ->allowEmpty('end_date');

        $validator
            ->time('start_time')
            ->allowEmpty('start_time')
        ->add('start_time', [
                    'time' => [
                            'rule'      => 'time',
                            'message'   => 'start_time can only accept times.'
                            ],
                ]);  
        $validator
            ->time('end_time')
            ->allowEmpty('end_time')
            ->add('end_time', [
                    'time' => [
                            'rule'      => 'time',
                            'message'   => 'end_time can only accept times.'
                            ],
                ]);  ;

        $validator
            ->integer('patient_num')
            ->allowEmpty('patient_num');

        $validator
            ->integer('need_image_reading')
            ->allowEmpty('need_image_reading');

        $validator
            ->allowEmpty('service_charge');

        $validator
            ->allowEmpty('guaranty_charge');

        $validator
            ->integer('guaranty_count')
            ->allowEmpty('guaranty_count');

        $validator
            ->integer('additional_count')
            ->allowEmpty('additional_count');

        $validator
            ->integer('additional_unit_price')
            ->allowEmpty('additional_unit_price');

        $validator
            ->integer('other_charge')
            ->allowEmpty('other_charge');

        $validator
            ->integer('is_charged')
            ->allowEmpty('is_charged');

        $validator
            ->integer('transportable_equipment_cost')
            ->allowEmpty('transportable_equipment_cost');
        $validator
            ->integer('transportation_cost')
            ->allowEmpty('transportation_cost');
        $validator
            ->integer('travel_cost')
            ->allowEmpty('travel_cost');

        $validator
            ->integer('image_reading_cost')
            ->allowEmpty('image_reading_cost');

        $validator
            ->integer('labor_cost')
            ->allowEmpty('labor_cost');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['work_place_id'], 'WorkPlaces'));
        $rules->add($rules->existsIn(['work_content_id'], 'WorkContents'));
        $rules->add($rules->existsIn(['capturing_region_id'], 'CapturingRegions'));
        $rules->add($rules->existsIn(['film_size_id'], 'FilmSizes'));

        return $rules;
    }


    //カレンダー用データを取得
    public function get_calendar_data($start_date, $end_date){
        //期間

        $conditions[] = ['end_date >=' => $start_date];
        $conditions[] = ['start_date <=' => $end_date];


        $query = $this->find();
        $events = $query
        ->contain(['WorkPlaces'=>['fields'=>['name']],
        'Works'=>['fields'=>['Works.id','done','order_id']]
        ])
        //field指定するとhasManyのworksデータが取得できない
       //    ->select([
       //     'id'=>'Orders.id','start_date','end_date','start_time','end_time','title'=>'WorkPlaces.name'
       //     ])          
       ->where($conditions)
       ->all();
       
       return $events;

    }


    // インポートデータの一部修正
    public function modify_import_order($rowdata){
        //descriptionカラム追加
        $rowdata = $this->import_add_description($rowdata);
        //時間書式の変更
        $rowdata = $this->format_time($rowdata);
        
        return $rowdata;
    }

    //時間書式の変更
    public function format_time($rowdata){
        // 開始時間 終了時間
        $starttime = $rowdata['開始時間'];
        $endtime = $rowdata['終了時間'];
        
        $rowdata['開始時間'] = $this->_format_time($starttime);
        $rowdata['終了時間'] = $this->_format_time($endtime);
        return $rowdata;
    }
    protected function _format_time($timevalue){
        if(empty($timevalue)){
            return $timevalue;
        }
        $time = [];
        $time_parts = explode(":",$timevalue);
        for ($i=0; $i < 3; $i++) { 
            if(empty($time_parts[$i])){
                $time[] = "00";
            }else{
                $time[] = \sprintf("%02d",$time_parts[$i]);
            }
        }

        return \implode(":",$time);
    }

    //インポートデータから摘要事項を作成し、descriptionカラムに追加
    // 派遣先+業務内容+撮影部位+フィルムサイズ
    public function import_add_description($rowdata){
        $description[] = $rowdata['派遣先'];
        $description[] =  $rowdata['業務内容'];
        if(!empty($rowdata['撮影部位'])){
            $description[] =  $rowdata['撮影部位'];            
        }
        if(!empty($rowdata['フィルムサイズ'])){
            $description[] =  $rowdata['フィルムサイズ'];
        }

        $rowdata['description'] = implode(" ",$description);

        return $rowdata;
    }

    //受注Ｎｏで検索し、登録済みなら該当エンティティを、無ければ新規エンティティを返す
    public function findOrNew($order_no){
        $result = $this->find()->where(['order_no'=>$order_no])->first();

        if($result){
            return $result;
        }else{
            return $this->newEntity();
        }

    }    

    //請求先によりpayer_idを設定
    public function modify_requstdata($request_data,$order=null){

        if(!empty($request_data['is_charged'])){
            $request_data['payment'] = $order->payment;            
            $request_data['payer_id'] = $order->payer_id;            
            return $request_data;
        }

        // 'payment' => '依頼元','事業所',
        if($request_data['payment'] == '依頼元'){
            $request_data['payer_id'] = $request_data['client_id'];
        }elseif($request_data['payment'] == '事業所'){
            $request_data['payer_id'] = $request_data['work_place_id'];            
        }
        return $request_data;
    }
    
    
    public function save_many_orders_from_bill($bill_id,$orders)
    {
        
        $success = true;
        
        foreach ($orders as $key => $newOrder) {
            
             $order = $this->get($newOrder['order_id'], [
                'contain' => []
            ]);
             $order['bill_id'] = $bill_id;          
             $order['is_charged'] = 1;          
            $order = $this->patchEntity($order, $newOrder);
            if ($this->save($order)) {
                
            } else {
                $success = false;
            }            
            
            
        }
        
        return $success;
      
        
    }

    
    function get_payer_list(){

        $query = $this->find();
        $result = $query->contain(['Payers'])
        ->select(['Payers.id','Payers.name'])
        ->all()->toArray(); 

        $list = Hash::combine($result, '{n}.payer.id', '{n}.payer.name');


        return $list;

    }

    function get_total_sales($start_date, $end_date){
        $targetDate = new \DateTime();

        $conditions[] = ["Orders.end_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 
        
        $query = $this->find();
        $total_sales = $query
       ->select([
       'cost' => $query->func()->sum('transportable_equipment_cost + image_reading_cost + transportation_cost + travel_cost + labor_cost'),
       'sales' => $query->func()->sum('guaranty_charge + additional_count * additional_unit_price + other_charge')           
       ])
       ->matching('Works', function($q) {
        return $q->where(['Works.done' => 1]);
        })           
       ->where($conditions)
       ->all()->toArray();

       return $total_sales[0];

    }

    function get_charged_order_count($start_date, $end_date){
        $targetDate = new \DateTime();

        $conditions[] = ["Orders.end_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 
        // 作業完了数と請求済み数
        // 作業完了数
        $order_count['total'] = $this->find()
        ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })           
        ->where($conditions)
        ->count(); 
        // 請求済み数
        $order_count['charged'] = $this->find()
        ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })           
        ->where($conditions)
        ->where(['is_charged'=>1])
        ->count(); 

        return $order_count;
    }

    function sum_sales_data($start_date, $end_date){


            $targetDate = new \DateTime();

            $conditions[] = ["Orders.end_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

            $query = $this->find();
            $sum = $query
           ->select(['year' => 'YEAR(end_date)','month' => 'MONTH(end_date)',
           'sales' => $query->func()->sum('guaranty_charge + additional_count * additional_unit_price + other_charge')             
           ])
           ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })           
           ->where($conditions)
           ->group(['year' => 'YEAR(end_date)','month' => 'MONTH(end_date)'])
           ->all()->toArray();        
           $sum = Hash::combine($sum, '{n}.month', '{n}.sales','{n}.year');

        return $sum;
       
    }

    function find_account_receivable_data($conditions = null){
        
        if(empty($conditions)){

            $targetDate = new \DateTime();

            $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 

            $query = $this->find();
            $orders = $query
           ->contain(['Payers', 'Bills'])
           ->select(['payer_name'=> 'Payers.name','payer_id' => 'payer_id','Bills.received_date','Bills.total_charge',
           'guaranty_charge' => $query->func()->sum('guaranty_charge')
           ,'additional_charge' => $query->func()->sum('additional_count * additional_unit_price')
           ,'other_charge' => $query->func()->sum('other_charge')             
           ,'is_charged'])
           ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })           
           ->where($conditions)
           ->group(['bill_id','payer_id'])
           ;            
       
            
        }else{
            $query = $this->find();
            $orders = $query
           ->contain(['Payers', 'Bills'])
           ->select(['payer_name'=> 'Payers.name','payer_id' => 'payer_id','Bills.received_date','Bills.total_charge',
           'guaranty_charge' => $query->func()->sum('guaranty_charge')
           ,'additional_charge' => $query->func()->sum('additional_count * additional_unit_price')
           ,'other_charge' => $query->func()->sum('other_charge')             
           ,'is_charged'])
           ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })              
           ->where($conditions)
            ->group(['bill_id','payer_id'])
           ;             
         
            
        }
        return $query;
    
    }    
    


    public function sort_account_receivable_data($orders){

        $accountReceivables = [];

        
        foreach ($orders as $key => $data) {
            $sales = $received = $charged = 0;
            
            $sales =floor(($data['guaranty_charge'] + 
                    $data['additional_charge'] + $data['other_charge']) * 1.1);
       
       
            if($data->has('bill')){
                $charged = $data->bill->total_charge;
                if(!empty($data->bill->received_date)){
                    $received = $charged;
                }else{
                    $received = 0;
                }
            }else{
                $charged = 0;
            }
        
            if(empty($accountReceivables[$data['payer_id']])){
                $accountReceivables[$data['payer_id']] = [
                'payer_name'=> $data['payer_name'],
                'sales'=>$sales,
                'charged' => $charged,
                'received' => $received
                
                ];
            }else{
                $accountReceivables[$data['payer_id']]['sales'] += $sales;
                $accountReceivables[$data['payer_id']]['charged'] += $charged;
                $accountReceivables[$data['payer_id']]['received'] += $received;
            }
            
            
            
        }
        
        return $accountReceivables;
    }

    public function getPayerCollection(){

        // $conditions[] = ["Orders.bill_id IS "=>null ]; 
        $targetDate = new \DateTime();
         $conditions[] = ["Orders.end_date > '".$targetDate->modify("-1 years")->format("Y-m-t")."'"]; 
 
             $query = $this->find();
              $orders = $query
             ->contain(['Payers'])
             ->select(['payer_name'=> 'Payers.name','payer_id'])
             ->where($conditions)
             ->order(['Orders.order_no' => 'ASC'])
              ->group(['payer_id'])
             ->all()->toArray();        
      
             return $orders;   
         
     }
    
    
}
