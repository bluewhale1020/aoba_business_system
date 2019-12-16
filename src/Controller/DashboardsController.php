<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Dashboards Controller
 *
 *
 */
class DashboardsController  extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Orders = TableRegistry::get('Orders');

        $this->loadComponent('Date');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // 今月受注数・作業中・作業完了未請求レコードを集計
        $targetDate = new \DateTime();
        $conditions[] = ["Orders.start_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 

        // 今月受注数
        $stat['order_count'] = $this->Orders->find()
        ->where($conditions)
        ->count(); 
        // 作業実施中(未完了)
        $conditions2[] = [
            "Orders.temporary_registration"=>0,
            "Orders.start_date <= '".$targetDate->format("Y-m-d")."'",
            "Orders.end_date >= '".$targetDate->format("Y-m-d")."'"
        ]; 

        $stat['ongoing_count'] = $this->Orders->find()
        ->matching('Works', function($q) {
            return $q->where(['Works.done' => 0]);
            })          
        ->where($conditions2)
        ->count();   

        // 作業完了未請求
        $conditions3[] = ['OR'=>["Orders.is_charged != 1","Orders.is_charged IS NULL"] ]; 

        $stat['not_charged_count'] = $this->Orders->find()
        ->matching('Works', function($q) {
            return $q->where(['Works.done' => 1]);
            })
        ->where($conditions3)
        ->count();

        $this->paginate = [
            'limit' => 8,
            'contain'=>['Clients','WorkPlaces', 'Works','WorkContents','Bills'],
            'order' => [
                'CHAR_LENGTH(Orders.order_no)' => 'ASC',
                'cast(Orders.order_no as unsigned)' => 'ASC'
            ],                
            'paramType' => 'querystring'                    
        ];
        
        
        $query = $this->Orders->find()
        ->where(function($exp) {
            $or_query = $exp->or_(function($or) {
                return $or->isNull('is_charged')
                ->notEq('is_charged', '1');
            });
            return $exp
            ->add($or_query);            
        });
        
        $orders = $this->paginate($query);         

        $workContents = $this->Orders->WorkContents->find('list', ['limit' => 200])->toArray();

        $year = $this->Date->getFiscalYear();

        $this->set(compact('orders',  'workContents' ,'year','stat'));
        $this->set('_serialize', ['orders']);


    }

    function ajaxloadsalesdata(){

        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $start_year = (int)$this->request->data['start_year'];
            $start_mon = (int)$this->request->data['start_mon'];
            $end_year = (int)$this->request->data['end_year'];
            $end_mon = (int)$this->request->data['end_mon'];

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

            $sum = $this->Orders->sum_sales_data($start_date, $end_date);

            $data = [];
            // "[{"year":2019, "month":"10","sales":2500000}]"

            foreach ($x_scale as $year => $months) {
                foreach ($months as $key => $month) {
                    if(empty($sum[$year][$month])){
                        $data[] = ["year"=>$year,"month"=>$month,"sales"=>0];
                    }else{
                        $data[] = ["year"=>$year,"month"=>$month,"sales"=>$sum[$year][$month]];
                    }
                }
            }
            
            $order_count = $this->Orders->get_charged_order_count($start_date, $end_date);
            $total_sales = $this->Orders->get_total_sales($start_date, $end_date);
            
            return $this->response->withStringBody(json_encode(['chartdata'=>$data,'order_count'=>$order_count,'total_sales'=>$total_sales]));

            // $this->set('result',['chartdata'=>$data,'order_count'=>$order_count,'total_sales'=>$total_sales]);      

        }
  
}  


    function ajaxgetcalendarevents()
    {

        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $startDate = $this->request->data['startDate'];
            $endDate = $this->request->data['endDate'];

            $events = $this->Orders->get_calendar_data($startDate, $endDate);
            // $this->set('result',$events);return;
            // 取得データを整形して配列に再セット
            $eventList = [];
        
            foreach ($events as $event) {
                if ($event->works[0]->done) {
                    $color = 'grey';
                } else {
                    $color = '#3D9970';
                }
                $eventList[] = [
                    'id' => $event->works[0]->id,
                    'title' => $event->work_place->name,
                    // 'description' => $event->description,
                    'start' => $event->start_date->format("Y-m-d").((!empty($event->start_time) ? " ".$event->start_time->format("H:i:s")  : " 00:00")),
                    'end' => $event->end_date->format("Y-m-d").((!empty($event->end_time) ? " ".$event->end_time->format("H:i:s") : " 23:59")),
                    'color' => $color,
                    // 'textColor' => $event->calendar_text_color
                ];
                
            }
            
            return $this->response->withStringBody(json_encode($eventList));
            // $this->set('result',$eventList);
        }
    }   

}
