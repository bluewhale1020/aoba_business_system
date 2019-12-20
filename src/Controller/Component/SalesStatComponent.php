<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * SalesStat component
 */
class SalesStatComponent extends Component
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
    }


    /**
     * 売上・粗利率
     * 
     * @param DateTime $start_date 期間初め
     * @param DateTime $end_date 期間終わり
     * 
     * @return array $data 統計用データ
     */
    public function getSalesProfit($start_date, $end_date)
    {
        // 指定の期間で、各月の売上と費用を取得
        $conditions[] = ["Orders.end_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

        $query = $this->Orders->find();
        $sum = $query
       ->select(['year' => 'YEAR(end_date)','month' => 'MONTH(end_date)',
       'sales' => $query->func()->sum('guaranty_charge + additional_count * additional_unit_price + other_charge'),
       'cost' => $query->func()->sum('transportable_equipment_cost + image_reading_cost + transportation_cost + travel_cost + labor_cost')            
       ])
       ->matching('Works', function($q) {
        return $q->where(['Works.done' => 1]);
        })           
       ->where($conditions)
       ->group(['year' => 'YEAR(end_date)','month' => 'MONTH(end_date)'])
       ->all()->toArray();        
       
       // 各月の粗利率（売上ー費用／売上）を計算して各要素に追加
        foreach ($sum as $key => $row) {
            $profit_margin = ($row['sales'] - $row['cost'])/$row['sales'] * 100;
            $sum[$key]['rowdata'] = [$row['sales'],$profit_margin];
        }
        // debug($sum);
       // グラフデータ用に整形
       $data = Hash::combine($sum, '{n}.month', '{n}.rowdata','{n}.year');
        
    //    debug($data);
        // データを返す
        return $data;        
    }

    /**
     * 受注数
     * 
     * @param DateTime $start_date 期間初め
     * @param DateTime $end_date 期間終わり
     * 
     * @return array $data 統計用データ
     */    
    public function getOrderCount($start_date, $end_date)
    {
        // 指定の期間で、各月の受注数を取得
        $conditions[] = ["Orders.start_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

        $query = $this->Orders->find();
        $counts = $query
       ->select(['year' => 'YEAR(start_date)','month' => 'MONTH(start_date)',
       'count' => $query->func()->count('*')
        ])          
       ->where($conditions)
       ->group(['year' => 'YEAR(start_date)','month' => 'MONTH(start_date)'])
       ->all()->toArray();        

        // debug($counts);
       // グラフデータ用に整形
       $data = Hash::combine($counts, '{n}.month', '{n}.count','{n}.year');
        
        //    debug($data);
        // データを返す
        return $data;         
    }

    /**
     * フィルムサイズ受注数
     * 
     * @param DateTime $start_date 期間初め
     * @param DateTime $end_date 期間終わり
     * 
     * @return array $data 統計用データ
     */    
    public function getOrderCountForFilmsizes($start_date, $end_date)
    {
        // フィルムサイズごとに、指定の期間で、各月の受注数を取得
        $conditions[] = ["Orders.start_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

        $query = $this->Orders->find();
        $counts = $query
       ->contain(['FilmSizes'])
       ->select(['FilmSizes.name',
       'count' => $query->func()->count('*')
        ])          
       ->where($conditions)
       ->group(['FilmSizes.name'])
       ->all()->toArray();
        
       $result = Hash::map($counts, "{n}", function($row){
            $row['name'] = $row['film_size']['name'];
            unset($row['film_size']);
            return $row;
       });
       // データを返す
        return $result;
    }

    /**
     * 業務別売上・粗利率
     * 
     * @param DateTime $start_date 期間初め
     * @param DateTime $end_date 期間終わり
     * 
     * @return array $data 統計用データ
     */    
    public function getSalesProfitForWorkContents($start_date, $end_date)
    {
        // 指定の期間で、業務内容別売上と費用を取得
        $conditions[] = ["Orders.end_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

        $query = $this->Orders->find();
        $sum = $query
        ->contain(['WorkContents'])
        ->select([
        'WorkContents.description',
        'sales' => $query->func()->sum('guaranty_charge + additional_count * additional_unit_price + other_charge'),
        'cost' => $query->func()->sum('transportable_equipment_cost + image_reading_cost + transportation_cost + travel_cost + labor_cost')            
        ])
        ->matching('Works', function($q) {
        return $q->where(['Works.done' => 1]);
    })           
    ->where($conditions)
    ->group(['WorkContents.description'])
    ->order(['sales'=>'DESC'])
    ->limit(5)
    ->all()->toArray();        
       
       // 業務内容ことに粗利率（売上ー費用／売上）を計算して各要素に追加
       $result = [];
       foreach ($sum as $key => $row) {
           $temp = [];
           $profit_margin = ($row['sales'] - $row['cost'])/$row['sales'] * 100;
            $temp['rowdata'] = [$row['sales'],$profit_margin];

            $temp['name'] = $row['work_content']['description'];
            $result[] = $temp;           
        } 
        // データを返す
        return $result; 
        
        
    }

    /**
     * 顧客別売上・粗利率
     * 
     * @param DateTime $start_date 期間初め
     * @param DateTime $end_date 期間終わり
     * 
     * @return array $data 統計用データ
     */    
    public function getSalesProfitForPartners($start_date, $end_date)
    {
        // 指定の期間で、顧客別売上と費用を取得
        $conditions[] = ["Orders.end_date BETWEEN '".$start_date->format("Y-m-1")."' AND '".$end_date->format("Y-m-t")."'"]; 

        $query = $this->Orders->find();
        $sum = $query
        ->contain(['Clients'])
        ->select([
        'Clients.name',
        'sales' => $query->func()->sum('guaranty_charge + additional_count * additional_unit_price + other_charge'),
        'cost' => $query->func()->sum('transportable_equipment_cost + image_reading_cost + transportation_cost + travel_cost + labor_cost')            
        ])
        ->matching('Works', function($q) {
        return $q->where(['Works.done' => 1]);
    })           
    ->where($conditions)
    ->group(['Clients.name'])
    ->order(['sales'=>'DESC'])
    ->limit(5)
    ->all()->toArray();        
       
       // 顧客ことに粗利率（売上ー費用／売上）を計算して各要素に追加
       $result = [];
       foreach ($sum as $key => $row) {
           $temp = [];
           $profit_margin = ($row['sales'] - $row['cost'])/$row['sales'] * 100;
            $temp['rowdata'] = [$row['sales'],$profit_margin];

            $temp['name'] = $row['client']['name'];
            $result[] = $temp;           
        } 
        // データを返す
        return $result;                
    }  


    /**
     * グラフのX軸データを期間から作成
     * 
     * @param integer $start_year 期間開始年
     * @param integer $start_mon 期間開始月
     * @param integer $end_year 期間終了年
     * @param integer $end_mon 期間終了月
     * 
     * @return array $x_scale X軸データ
     */     
    public static function createXScaleForGraphdata($start_year,$start_mon,$end_year,$end_mon)
    {   
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

        return $x_scale;
    }

    /**
     * 取得した統計データをX軸データに合わせてグラフデータを生成
     * 
     * @param array $x_scale X軸データ
     * @param array $statdata 統計データ
     * @param string $datalabel データ配列のキー
     * @param string $default_data データが無いときのデフォルト値
     * 
     * @return array $data 時間系列グラフデータ
     */         
    public static function getTimeSerialGraphdata($x_scale,$statdata,$datalabel = "rowdata",$default_data = 0)
    {
        $data = [];
        foreach ($x_scale as $year => $months) {
            foreach ($months as $key => $month) {
                $temp = ["year"=>$year,"month"=>$month,$datalabel=>$default_data];
                if(!empty($statdata[$year][$month])){
                    if(!empty($statdata[$year][$month][$datalabel])){
                        $temp[$datalabel] = $statdata[$year][$month][$datalabel];
                    }else{
                        $temp[$datalabel] = $statdata[$year][$month];

                    }
                }
                $data[] = $temp;
            }
        }
        return $data;        
    }


}
