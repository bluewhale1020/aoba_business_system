<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * EventLogs Controller
 *
 * @property \App\Model\Table\EventLogsTable $EventLogs
 *
 * @method \App\Model\Entity\EventLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // 条件（作成期間・ユーザーID・アクション）で検索したログデータを
        // テーブルから取得
        $this->PagingSupport->inheritPostData();        
                
        if($this->request->is('post') or !empty($this->request->data)){
            //データを検索する
            $conditions = [];
            
            //user id
             if(!empty($this->request->data['ユーザー'])){
                $conditions[] = ['EventLogs.user_id '=> $this->request->data['ユーザー']]; 
            }           
            //期間
            if(!empty($this->request->data['date_range'])){
                $conditions[] = ['EventLogs.created >=' => $this->request->data['start_date']]; 
                  $conditions[] = ['EventLogs.created <=' => $this->request->data['end_date'].' 23:59:59'];              
            }
                        
            //action_type
            if(!empty($this->request->data['アクション'])){
                $conditions[] = ['EventLogs.action_type' => $this->request->data['アクション']]; 
               
            }           
                             
          
        }

        
        $this->paginate = [
            'limit' => 10,
            'contain'=>['Users'],
            'order' => [
                'created' => 'DESC',
            ],                
            'paramType' => 'querystring'                    
        ]; 
        if(!empty($conditions)){

            $this->paginate['conditions'] = $conditions;        
        }           
     
        $eventLogs = $this->paginate($this->EventLogs);

        $this->Users = TableRegistry::get('Users');
        $users = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'username'
        ])->all();

        $this->set(compact('eventLogs','users'));
    }

    /**
     * View method
     *
     * @param string|null $id Event Log id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $eventLog = $this->EventLogs->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('eventLog', $eventLog);
    }



    /**
     * Delete method
     *
     * @param string|null $id Event Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $eventLog = $this->EventLogs->get($id);
        if ($this->EventLogs->delete($eventLog)) {
            $this->Flash->success(__('The event log has been deleted.'));
        } else {
            $this->Flash->error(__('The event log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


   
}
