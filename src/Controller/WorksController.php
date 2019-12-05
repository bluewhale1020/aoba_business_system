<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
/**
 * Works Controller
 *
 * @property \App\Model\Table\WorksTable $Works
 */
class WorksController extends AppController
{

 public $components = ["Date"];


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->PagingSupport->inheritPostData();        
        
        $this->Orders = TableRegistry::get('Orders'); 
        
        if($this->request->is('post') or !empty($this->request->data)){
            //データを検索する
            $conditions = [];
            
            //受注No
             if(!empty($this->request->data['受注No'])){
                $conditions[] = ['Orders.order_no '=> $this->request->data['受注No']]; 
            }           
            //期間
            if(!empty($this->request->data['date_range'])){
                $conditions[] = ['Orders.start_date >=' => $this->request->data['start_date']]; 
                  $conditions[] = ['Orders.start_date <=' => $this->request->data['end_date']];              
            }
                        
            //請負元
            if(!empty($this->request->data['請負元'])){
                $conditions[] = ['Orders.client_id' => $this->request->data['請負元']]; 
               
            }
            
            //派遣先
            if(!empty($this->request->data['派遣先'])){
                $conditions[] = ['Orders.work_place_id' => $this->request->data['派遣先']];
                              
            }            
                             
          
        }else{
            //今月以降３か月のデータを取得
            list($this->request->data, $conditions) = $this->Date->setIndexDefaultDateRange($this->request->data,[]);
        }

        
        $this->paginate = [
            'limit' => 10,
            'contain'=>['Orders'=>['Clients','WorkPlaces',  'WorkContents', 'CapturingRegions','FilmSizes'],
            'Equipment1'=>['EquipmentTypes'],'Equipment2'=>['EquipmentTypes'],'Equipment3'=>['EquipmentTypes'],
            'Equipment4'=>['EquipmentTypes'],'Equipment5'=>['EquipmentTypes']
            ,'Staff1','Staff2','Staff3',
            'Technician1','Technician2','Technician3'],
            'order' => [
                'CHAR_LENGTH(Orders.order_no)' => 'ASC',
                'cast(Orders.order_no as unsigned)' => 'ASC'
            ],                
            'paramType' => 'querystring'                    
        ]; 
        if(!empty($conditions)){

            $this->paginate['conditions'] = $conditions;        
        }           

        $works = $this->paginate($this->Works);
        
         

        $clients = $this->Orders->Clients->find('list')->where(['Clients.is_client' => 1])
        ->orWhere(function($exp) {
            return $exp
              ->eq('Clients.is_work_place', 1)
              ->isNull('Clients.parent_id');
          })->limit(200);
      
        $sortedOptions = $this->Orders->WorkPlaces->getSortedOptions();

        $workContents = $this->Orders->WorkContents->find('list', ['limit' => 200])->toArray();

