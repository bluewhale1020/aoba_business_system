<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * BusinessPartners Controller
 *
 * @property \App\Model\Table\BusinessPartnersTable $BusinessPartners
 */
class BusinessPartnersController extends AppController
{
  

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
        
        //名称
        if(!empty($this->request->data['名称'])){
            $conditions[] = ['BusinessPartners.name like' => '%' . $this->request->data['名称'] . '%']; 
        
        }
        
        //取引先種別
        if(!empty($this->request->data['取引先種別'])){
            switch ($this->request->data['取引先種別']) {
                case 'is_client':
                    $conditions[] = ['BusinessPartners.is_client' => 1];
                    break;
                case 'is_work_place':
                    $conditions[] = ['BusinessPartners.is_work_place' => 1];
                    break;
                case 'is_supplier':
                    $conditions[] = ['BusinessPartners.is_supplier' => 1];
                    break;                                            
                default:
                    
                    break;
            }
                        
        }            
        
            debug($conditions);    
            
        }
        
        $this->paginate = [
            'limit' => 5,
            'contain'=>['ParentBusinessPartners', 'ChildBusinessPartners'],
            // 'order' => [
            //     'Users.created' => 'desc'
            // ]                    
            'paramType' => 'querystring'                    
        ]; 
        if(!empty($conditions)){
            //debug($conditions);
            $this->paginate['conditions'] = $conditions;
        }           

        $businessPartners = $this->paginate($this->BusinessPartners);

        $this->set(compact('businessPartners'));
        $this->set('_serialize', ['businessPartners']);            
        

    }

    /**
     * View method
     *
     * @param string|null $id Business Partner id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $businessPartner = $this->BusinessPartners->get($id, [
            'contain' => ['Bills', 'ContractRates','ParentBusinessPartners', 'ChildBusinessPartners']
        ]);

        
        $this->set(compact('businessPartner'));
        $this->set('_serialize', ['businessPartner']);
    }
    
    private function merge_sub_partners($parent,$child){//depreciated
        if(empty($parent) and empty($child)){
            return false;
        }
        if(empty($parent)){ return $child;}
        if(empty($child)){ return $parent;}
        
        return array_merge($parent,$child);
        
        
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($parent_id = null)
    {
        $businessPartner = $this->BusinessPartners->newEntity();
        if ($this->request->is('post')) {
            $businessPartner = $this->BusinessPartners->patchEntity($businessPartner, $this->request->data);
            if ($this->BusinessPartners->save($businessPartner)) {
                $this->Flash->success(__('取引先を新規登録しました。'));
                
                if(empty($parent_id)){
                    return $this->redirect(['action' => 'view',$businessPartner->id]);
                }else{
                    return $this->redirect(['action' => 'view',$parent_id]);
                }
                
            } else {
                $this->Flash->error(__('取引先の新規登録に失敗しました。再度やり直してください。'));
            }
        }
        
        if(!empty($parent_id)){
            $businessPartner->parent_id = $parent_id;
            $businessPartner->is_work_place = 1;
        }
        
        $parentBusinessPartners = $this->BusinessPartners->ParentBusinessPartners->find('list')
            ->where(['is_client' => 1])->limit(200);        
        $this->set(compact('businessPartner','parentBusinessPartners'));
        $this->set('_serialize', ['businessPartner']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Business Partner id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null,$parent_id = null)
    {
        $businessPartner = $this->BusinessPartners->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $businessPartner = $this->BusinessPartners->patchEntity($businessPartner, $this->request->data);
            if ($this->BusinessPartners->save($businessPartner)) {
                $this->Flash->success(__('取引先情報を更新しました。'));

               if(empty($parent_id)){
                    return $this->redirect(['action' => 'view',$id]);
                }else{
                    return $this->redirect(['action' => 'view',$parent_id]);
                }
            } else {
                $this->Flash->error(__('取引先情報の更新に失敗しました。再度やり直してください。'));
            }
        }
        $parentBusinessPartners = $this->BusinessPartners->ParentBusinessPartners->find('list')
            ->where(['is_client' => 1])->limit(200);       
        $this->set(compact('businessPartner','parentBusinessPartners'));
        $this->set('_serialize', ['businessPartner']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Business Partner id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $businessPartner = $this->BusinessPartners->get($id);
        if ($this->BusinessPartners->delete($businessPartner)) {
            $this->Flash->success(__('選択した取引先情報を削除しました。'));
        } else {
            $this->Flash->error(__('取引先情報の削除に失敗しました。再度やり直してください。'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    function ajaxloadaddress(){
        

        
            // ajaxによる呼び出し？
            if($this->request->is("ajax")) {
              $zipcode = $_POST['zipcode'];
              
               
                   $table = TableRegistry::get('Zipcodes');
              
              $addressData = $table->find()
                ->select('address')
                ->where(['Zipcodes.zipcode like'=>$zipcode."%"])
                ->first();
             
 
            }

            //debug($addressData);die();
  
          $address = $addressData->address;      
                       
                
//      $result = array('address'=>$address);


        $this->set('result',$address);      
        
        
        
    }    
    
}
