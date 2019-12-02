<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
/**
 * Bills Controller
 *
 * @property \App\Model\Table\BillsTable $Bills
 */
class BillsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Orders = TableRegistry::get('Orders');

    }

    /**
     * IndexAll method
     *
     * @return \Cake\Network\Response|null
     */
    public function indexAll($partner_id = null,$year = null,$month = null,$status = null)
    {
        
        
        if(!empty($year) and !empty($month) or !empty($status)){
            $this->request->data = [
                'date' => [
                    'year' =>$year,
                    'month' =>$month,
                ],
                '状況' => $status
            ];
            if(!empty($partner_id)){
                $this->request->data['請求先'] = $partner_id;
            }
        }


        $this->PagingSupport->inheritPostData();  
        

        //対象月
        if(!empty($this->request->data['date']['year']) and !empty($this->request->data['date']['month'])){
                
            $targetDate =new \DateTime($this->request->data['date']['year']."/".($this->request->data['date']['month'])."/1");
        }else{
            $targetDate = new \DateTime();
        } 
        $conditions[] = ["Bills.bill_sent_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 
        
        //回収状況
        if(!empty($this->request->data['状況'])){
            if($this->request->data['状況'] == '回収'){

                $conditions[] = ['received_date IS NOT' => null,'received_date !=' => ''];                
            }else{
                $conditions[] = ['OR'=>['received_date IS' => null,'received_date =' => '']];                

            }
        }

        //請求先
        if(!empty($this->request->data['請求先'])){
            $conditions[] = ['business_partner_id' => $this->request->data['請求先']];       

        }
                    
        
        
        // debug($conditions);

        $this->paginate = [
            'limit' => 10,
            'contain'=>['BusinessPartners'],
            'order' => [
                'Bills.bill_sent_date' => 'DESC'
            ],
            'conditions'=>$conditions,                 
            'paramType' => 'querystring'                    
        ];     
        
    
        $bills = $this->paginate($this->Bills);
     
        //請求先リスト  
        $payers = $this->Orders->get_payer_list();

        $this->set(compact('bills','payers'));
        $this->set('_serialize', ['bills']);
    }



    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($partner_id,$year = null,$month = null)
    {
        
            $this->request->data = ['date' => [
            'year' =>$year,
            'month' =>$month 
            ]];

            $conditions = $this->create_order_conditions($partner_id,$year,$month);


            $query = $this->Orders->find_account_receivable_data($conditions);   
            $orders = $query->all()->toArray();
            $accountReceivables = $this->Orders->sort_account_receivable_data($orders);
            
            

            $orders = $this->query_orders_from_conditions($conditions);
             

            foreach ($orders as $key => $order) {
                if($order->has('bill')){
                    $bills[$order->bill->id] = $order->bill;
                }
                
            }
            
        
        // $this->paginate = [
            // 'contain' => ['BusinessPartners']
        // ];
        
        // $bills = $this->paginate($this->Bills);
        
        //顧客情報
        $businessPartner = $this->Bills->BusinessPartners->find()
            ->where(["BusinessPartners.id" => $partner_id])
            ->first();
        


        $this->set(compact('bills','orders','accountReceivables','businessPartner'));
        $this->set('_serialize', ['bills','orders','accountReceivables']);
    }
    
    protected function query_orders_from_conditions($conditions){

            $query = $this->Orders->find();
            $orders = $query
            ->contain(['Clients', 'Bills','WorkPlaces','WorkContents'])
            ->matching('Works', function($q) {
                return $q->where(['Works.done' => 1]);
            }) 
            ->where($conditions)
            ->order(['Bills.id' => 'ASC'])
            ->all()->toArray();        

            return $orders;        
    }

    protected function create_order_conditions($partner_id,$year = null,$month = null){
        
        $conditions = [];
        
        
        if(!empty($year) and !empty($month)){
            $targetDate =new \DateTime($year."/".$month."/1");
        }else{
            $targetDate = new \DateTime();
        }
                
        $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 


        //取引先
        if(!empty($partner_id)){
             $conditions[] = ['payer_id' => $partner_id];       
          }
          
          return $conditions;      
        
    }


    /**
     * View method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null,$year = null, $month = null)
    {
        $this->MyCompanies = TableRegistry::get('MyCompanies');
        
        $mycompany = $this->MyCompanies->find()
            ->where(['owner' => 1])
            ->first();
        
        $bill = $this->Bills->get($id, [
            'contain' => ['BusinessPartners', 'Orders'=>['Clients','WorkPlaces','WorkContents']]
        ]);

        $this->set(compact('bill', 'mycompany','year','month'));
        $this->set('_serialize', ['bill','mycompany']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($partner_id = null,$check_str = null,$year = null, $month = null)
    {
        $bill = $this->Bills->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->data);die();
            $year = $this->request->data['data']['year'];
            $month = $this->request->data['data']['month'];
            $this->request->data['total_value'] = $this->request->data['total_charge'] - $this->request->data['consumption_tax'];
            
            $bill = $this->Bills->patchEntity($bill, $this->request->data);
            
            if ($this->Bills->save($bill)) {
                
                $result = $this->Orders->save_many_orders_from_bill($bill->id,$this->request->data['data']['Orders']);

                if($result){
                    $this->Flash->success(__('請求書を新規作成しました。'));
                }else{
                    $this->Flash->error(__('請求書を新規作成しましたが、注文テーブルの更新に失敗しました。'));
                }
                
                

                return $this->redirect(['action' => 'view',$bill->id,$year,$month]);
            } else {
               $this->Flash->error(__('請求書の新規作成に失敗しました。再度やり直してください。'));
                $check_str = $this->request->data['data']['check_str'];
                $partner_id = $this->request->data['business_partner_id'];
            }
        }
        
        
            $order_ids = explode(",", $check_str);             
            //顧客情報取得
            $payerData = $this->Bills->BusinessPartners->find()
                ->where(["BusinessPartners.id" => $partner_id])
                ->first();            
      
            //請求対象注文情報取得
            $orders = $this->Orders->find()
                ->contain(['Clients','WorkPlaces','Works','WorkContents','CapturingRegions','FilmSizes'])
                ->where(["Orders.id IN" => $order_ids])
                ->all();
 

    
        
         $this->set('check_str',$check_str);         
        
        
        $this->set(compact('bill', 'payerData','orders','year','month'));
        $this->set('_serialize', ['bill','orders']);
    }



    public function ajaxcreatebilldetails($check_str){


                // デバッグ情報出力を抑制
        Configure::write('debug', true);
        // ajaxによる呼び出し？
        if($this->request->is("ajax")) {
                    

            $order_ids = explode(",", $check_str);             
            
            //請求明細情報取得
            $orders = $this->Orders->find()
                ->contain(['Clients','WorkPlaces','WorkContents'])
                ->where(["Orders.id IN" => $order_ids])
                ->all();     
                    
            //debug($modelName.$check_str.$payer_type.$payer_id);   
            
            $page = $this->request->data['page']; // get the requested page 
            $limit = $this->request->data['rows']; // get how many rows we want to have into the grid 
            $sidx = $this->request->data['sidx']; // get index row - i.e. user click to sort 
            $sord = $this->request->data['sord']; // get the direction        

            if(!$sidx) $sidx =1; 



            $response = new \stdClass;
        
            $i=0; 
            $subtotal = 0;
            $total = 0;
            //pr($billDetailInfo);die;
            foreach ($orders as $order){ 
                        
                            
            //['id','bill_id','受注No','保証料金','保証人数','追加人数','追加料金単価','その他料金']
                $subtotal = $order->guaranty_charge + 
                $order->additional_count * $order->additional_unit_price + $order->other_charge;    
                $total += $subtotal;
                        
                    
                // jqgrid用repsonse配列にセット（疾病名array）

                $id = $order->id;
                                                        
                $response->rows[$i]['id']=$id;
                $response->rows[$i]['cell']=array($id,$order->id,$order->order_no,$order->description,$order->guaranty_charge, $order->guaranty_count,
                $order->additional_count,$order->additional_unit_price,$order->other_charge,$subtotal);     
                $i++;                 

            
            }//end for
        
                $response->userdata = array('order_no'=>'合計' ,'sub_total'=> $total);

            $count = $i;
                        

            if( $count >0 ) { 
                $total_pages = ceil($count/$limit); 
            } else { 
                $total_pages = 0; 
            }               

        
            if ($page > $total_pages) $page=$total_pages; 
            $start = $limit*$page - $limit; // do not put $limit*($page - 1)            

                
            $response->page = $page; 
            $response->total = $total_pages; 
            $response->records = $count;

    
            return $this->response->withStringBody(json_encode($response)); 
            //debug($response); die();         
            //  $this->set('response',$response);         
        }
        
            
    }


    public function ajaxloadbilldetails($bill_id){

                // デバッグ情報出力を抑制
        Configure::write('debug', true);
        // ajaxによる呼び出し？
        if($this->request->is("ajax")) {
            
            //請求明細情報取得
            $orders = $this->Orders->find()
                ->contain(['Clients','WorkPlaces','WorkContents'])
                ->where(["Orders.bill_id" => $bill_id])
                ->all();                        
        
            
            $page = $this->request->data['page']; // get the requested page 
            $limit = $this->request->data['rows']; // get how many rows we want to have into the grid 
            $sidx = $this->request->data['sidx']; // get index row - i.e. user click to sort 
            $sord = $this->request->data['sord']; // get the direction        

            if(!$sidx) $sidx =1; 

    
            $response = new \stdClass;
        
            $i=0; 
            $subtotal = 0;
            $total = 0;
            //pr($billDetailInfo);die;
            foreach ($orders as $order){ 
                

                //['id','bill_id','受注No','保証料金','保証人数','追加人数','追加料金単価','その他料金']
                $subtotal = $order->guaranty_charge + 
                $order->additional_count * $order->additional_unit_price + $order->other_charge;    
                $total += $subtotal;
                
            
                // jqgrid用repsonse配列にセット（疾病名array）

                $id = $order->id;
                                                        
                $response->rows[$i]['id']=$id;
                $response->rows[$i]['cell']=array($id,$order->id,$order->order_no,$order->description,$order->guaranty_charge, $order->guaranty_count,
                $order->additional_count,$order->additional_unit_price,$order->other_charge,$subtotal);     
                $i++;  

            
            }//end for
        
            $response->userdata = array('order_no'=>'合計' ,'sub_total'=> $total);
                
            $count = $i;
                        

            if( $count >0 ) { 
                $total_pages = ceil($count/$limit); 
            } else { 
                $total_pages = 0; 
            }               

        
            if ($page > $total_pages) $page=$total_pages; 
            $start = $limit*$page - $limit; // do not put $limit*($page - 1)
                
                
            $response->page = $page; 
            $response->total = $total_pages; 
            $response->records = $count;

            return $this->response->withStringBody(json_encode($response));             
            // $this->set('response',$response);         
        }
                
            
    }


    /**
     * Edit method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null,$year = null, $month = null)
    {
        $bill = $this->Bills->get($id, [
            'contain' => ['Orders'=>['Clients','WorkPlaces','WorkContents']]
        ]);

        if(!empty($bill->received_date)){
            $this->Flash->error(__('この請求書は既に債権を回収済みです。'));
            return $this->redirect(['action' => 'view',$bill->id,$year,$month]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $year = $this->request->data['data']['year'];
            $month = $this->request->data['data']['month'];
            $this->request->data['total_value'] = $this->request->data['total_charge'] - $this->request->data['consumption_tax'];
            
            $bill = $this->Bills->patchEntity($bill, $this->request->data);
            // debug($this->request->data);
            // debug($bill);die();
            if ($this->Bills->save($bill)) {
                
                $result = $this->Orders->save_many_orders_from_bill($bill->id,$this->request->data['data']['Orders']);

                if($result){
                    $this->Flash->success(__('請求書を更新しました。'));
                }else{
                    $this->Flash->error(__('請求書を更新しましたが、注文テーブルの更新に失敗しました。'));
                }
                
                

                return $this->redirect(['action' => 'view',$bill->id,$year,$month]);
            } else {
               $this->Flash->error(__('請求書の更新に失敗しました。再度やり直してください。'));

            }            
            
            
        }
        
        
     
            //顧客情報取得
            $payerData = $this->Bills->BusinessPartners->find()
                ->where(["BusinessPartners.id" => $bill->business_partner_id])
                ->first();            
      
            //請求対象注文情報取得
            $orders = $bill->orders;
 
      
        
        $this->set(compact('bill', 'payerData','orders','year','month'));
        $this->set('_serialize', ['bill','orders']);        
        

    }

    /**
     * Delete method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($back = 'index')
    {
        //debug($this->request->data);die();
        $this->request->allowMethod(['post', 'delete']);
        
        $id = $this->request->data['data']['id'];
        $partner_id = $this->request->data['data']['business_partner_id'];
        $year = $this->request->data['data']['year'];
        $month = $this->request->data['data']['month'];
        
        $bill = $this->Bills->get($id);

        if(!empty($bill->received_date)){
            $this->Flash->error(__('この請求書は既に債権を回収済みです。'));
            return $this->redirect(['action' => $back,$partner_id,$year,$month]);
        }

        if ($this->Bills->delete($bill)) {
            
             $orders = $this->Orders->find()
                ->where(['Orders.bill_id' => $id])
                ->all();
            $saveData = ['bill_id'=>null,'is_charged'=>0];
            
            $success = true;
            foreach ($orders as $order) {
                $updatedOrder = $this->Orders->patchEntity($order, $saveData);                
                if($this->Orders->save($updatedOrder)){
                    
                }else{
                    $success = false;
                }
                
            }
            if ($success) {
                $this->Flash->success(__('請求書情報は削除されました。'));

            } else {
                $this->Flash->error(__('請求書情報は削除されましたが、関連注文テーブルデータの更新に失敗しました。'));
            } 
            return $this->redirect(['action' => $back,$partner_id,$year,$month]);
          
            
           
        } else {
            $this->Flash->error(__('請求書情報の削除に失敗しました。再度やり直してください。'));
        }

        return $this->redirect(['action' => $back,$partner_id,$year,$month]);
    }


    function ajaxsavereceiveddate(){

            // ajaxによる呼び出し？
        if($this->request->is("ajax")) {
            $bill_id = $this->request->data['bill_id'];
            $value = $this->request->data['value'];
            $newData = $this->Bills->newEntity();   
            $bill = $this->Bills->get($bill_id, [
                'contain' => []
            ]);               

            $bill = $this->Bills->patchEntity($bill, ['received_date' => $value]);
            if ($this->Bills->save($bill)) {
                $result = ['result'=>1,'message'=> '入金日を更新しました。'];
            } else {
                $result =  ['result'=>0,'message'=> '入金日の保存に失敗しました。再度やり直してください。'];
            }

             
 
        }
        return $this->response->withStringBody(json_encode($result));

        // $this->set('result',$result);      
        
        
        
    }    


    public function setbaddebt($back = 'index')
    {
        //debug($this->request->data);die();

        $this->request->allowMethod(['post']);
        $id = $this->request->data['data']['id'];
        $partner_id = $this->request->data['data']['business_partner_id'];
        $year = $this->request->data['data']['year'];
        $month = $this->request->data['data']['month'];
        $mode = $this->request->data['data']['mode'];
        
        $newData = $this->Bills->newEntity();   
        $bill = $this->Bills->get($id, [
            'contain' => []
        ]);    
        
        if(!empty($bill->received_date)){
            $this->Flash->error(__('この請求書は既に債権を回収済みです。'));
            return $this->redirect(['action' => $back,$partner_id,$year,$month]);
        }        

        if($mode == 'good'){
            $bill = $this->Bills->patchEntity($bill, ['uncollectible' => 0]);

        }elseif($mode == 'bad'){

            $bill = $this->Bills->patchEntity($bill, ['uncollectible' => 1]);
        }
        if ($this->Bills->save($bill)) {
            $this->Flash->success(__('貸し倒れ設定を更新しました。'));
        } else {
            $this->Flash->success(__('貸し倒れ設定の保存に失敗しました。再度やり直してください。'));
        }
        
        return $this->redirect(['action' => $back,$partner_id,$year,$month]);

    }




}