        $this->set(compact('works','clients','sortedOptions','workContents'));
        $this->set('_serialize', ['works']);
    }

    /**
     * View method
     *
     * @param string|null $id Work id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $work = $this->Works->get($id, [
            'contain' => ['Orders'=>['Clients','WorkPlaces','FilmSizes','CapturingRegions'], 'Equipment1'=>['EquipmentTypes'],'Equipment2'=>['EquipmentTypes'],
            'Equipment3'=>['EquipmentTypes'],'Equipment4'=>['EquipmentTypes'],'Equipment5'=>['EquipmentTypes'], 
            'Staff1','Staff2','Staff3','Staff4','Staff5','Staff6','Staff7','Staff8','Staff9','Staff10',
            'Technician1','Technician2','Technician3','Technician4','Technician5','Technician6','Technician7',
            'Technician8','Technician9','Technician10']
        ]);

        //使用期間データ作成
        $work = $this->Works->EquipmentRentals->getRentalPeriod($work);


        $this->set('work', $work);
        $this->set('_serialize', ['work']);
        
        
             //期間
           $week = [];$given_holidays =[];
           
           if($work->order->has('work_place')){
               if(!empty($work->order->work_place->holiday_numbers) or $work->order->work_place->holiday_numbers === '0'){
                   $week = explode(",", $work->order->work_place->holiday_numbers);
               }
               
               $given_holidays = [$work->order->work_place->holiday1,$work->order->work_place->holiday2,$work->order->work_place->holiday3,
           $work->order->work_place->holiday4,$work->order->work_place->holiday5,$work->order->work_place->holiday6,$work->order->work_place->holiday7];
           }
          //$week = [0,4];
            $holidayCount = $this->Date->getHolidayCount($work->order->start_date, $work->order->end_date, $week,$given_holidays,false);
            //debug($week);
            $startDate = new \DateTime($work->order->start_date);
            $endDate = new \DateTime($work->order->end_date);            
            
            $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;
                //debug($num_o_days);die();

            $this->set('holidayCount', $holidayCount);        
            $this->set('num_o_days', $num_o_days);         
        
        
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
        // $work = $this->Works->newEntity();
        // if ($this->request->is('post')) {
            // $work = $this->Works->patchEntity($work, $this->request->data);
            // if ($this->Works->save($work)) {
                // $this->Flash->success(__('The work has been saved.'));
// 
                // return $this->redirect(['action' => 'index']);
            // } else {
                // $this->Flash->error(__('The work could not be saved. Please, try again.'));
            // }
        // }
        // $orders = $this->Works->Orders->find('list', ['limit' => 200]);
        // $equipments = $this->Works->Equipments->find('list', ['limit' => 200]);
        // $staffs = $this->Works->Staffs->find('list', ['limit' => 200]);
        // $this->set(compact('work', 'orders', 'equipments','staffs'));
        // $this->set('_serialize', ['work']);
    // }

    /**
     * Edit method
     *
     * @param string|null $id Work id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $work = $this->Works->get($id, [
            'contain' => ['Orders']
        ]);
        $done_before = $work->done;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $work = $this->Works->patchEntity($work, $this->request->data, ['associated' => ['Orders']]);
            $work = $this->Works->addExtraData($work);
            // debug($work->toArray());die();
            if ($this->Works->save($work)) {
                //装置使用期間を保存
                $error = $this->Works->EquipmentRentals->saveRentalPeriod($work);
                //装置使用頻度の更新
                if(empty($done_before) and $work->done){
                    $this->Equipments = TableRegistry::get('Equipments');
                    $error += $this->Equipments->incrementNumberOfTimes($work);
                }
                if(empty($error)){

                    $this->Flash->success(__('作業内容を更新しました。'));
                }else{
                    $this->Flash->error(__("作業内容を更新しましたが、以下のエラーがあり、一部のデータを保存できませんでした。".implode('',$error)));

                }

                return $this->redirect(['action' => 'view',$work->id]);
            } else {
                $this->Flash->error(__('作業内容の更新に失敗しました。再度やり直してください。'));
            }
        }
        
        //使用期間データ作成
        $work = $this->Works->EquipmentRentals->getRentalPeriod($work);

        $work = $this->Works->setRentalDateRange($work);

        
        $order = $this->Works->Orders->find()->contain(['Clients','WorkPlaces','CapturingRegions','FilmSizes'])
        ->where(['Orders.id'=>$work->order_id])->first();
        
        list($equipment_types,$equipments) =  $this->Works->Equipment1->getEquipmentData($order->capturing_region_id);
         
                   
        $technicians = $this->Works->Staff1->find('list', ['limit' => 200])
        ->where(['Staff1.occupation_id' => 2])
        ->orwhere(['Staff1.occupation2_id'=> 2]);
        $staffs = $this->Works->Staff1->find('list', ['limit' => 200])
        ->where(['Staff1.occupation_id' => 5])
        ->orwhere(['Staff1.occupation2_id'=> 5]);        
        $this->set(compact('work', 'order', 'equipments','equipment_types','staffs','technicians'));
        $this->set('_serialize', ['work']);
    }
    
    
    
    public function ajaxsaveworksatus(){
        
            // ajaxによる呼び出し？
        if($this->request->is("ajax")) {
            $work_id = $this->request->data['work_id'];
            $value = $this->request->data['value'];
            // $work_id = $_POST['work_id'];
            // $value = $_POST['value'];
   
            $work = $this->Works->get($work_id, [
                'contain' => []
            ]);               

            $work = $this->Works->patchEntity($work, ['done' => $value]);
            if ($this->Works->save($work)) {
                $result = ['result'=>1,'message'=> '作業情報を更新しました。'];

            } else {
                $result =  ['result'=>0,'message'=> '作業情報の更新に失敗しました。再度やり直してください。'];
            }                

             
 
        }
        return $this->response->withStringBody(json_encode($result));
        // $this->set('result',$result);      
               
    }  
    
    
}
