<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Notifications component
 */
class NotificationsComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config) {
        /*初期処理*/
        $this->Orders = TableRegistry::get('Orders');        
        $this->Bills = TableRegistry::get('Bills');        
    }    

    public function getNotificationInfo(){
        // 以下のデータを取得
        // 間近の未確定注文
        $unconfirmed_orders = $this->getUnconfirmedOrders();
        // 期間終了未完了作業
        $unfinished_works = $this->getUnfinishedWorks();
        // 完了未請求注文
        $unbilled_orders = $this->getUnbilledOrders();
        // 締切後未回収請求
        $unpaid_bills = $this->getUnpaidBills();    
        // 総件数を計算
        $totalcount = \count($unconfirmed_orders) + \count($unfinished_works) + \count($unbilled_orders) + \count($unpaid_bills);
        // 件数とデータを返す        
        $notifications = [
            'totalcount'=>$totalcount,
            'unconfirmed_orders'=>$unconfirmed_orders,
            'unfinished_works'=> $unfinished_works,
            'unbilled_orders'=> $unbilled_orders,
            'unpaid_bills'=> $unpaid_bills
        ];

        return $notifications;

    }

    // 間近の未確定注文
    public function getUnconfirmedOrders(){
        // 開始日1週間前過ぎた未確定の注文データを返す
        $targetDate = new \DateTime();
        $targetDate->modify("+1 weeks");
        $conditions[] = ["Orders.start_date < '".$targetDate->format("Y-m-d")."'"];        
        $conditions[] = ["Orders.temporary_registration"=>1];        
        $orders = $this->Orders->find() 
        ->contain(['Clients'])           
        ->where($conditions)
        ->all();

        return $orders;
    }

    // 期間終了未完了作業
    public function getUnfinishedWorks(){
        // 終了日過ぎて未完了の注文データを返す
        $conditions[] = ["Orders.end_date < '".(new \DateTime())->format("Y-m-d")."'"];        
        $orders = $this->Orders->find()
        ->contain(['Works','WorkPlaces'])
        ->matching('Works', function($q) {
            return $q->where(['Works.done' => 0]);
            })           
        ->where($conditions)
        ->all();
        
        return $orders;        
        
    }

    // 完了未請求注文
    public function getUnbilledOrders(){
        // 作業完了後未請求の注文データを返す
        $orders = $this->Orders->find()
        ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })           
        ->contain(['Payers'])
        ->where(['is_charged'=>0])
        ->all();  
        
        return $orders;
    }

    // 締切後未回収請求
    public function getUnpaidBills(){
        // 締め切り日過ぎて未回収の請求データを返す 
        $conditions[] = ["Bills.due_date < '".(new \DateTime())->format("Y-m-d")."'"]; 
        $conditions[] = ['OR'=>['received_date IS' => null,'received_date =' => '']]; 
        $bills = $this->Bills->find()
        ->contain(['BusinessPartners'])        
        ->where($conditions)
        ->all();

        return $bills;
    }

}
