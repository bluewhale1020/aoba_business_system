<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
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

        if ($this->request->is('post') or !empty($this->request->data)) {
            //データを検索する
            $conditions = [];
            
            //受注No
            if (!empty($this->request->data['受注No'])) {
                $conditions[] = ['order_no '=> $this->request->data['受注No']];
            }
            //期間
            if (!empty($this->request->data['date_range'])) {
                $conditions[] = ['start_date >=' => $this->request->data['start_date']];
                $conditions[] = ['start_date <=' => $this->request->data['end_date']];
            }
                        
            //請負元
            if (!empty($this->request->data['請負元'])) {
                $conditions[] = ['client_id' => $this->request->data['請負元']];
            }
            
            //派遣先
            if (!empty($this->request->data['派遣先'])) {
                $conditions[] = ['work_place_id' => $this->request->data['派遣先']];
            }
            
            // debug($conditions);

        }


        $this->paginate = [
            'limit' => 10,
            'contain'=>['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions','FilmSizes'],
            'order' => [
                'CHAR_LENGTH(Orders.order_no)' => 'ASC',
                'cast(Orders.order_no as unsigned)' => 'ASC'
            ],                
            'paramType' => 'querystring'                    
        ]; 
        if(!empty($conditions)){
            //debug($conditions);
            $this->paginate['conditions'] = $conditions;        
        }           

        $orders = $this->paginate($this->Orders);        
        

        $clients = $this->Orders->Clients->find('list')->where(['Clients.is_client' => 1])
        ->orWhere(function ($exp) {
            return $exp
              ->eq('Clients.is_work_place', 1)
              ->isNull('Clients.parent_id');
        })->limit(200);
        $workPlaceOptions = $this->Orders->WorkPlaces->find('all')->where(['WorkPlaces.is_work_place' => 1])->limit(200)->toArray();
        
        $sortedOptions = [];
        foreach ($workPlaceOptions as $key => $workPlace) {
            if (empty($workPlace['parent_id'])) {
                $sortedOptions[$workPlace['id']][] = $workPlace;
            } else {
                $sortedOptions[$workPlace['parent_id']][] = $workPlace;
            }
        }
        $workContents = $this->Orders->WorkContents->find('list', ['limit' => 200])->toArray();

        $this->set(compact('orders', 'clients', 'sortedOptions', 'workContents'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes', 'Works']
        ]);

        $this->set('order', $order);
        $this->set('_serialize', ['order']);
        
        
        //期間
        $week = [];
        $given_holidays =[];
           
        if ($order->has('work_place')) {
            if (!empty($order->work_place->holiday_numbers) or $order->work_place->holiday_numbers === '0') {
                $week = explode(",", $order->work_place->holiday_numbers);
            }
               
            $given_holidays = explode(",", $order->work_place->specific_holidays);
        }

        $holidayCount = $this->Date->getHolidayCount($order->start_date, $order->end_date, $week, $given_holidays, false);

        $startDate = new \DateTime($order->start_date);
        $endDate = new \DateTime($order->end_date);
            
        $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;


        $this->set('holidayCount', $holidayCount);
        $this->set('num_o_days', $num_o_days);
        $this->set('given_holidays', $given_holidays);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $this->request->data = $this->Orders->modify_requstdata($this->request->data);

            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                
                    //同時に作業データも作成
                $this->Works = TableRegistry::get('Works');
                $work = $this->Works->newEntity();
                                                 
                $newData = ['order_id' => $order->id];
       
                $work = $this->Works->patchEntity($work, $newData);
                if ($this->Works->save($work)) {
                    $this->Flash->success(__('新規受注情報を登録しました。'));
                } else {
                    $this->Flash->error(__('新規受注情報を登録しましたが、作業レコードの作成に失敗しました。'));
                }
                
                
                

                return $this->redirect(['action' => 'view',$order->id]);
            } else {
                $this->Flash->error(__('新規受注の登録に失敗しました。再度やり直してください。'));
            }
        }
        
        //受注No
        $lastNo = $this->Orders->find()
            ->select(['order_no' => 'MAX(Orders.order_no)'])
            ->first();
        if ($lastNo and is_numeric($lastNo->order_no)) {
            $order->order_no = $lastNo->order_no + 1;
        } else {
            $order->order_no = 1;
        }
        
        
        $clients = $this->Orders->Clients->find('list')->where(['Clients.is_client' => 1])
        ->orWhere(function ($exp) {
            return $exp
              ->eq('Clients.is_work_place', 1)
              ->isNull('Clients.parent_id');
        })->limit(200);
        $workPlaceOptions = $this->Orders->WorkPlaces->find('all')->where(['WorkPlaces.is_work_place' => 1])->limit(200)->toArray();
        
        $sortedOptions = [];
        foreach ($workPlaceOptions as $key => $workPlace) {
            if (empty($workPlace['parent_id'])) {
                $sortedOptions[$workPlace['id']][] = $workPlace;
            } else {
                $sortedOptions[$workPlace['parent_id']][] = $workPlace;
            }
        }
        

        $workContents = $this->Orders->WorkContents->find('list', ['limit' => 200]);
        $capturingRegions = $this->Orders->CapturingRegions->find('list', ['limit' => 200]);
        $filmSizes = $this->Orders->FilmSizes->find('list', ['limit' => 200]);
        $this->set(compact('order', 'clients', 'sortedOptions', 'workContents', 'capturingRegions', 'filmSizes'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['WorkPlaces']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data = $this->Orders->modify_requstdata($this->request->data,$order);
          
            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('注文情報を更新しました。'));

                return $this->redirect(['action' => 'view',$id]);
            } else {
                $this->Flash->error(__('注文情報の更新に失敗しました。再度やり直してください。'));
            }
        }
        
        //実施期間データ作成
        if (!empty($order->start_date) and !empty($order->end_date)) {
            $order->date_range = $order->start_date . " - " .$order->end_date;
        } else {
            $order->date_range = '';
        }
        //時間帯　フォーマット
        if (!empty($order->start_time)) {
            $order->start_time = $order->start_time->format("H:i");
        }
        if (!empty($order->end_time)) {
            $order->end_time = $order->end_time->format("H:i");
        }
 
        //使用装置情報
        $this->Works = TableRegistry::get('Works');
        $work = $this->Works->find()->where(['order_id'=>$id])->contain(
            ['Equipment1'=>['EquipmentTypes'],'Equipment2'=>['EquipmentTypes'],
        'Equipment3'=>['EquipmentTypes'],'Equipment4'=>['EquipmentTypes'],'Equipment5'=>['EquipmentTypes'], 
        ])->first();

        $this->set('work', $work);        

        
        $clients = $this->Orders->Clients->find('list')->where(['Clients.is_client' => 1])
        ->orWhere(function ($exp) {
            return $exp
              ->eq('Clients.is_work_place', 1)
              ->isNull('Clients.parent_id');
        })->limit(200);
        $workPlaceOptions = $this->Orders->WorkPlaces->find('all')->where(['WorkPlaces.is_work_place' => 1])->limit(200)->toArray();
        
        $sortedOptions = [];
        foreach ($workPlaceOptions as $key => $workPlace) {
            if (empty($workPlace['parent_id'])) {
                $sortedOptions[$workPlace['id']][] = $workPlace;
            } else {
                $sortedOptions[$workPlace['parent_id']][] = $workPlace;
            }
        }
        $clientPlaces = $sortedOptions[$order->client_id];
        $clientPlaces = Hash::combine($clientPlaces, '{n}.id', '{n}.name');
    

        $workContents = $this->Orders->WorkContents->find('list', ['limit' => 200]);
        $capturingRegions = $this->Orders->CapturingRegions->find('list', ['limit' => 200]);
        $filmSizes = $this->Orders->FilmSizes->find('list', ['limit' => 200]);

        $this->EquipmentTypes = TableRegistry::get('EquipmentTypes');
        $equipment_types = $this->EquipmentTypes->find('list', ['limit' => 200]);

        $this->set(compact('order', 'clients', 'clientPlaces', 'sortedOptions', 'workContents', 'capturingRegions', 'filmSizes', 'equipment_types'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        // debug($order);die();
        if (!$order->is_charged and $this->Orders->delete($order)) {
            $this->Flash->success(__('指定した注文情報を削除しました。'));
        } elseif($order->is_charged) {
            $this->Flash->error(__('その注文情報はすでに請求書を発行済みなので削除できません！'));
        } else {
            $this->Flash->error(__('注文情報は削除できませんでした。'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function ajaxcalcnumodays()
    {
        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $holiday_numbers = $_POST['holiday_numbers'];
            $holiday1 = $_POST['holiday1'];
            $holiday2 = $_POST['holiday2'];
            $holiday3 = $_POST['holiday3'];
            $order_id = $_POST['order_id'];
            $partner_id = $_POST['partner_id'];
            //取引先の休日データを保存する
            $this->BusinessPartners = TableRegistry::get('BusinessPartners');

                                         
            $newData = ['holiday_numbers' => $holiday_numbers,'holiday1'=>$holiday1,
            'holiday2'=>$holiday2,'holiday3'=>$holiday3];
            $businessPartners = $this->BusinessPartners->get($partner_id, [
                'contain' => []
            ]);

            $businessPartners = $this->BusinessPartners->patchEntity($businessPartners, $newData);
            if ($this->BusinessPartners->save($businessPartners)) {
                
                //実働日数の取得
                
                $order = $this->Orders->get($order_id, [
            'contain' => ['WorkPlaces']
        ]);
       
                //期間
                $week = [];
                $given_holidays =[];
           
                if ($order->has('work_place')) {
                    if (!empty($order->work_place->holiday_numbers) or $order->work_place->holiday_numbers === '0') {
                        $week = explode(",", $order->work_place->holiday_numbers);
                    }
               
                    $given_holidays = [$order->work_place->holiday1,$order->work_place->holiday2,$order->work_place->holiday3,
           $order->work_place->holiday4,$order->work_place->holiday5,$order->work_place->holiday6,$order->work_place->holiday7];
                }
                //$week = [0,4];
                $holidayCount = $this->Date->getHolidayCount($order->start_date, $order->end_date, $week, $given_holidays, false);
                //debug($week);
                $startDate = new \DateTime($order->start_date);
                $endDate = new \DateTime($order->end_date);
            
                $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;
                
                $result = ['holidayCount' => $holidayCount,'num_o_days' => $num_o_days];
                
                $this->set('result', $result);
            } else {
                $this->set('result', false);
            }
        }
    }
    
    public function ajaxsavetempregistry()
    {
        

        
            // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $order_id = $_POST['order_id'];
            $value = $_POST['value'];
            $newData = $this->Orders->newEntity();
            $order = $this->Orders->get($order_id, [
                'contain' => []
                ]);
            $newData->temporary_registration = $value;
            $order = $this->Orders->patchEntity($order, ['temporary_registration' => $value]);
            if ($this->Orders->save($order)) {
                $result = ['result'=>1,'message'=> '注文情報を更新しました。'];
            } else {
                $result =  ['result'=>0,'message'=> '注文情報の更新に失敗しました。再度やり直してください。'];
            }
        }


        $this->set('result', $result);
    }
}
