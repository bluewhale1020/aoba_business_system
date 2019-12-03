<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
        $this->EquipmentRentals = TableRegistry::get('EquipmentRentals');

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

    function ajaxloadoperationnumbers(){

        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $start_year = (int)$this->request->data['start_year'];
            $start_mon = (int)$this->request->data['start_mon'];
            $end_year = (int)$this->request->data['end_year'];
            $end_mon = (int)$this->request->data['end_mon'];

            //グラフのX軸データを期間から作成
            $m = $start_mon;
            $y = $start_year;
            $x_scale = [];
            while($end_year > $y || ($end_year === $y && $end_mon >= $m) ){
                $x_scale[$y][] = $m;
                $m++;
              if($m > 12){ // loop to the next year
                $m = 1;
                $y++;
              }
            }            


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
            foreach ($x_scale as $year => $months) {
                foreach ($months as $key => $month) {
                    $temp = ["year"=>$year,"month"=>$month,"counts"=>[0,0,0,0,0,0,0,0,0,0]];
                    if(!empty($counts[$year][$month])){
                        $temp['counts'] = $counts[$year][$month]['counts'];
                    }
                    $data[] = $temp;
                }
            }

            return $this->response->withStringBody(json_encode(['chartdata'=>$data]));            
            // $this->set('result',['chartdata'=>$data]);      

        }
  
}  

}
