<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * AccountReceivables Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class AccountReceivablesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Bills = TableRegistry::get('Bills');
        $this->Orders = TableRegistry::get('Orders');
        $this->BusinessPartners = TableRegistry::get('BusinessPartners');
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
            
            //対象月
             if(!empty($this->request->data['date']['year']) and !empty($this->request->data['date']['month'])){
                 
                $targetDate =new \DateTime($this->request->data['date']['year']."/".($this->request->data['date']['month'])."/1");
                
                $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 
                
           }else{
                $targetDate = new \DateTime();

                $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 

           }           
            //取引先
            if(!empty($this->request->data['請求先'])){
                 $conditions[] = ['payer_id' => $this->request->data['請求先']];       

              }

            $query = $this->Orders->find_account_receivable_data($conditions);   
  

        }else{

            $targetDate = new \DateTime();

            $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 
               
             $query = $this->Orders->find_account_receivable_data($conditions); 

            $this->request->data = ['date' => [
            'year' =>$targetDate->format("Y"),
            'month' =>$targetDate->format("m") 
            ]];
                               
        }     

        $this->paginate = [
            'limit' => 10,             
            'paramType' => 'querystring'                    
        ];        
        //$queryを渡してデータを取得
        $orders = $this->paginate($query);        
        $accountReceivables = $this->Orders->sort_account_receivable_data($orders);

        

        //請求先リスト  
        $payers = $this->Orders->get_payer_list();

        
        
        $this->set(compact('accountReceivables','payers'));
        $this->set('_serialize', ['accountReceivables']);



    }




    /**
     * View method
     *
     * @param string|null $id Account Receivable id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
        // $order = $this->Orders->get($id, [
            // 'contain' => []
        // ]);
// 
        // $this->set('order', $order);
        // $this->set('_serialize', ['order']);
    // }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
        // $order = $this->Orders->newEntity();
        // if ($this->request->is('post')) {
            // $order = $this->Orders->patchEntity($order, $this->request->data);
            // if ($this->Orders->save($order)) {
                // $this->Flash->success(__('The account receivable has been saved.'));
// 
                // return $this->redirect(['action' => 'index']);
            // } else {
                // $this->Flash->error(__('The account receivable could not be saved. Please, try again.'));
            // }
        // }
        // $this->set(compact('order'));
        // $this->set('_serialize', ['order']);
    // }

    /**
     * Edit method
     *
     * @param string|null $id Account Receivable id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
        // $order = $this->Orders->get($id, [
            // 'contain' => []
        // ]);
        // if ($this->request->is(['patch', 'post', 'put'])) {
            // $order = $this->Orders->patchEntity($order, $this->request->data);
            // if ($this->Orders->save($order)) {
                // $this->Flash->success(__('The account receivable has been saved.'));
// 
                // return $this->redirect(['action' => 'index']);
            // } else {
                // $this->Flash->error(__('The account receivable could not be saved. Please, try again.'));
            // }
        // }
        // $this->set(compact('order'));
        // $this->set('_serialize', ['order']);
    // }

    /**
     * Delete method
     *
     * @param string|null $id Account Receivable id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
        // $this->request->allowMethod(['post', 'delete']);
        // $order = $this->Orders->get($id);
        // if ($this->Orders->delete($order)) {
            // $this->Flash->success(__('The account receivable has been deleted.'));
        // } else {
            // $this->Flash->error(__('The account receivable could not be deleted. Please, try again.'));
        // }
// 
        // return $this->redirect(['action' => 'index']);
    // }
}
