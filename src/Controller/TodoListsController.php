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
            
            // $this->set('result',$list);
            return $this->response->withStringBody(json_encode($list));               

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
            
            return $this->response->withStringBody(json_encode(['list'=>$list,'response'=>$response]));
            // $this->set('result',['list'=>$list,'response'=>$response]);
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
            return $this->response->withStringBody(json_encode(['list'=>$list,'response'=>$response]));
            // $this->set('result',['list'=>$list,'response'=>$response]);            
        } 
    }


}
