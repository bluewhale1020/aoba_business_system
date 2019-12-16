<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * CostManagements Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class CostManagementsController extends AppController
{

 public $components = ["Date"];
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Orders = TableRegistry::get('Orders');
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->PagingSupport->inheritPostData();

        if($this->request->is('post') or !empty($this->request->data)){
            //データを検索する
            $conditions = [];
            
            //受注No
             if(!empty($this->request->data['受注No'])){
                $conditions[] = ['order_no '=> $this->request->data['受注No']]; 
            }           
            //期間
            if(!empty($this->request->data['date_range'])){
                $conditions[] = ['start_date >=' => $this->request->data['start_date']]; 
                  $conditions[] = ['start_date <=' => $this->request->data['end_date']];              
            }
                        
            //請負元
            if(!empty($this->request->data['請負元'])){
                $conditions[] = ['client_id' => $this->request->data['請負元']]; 
               
            }
            
            //派遣先
            if(!empty($this->request->data['派遣先'])){
                $conditions[] = ['work_place_id' => $this->request->data['派遣先']];
                              
            }            
            
                // debug($conditions);  

        }
      
            
        $this->paginate = [
            'limit' => 10,
            'contain'=>['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions','FilmSizes'],
            'order' => [
                'Orders.order_no' => 'ASC'
            ]
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
        });        

        $sortedOptions = $this->Orders->WorkPlaces->getSortedOptions();

       $workContents = $this->Orders->WorkContents->find('list', ['limit' => 200])->toArray();

       $this->set(compact('orders', 'clients', 'sortedOptions', 'workContents'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Cost Management id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
       $order = $this->Orders->get($id, [
            'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes','Works']
        ]);

        $this->set('order', $order);
        $this->set('_serialize', ['order']);
        
        
             //期間
           $week = [];$given_holidays =[];
           
           if($order->has('work_place')){
               if(!empty($order->work_place->holiday_numbers) or $order->work_place->holiday_numbers === '0'){
                   $week = explode(",", $order->work_place->holiday_numbers);
               }
               $given_holidays = explode(",", $order->work_place->specific_holidays);
           }
          //$week = [0,4];
            $holidayCount = $this->Date->getHolidayCount($order->start_date->format("Y-m-d"), $order->end_date->format("Y-m-d"), $week,$given_holidays,false);
            //debug($week);
            $startDate = new \DateTime($order->start_date->format("Y-m-d"));
            $endDate = new \DateTime($order->end_date->format("Y-m-d"));            
            
            $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;
            //debug($num_o_days);die();

            $this->set('holidayCount', $holidayCount);        
            $this->set('num_o_days', $num_o_days); 
    }



    /**
     * Edit method
     *
     * @param string|null $id Cost Management id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
       $order = $this->Orders->get($id, [
            'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes','Works']
        ]);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('注文情報を更新しました。'));

                return $this->redirect(['action' => 'view',$id]);
            } else {
                $this->Flash->error(__('注文情報の更新に失敗しました。再度やり直してください。'));
            }
        }



        $this->set('order', $order);
        $this->set('_serialize', ['order']);
        
        
             //期間
           $week = [];$given_holidays =[];
           
           if($order->has('work_place')){
               if(!empty($order->work_place->holiday_numbers) or $order->work_place->holiday_numbers === '0'){
                   $week = explode(",", $order->work_place->holiday_numbers);
               }
               
               $given_holidays = [$order->work_place->holiday1,$order->work_place->holiday2,$order->work_place->holiday3,
           $order->work_place->holiday4,$order->work_place->holiday5,$order->work_place->holiday6,$order->work_place->holiday7];
           }
          //$week = [0,4];
            $holidayCount = $this->Date->getHolidayCount($order->start_date->format("Y-m-d"), $order->end_date->format("Y-m-d"), $week,$given_holidays,false);
            //debug($week);
            $startDate = new \DateTime($order->start_date->format("Y-m-d"));
            $endDate = new \DateTime($order->end_date->format("Y-m-d"));            
            
            $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;
            //debug($num_o_days);die();

            $this->set('holidayCount', $holidayCount);        
            $this->set('num_o_days', $num_o_days); 

    }


}
