<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Utilities Controller
 *
 *
 * @method \App\Model\Entity\Utility[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UtilitiesController extends AppController
{
    public $components = ["Notifications"];

    // システム利用時に見落としがちな情報をまとめて
    // お知らせとしてユーザーに伝える
    public function ajaxloadnotifications(){
        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            // お知らせデータを取得
            $notifications = $this->Notifications->getNotificationInfo();

            // データを返す
            return $this->response->withStringBody(json_encode($notifications));                 

      
            // $this->set('result', $notifications);
        }
    }

}
