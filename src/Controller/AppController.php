<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

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

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('PagingSupport');        
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'], // この行を追加
            'loginRedirect' => [
                'controller' => 'Dashboards',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
    if(!$this->request->is('ajax')){
            $this->viewBuilder()->theme('AdminLTE');
            // $this->viewBuilder()->setTheme('AdminLTE');
            // Overwrite AppView class
            $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
            $this->set('theme', Configure::read('Theme'));   
            
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        
        $this->set('Auth', $this->Auth);

    }   

        

    }

    public function isAuthorized($user)
    {
        // admin,userはすべての操作にアクセスできます
        if (isset($user['role']) && \in_array($user['role'],['admin','user'])) {
            return true;
        }
    
        // デフォルトは拒否
        return false;
    }

    public function beforeFilter(Event $event)
    {
        $isAuth = $this->request->session()->read('Auth.User');
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' and !$isAuth){        
            $this->autoRender = false;
            $this->response->charset('UTF-8');
            $this->response->type('json');
            $this->response->statusCode(400);
            echo json_encode(['message' => __('セッション期間が過ぎています。再度ログインしてください。')]);
            return $this->response;
        }

        if(!$isAuth and $this->request->getParam('action') != 'login'){
            $this->Flash->error(__('セッション期間が過ぎています。再度ログインしてください。'));
        } 

        Configure::write('user_id',$isAuth['id']);
        
        return parent::beforeFilter($event);
    }


}
