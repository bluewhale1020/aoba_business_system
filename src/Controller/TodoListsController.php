<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TodoLists Controller
 *
 * @property \App\Model\Table\TodoListsTable $TodoLists
 *
 * @method \App\Model\Entity\TodoList[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TodoListsController extends AppController
{


    public function ajaxloadlist(){

        if ($this->request->is("ajax")) {

            $list = $this->_get_todo_list();
            
            $this->set('result',$list);
        }

    }

    protected function _get_todo_list(){
        $list = $this->TodoLists->find()
        ->order(['done'=>'ASC','priority' => 'DESC'])
        ->all();
        
        return $list;
    }

    public function ajaxsavelistitem(){

        if ($this->request->is("ajax")) {

            if(!empty($this->request->data['id'])){
                $subject = '更新';
                $todoList = $this->TodoLists->get($this->request->data['id']);
            }else{
                $subject = '新規作成';
                $todoList = $this->TodoLists->newEntity();
            }
            if ($this->request->is('post')) {
                $todoList = $this->TodoLists->patchEntity($todoList, $this->request->getData());
                if ($this->TodoLists->save($todoList)) {
                    $response = ['result'=>1,'message'=>"リスト項目を${subject}しました。"];
                }else{
                    $response = ['result'=>0,'message'=>"リスト項目を${subject}できませんでした。"];
                }
            }            


            $list = $this->_get_todo_list();
            
            $this->set('result',['list'=>$list,'response'=>$response]);
        }

    }

    function ajaxdeletelistitem(){
        if ($this->request->is("ajax")) {
            $this->request->allowMethod(['post', 'delete']);
            $todoList = $this->TodoLists->get($this->request->data['id']);
            if ($this->TodoLists->delete($todoList)) {
                $response = ['result'=>1,'message'=>'リスト項目を削除しました。'];
            }else{
                $response = ['result'=>0,'message'=>'リスト項目を削除できませんでした。'];
            }
            $list = $this->_get_todo_list();
            
            $this->set('result',['list'=>$list,'response'=>$response]);            
        } 
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    // public function index()
    // {
    //     $todoLists = $this->paginate($this->TodoLists);

    //     $this->set(compact('todoLists'));
    // }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Todo List id.
    //  * @return \Cake\Http\Response|null
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $todoList = $this->TodoLists->get($id, [
    //         'contain' => []
    //     ]);

    //     $this->set('todoList', $todoList);
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $todoList = $this->TodoLists->newEntity();
    //     if ($this->request->is('post')) {
    //         $todoList = $this->TodoLists->patchEntity($todoList, $this->request->getData());
    //         if ($this->TodoLists->save($todoList)) {
    //             $this->Flash->success(__('The todo list has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The todo list could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('todoList'));
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Todo List id.
    //  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $todoList = $this->TodoLists->get($id, [
    //         'contain' => []
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $todoList = $this->TodoLists->patchEntity($todoList, $this->request->getData());
    //         if ($this->TodoLists->save($todoList)) {
    //             $this->Flash->success(__('The todo list has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The todo list could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('todoList'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Todo List id.
    //  * @return \Cake\Http\Response|null Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $todoList = $this->TodoLists->get($id);
    //     if ($this->TodoLists->delete($todoList)) {
    //         $this->Flash->success(__('The todo list has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The todo list could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
