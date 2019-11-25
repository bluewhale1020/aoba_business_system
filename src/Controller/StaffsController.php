<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 */
class StaffsController extends AppController
{

    public $paginate = [
        'limit' => 10,
        'contain'=>['Titles','Occupation1','Occupation2'],
        // 'order' => [
        //     'Users.created' => 'desc'
        // ]
    ];    

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        // debug("test");die();
        $this->PagingSupport->inheritPostData();

        $query = $this->Staffs->find();

        if($this->request->is('post') or !empty($this->request->data)){
            //データを検索する
            $conditions = [];
            $conditions2 = [];
            $noData = true;
            
            //職種
            if(!empty($this->request->data['職種'])){
                $conditions[] = ['occupation_id' => $this->request->data['職種']]; 
                $conditions2[] = ['occupation2_id' => $this->request->data['職種']];
                $noData = false;               
            }
            
            //肩書
            if(!empty($this->request->data['肩書'])){
                $conditions[] = ['title_id' => $this->request->data['肩書']];
                $conditions2[] = ['title_id' => $this->request->data['肩書']];  
                $noData = false;                                
            }            
            
            if(!$noData){
                $query
                ->where($conditions)
                ->orWhere($conditions2);                

                debug($conditions);
                debug($conditions2);
             
            }
           
            
        }


        $staffs = $this->paginate($query);
               
        $occupations = $this->Staffs->Occupation1->find('list', ['limit' => 200])->toArray();
        $titles = $this->Staffs->Titles->find('list', ['limit' => 200]);
        $this->set(compact('occupations','titles','staffs'));
        $this->set('_serialize', ['staffs']);            

        
    }

    /**
     * View method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $staff = $this->Staffs->get($id, [
            'contain' => ['Titles','Occupation1','Occupation2']
        ]);

         $this->set(compact('staff'));

        $this->set('_serialize', ['staff']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $staff = $this->Staffs->newEntity();
        if ($this->request->is('post')) {
            $staff = $this->Staffs->patchEntity($staff, $this->request->data);
            if ($this->Staffs->save($staff)) {
                $this->Flash->success(__('スタッフを新規に登録しました。'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('スタッフの新規登録に失敗しました。再度やり直してください。'));
            }
        }
        $occupations = $this->Staffs->Occupation1->find('list', ['limit' => 200]);
        $titles = $this->Staffs->Titles->find('list', ['limit' => 200]);
        $this->set(compact('staff', 'occupations', 'titles'));
        $this->set('_serialize', ['staff']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $staff = $this->Staffs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staff = $this->Staffs->patchEntity($staff, $this->request->data);
            if ($this->Staffs->save($staff)) {
                $this->Flash->success(__('スタッフの登録情報を更新しました。'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('スタッフの登録情報更新に失敗しました。再度やり直してください。'));
            }
        }
        $occupations = $this->Staffs->Occupation1->find('list', ['limit' => 200]);
        $titles = $this->Staffs->Titles->find('list', ['limit' => 200]);
        $this->set(compact('staff', 'occupations', 'titles'));
        $this->set('_serialize', ['staff']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $staff = $this->Staffs->get($id);
        if ($this->Staffs->delete($staff)) {
            $this->Flash->success(__('選択したスタッフ情報を削除しました。'));
        } else {
            $this->Flash->error(__('選択したスタッフ情報の削除に失敗しました。再度やり直してください。'));
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
