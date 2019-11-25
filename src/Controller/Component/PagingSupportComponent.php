<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * PagingSupport component
 */
class PagingSupportComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ["Session"];
    
    var $_controller = null;
    
    var $_sessionName = '';

    var $session;
    

      //beforeFileterの後に実行される
      public function startup(\Cake\Event\Event $event){

        
          // 現在のコントローラーに アクセス
        $this->_controller = $this->_registry->getController();
        // debug($this->_controller->request->params);

        $this->session = $this->_controller->request->getSession();

        $this->_sessionName = $this->_getSessionName( $this->_controller->request->params );

      }
 
    /**
     * controller->data の値の引き継ぎを行う
     */
    function inheritPostData(){
        
        if( !empty( $this->_controller->request->data ) ){
            $this->session->write( $this->_sessionName, $this->_controller->request->data );
        }
        elseif( !empty( $this->_controller->request->params['?']['usePaging'] ) && $this->session->check( $this->_sessionName ) ){
            $this->_controller->request->data = $this->session->read( $this->_sessionName );
        }
        else{
            $this->session->delete( $this->_sessionName );
        }   
    }
    
    /**
     * 現在引き継がれているPostDataを取得
     * @param $params = array( 'controller' => ..., 'action' => ... )
     * @return array
     */
    function getInheritPostdata( $params ){
        if( $this->session->check( $this->_getSessionName( $params ) ) ){
            return $this->session->read( $this->_getSessionName( $params ) );
        }
        else{
            return null;
        }
    }
    
    /**
     * SESSIONに使用する名前を取得
     */
    private function _getSessionName( $params ){
        return 'pagingSupport_' . $params['controller'] . $params['action'];
    }



}
