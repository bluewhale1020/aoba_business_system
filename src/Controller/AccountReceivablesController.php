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



}
