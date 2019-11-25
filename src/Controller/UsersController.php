<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $paginate = [
        'limit' => 5,
        // 'contain'=>['Users',"Categories"],
        'order' => [
            'Users.created' => 'desc'
        ],
        'paramType' => 'querystring'        
    ];

    /**
     * beforeFilter
     * @param  Event  $event イベントオブジェクト
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // ユーザーの登録とログアウトを許可します。
        // allow のリストに "login" アクションを追加しないでください。
        // そうすると AuthComponent の正常な機能に問題が発生します。
        $this->Auth->allow(['signup','logout']);
    }    

    public function isAuthorized($user)
    {
        // ユーザーは自分のview,editのみアクセス可能
        if (isset($user['role']) && $user['role'] === 'user') {
            $userId = (int)$this->request->getParam('pass.0');
            if ($this->request->getParam('action') === 'view' and $userId == $user['id']) {
                return true;
            }
            elseif ($this->request->getParam('action') === 'edit' and $userId == $user['id']) {
                return true;
            }            
            
            return false;
        }        
    
        return parent::isAuthorized($user);
    }    

        /**
     * Signup method
     *
     * @return void Redirects on successful signup, renders view otherwise.
     */
    public function signup()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            // debug($this->request->getData());die();
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('サインアップを実行しました。'));
                $this->Auth->setUser($user->toArray());
                return $this->redirect($this->Auth->redirectUrl());
                //return $this->redirect( '/' );
            } else {
                $this->Flash->error(__('サインアップに失敗しました。再度やり直してください。'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->viewBuilder()->layout('register');
    }

    public  function login()
        {
            if($this->request->is('post')){
                $user = $this->Auth->identify(); // Postされたユーザー名とパスワードをもとにデータベースを検索。ユーザー名とパスワードに該当するユーザーがreturnされる
         
                if ($user) { // 該当するユーザーがいればログイン処理
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                } else { // 該当するユーザーがいなければエラー
                    $this->Flash->error(__('ユーザー名かパスワードが間違っています！'));
                }

            }


            $this->viewBuilder()->layout('login');

        }



    /**
     * ログアウト
     * @return bool
     */
    public function logout()
    {

        // $this->request->session()->destroy(); // セッションの破棄
        return $this->redirect($this->Auth->logout()); // ログアウト処理
    }



    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->PagingSupport->inheritPostData();

        $query = $this->Users->find();
        if($this->request->is('post') or !empty($this->request->data)){
            //データを検索する
            // $conditions = [];
             
            

            //カテゴリ名
            if(!empty($this->request->data['table_search'])){
                $query->where(['username like' => '%' . $this->request->data['table_search'] . '%'])
                ->orWhere(['formal_name like' => '%' . $this->request->data['table_search'] . '%']);
                // $conditions[] = ['username like' => '%' . $this->request->data['table_search'] . '%']; 
                // $conditions[] = ["or"=>['formal_name like' => '%' . $this->request->data['table_search'] . '%']];
            
            }
         
            
            // if(!empty($conditions)){
            //     //debug($conditions);
            //         $this->paginate = [
            //             'conditions' => $conditions
            //         ]; 
            
            // }

        }         
        // debug($conditions);
        //$queryを渡してデータを取得
        $users = $this->paginate($query);        
        // $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー情報を保存しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('ユーザー情報の保存に失敗しました。再度実行してください。'));
        }
        $this->set(compact('user'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー情報を更新しました。'));

                return $this->redirect(['action' => 'view',$id]);
            }
            $this->Flash->error(__('ユーザー情報の更新に失敗しました。再度実行してください。'));
        }
        $this->set(compact('user'));
    }


    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The {0} has been deleted.', 'User'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'User'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
