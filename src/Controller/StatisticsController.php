<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Controller\Component\SalesStatComponent;
/**
 * Statistics Controller
 *
 *
 * @method \App\Model\Entity\Statistic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatisticsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Date');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $year = $this->Date->getFiscalYear();

        $this->set(compact('year'));
    }

    /**
     * Sales analysis method
     *
     * @return \Cake\Http\Response|null
     */
    public function salesAnalysis()
    {
        $year = $this->Date->getFiscalYear();

        $this->set(compact('year'));
    }

    function ajaxloadoperationnumbers(){

        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $this->EquipmentRentals = TableRegistry::get('EquipmentRentals');

            $start_year = (int)$this->request->data['start_year'];
            $start_mon = (int)$this->request->data['start_mon'];
            $end_year = (int)$this->request->data['end_year'];
            $end_mon = (int)$this->request->data['end_mon'];

            //グラフのX軸データを期間から作成
            $x_scale = SalesStatComponent::createXScaleForGraphdata($start_year,$start_mon,$end_year,$end_mon);


            $start_date = new \DateTime($start_year."-".$start_mon."-1");
            $end_date =  new \DateTime($end_year."-".$end_mon."-1");
            
            //装置レンタルテーブルから稼働数データを取得
            $counts = $this->EquipmentRentals->getOperationInfo($start_date, $end_date);

            $data = [];                                        
            // (int) 2019 => [(int) 10 => ['counts' => [
            //             (int) 0 => (int) 2,
            //             (int) 1 => (int) 0,
            //             ~~~
            //             (int) 9 => (int) 0
            //  ] ]]
            //　取得した稼働数データをX軸データに合わせてグラフデータを生成
            $data = SalesStatComponent::getTimeSerialGraphdata($x_scale,$counts,"counts",[0,0,0,0,0,0,0,0,0,0]);
            // foreach ($x_scale as $year => $months) {
            //     foreach ($months as $key => $month) {
            //         $temp = ["year"=>$year,"month"=>$month,"counts"=>[0,0,0,0,0,0,0,0,0,0]];
            //         if(!empty($counts[$year][$month])){
            //             $temp['counts'] = $counts[$year][$month]['counts'];
            //         }
            //         $data[] = $temp;
            //     }
            // }

            return $this->response->withStringBody(json_encode(['chartdata'=>$data]));            
            // $this->set('result',['chartdata'=>$data]);      

        }
  
    }  

    public function ajaxgetsalesanalysis()
    {
        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
 
            $this->loadComponent('SalesStat');

            $start_year = (int)$this->request->data['start_year'];
            $start_mon = (int)$this->request->data['start_mon'];
            $end_year = (int)$this->request->data['end_year'];
            $end_mon = (int)$this->request->data['end_mon'];

            //グラフのX軸データを期間から作成
            $x_scale = SalesStatComponent::createXScaleForGraphdata($start_year, $start_mon, $end_year, $end_mon);


            $start_date = new \DateTime($start_year."-".$start_mon."-1");
            $end_date =  new \DateTime($end_year."-".$end_mon."-1");
            
            //売上分析データを取得する

            // 期間データを取得

            // 売上・粗利率グラフデータ
            $sales_profit = $this->SalesStat->getSalesProfit($start_date, $end_date); 
            //　取得した売上・粗利率データをX軸データに合わせてグラフデータを生成
            $sales_profit = SalesStatComponent::getTimeSerialGraphdata($x_scale,$sales_profit,'rowdata',[0,0]);

            // 受注数グラフデータ
            $order_count = $this->SalesStat->getOrderCount($start_date, $end_date);
            //　取得した受注数データをX軸データに合わせてグラフデータを生成
            $order_count = SalesStatComponent::getTimeSerialGraphdata($x_scale,$order_count);


            // フィルムサイズ受注数グラフデータ
            $order_count_filmsizes = $this->SalesStat->getOrderCountForFilmsizes($start_date, $end_date);

            // 顧客別売上・粗利率データ
            $sales_profit_partners = $this->SalesStat->getSalesProfitForPartners($start_date, $end_date);

            // 業務別売上・粗利率データ
            $sales_profit_workcontents = $this->SalesStat->getSalesProfitForWorkContents($start_date, $end_date);

            //売上分析用データを返す
            return $this->response->withStringBody(json_encode([
                'sales_profit'=>$sales_profit,
                'order_count'=>$order_count,
                'order_count_filmsizes'=>$order_count_filmsizes,
                'sales_profit_partners'=>$sales_profit_partners,
                'sales_profit_workcontents'=>$sales_profit_workcontents,
            ]));
        }

    }


}
