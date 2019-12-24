<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SalesStatComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Component\SalesStatComponent Test Case
 */
class SalesStatComponentTest extends TestCase
{

    public $fixtures = [  
        'app.business_partners2',         
        'app.orders4',  
        'app.works5',  
        'app.film_sizes',
        'app.work_contents'
    ];    
    /**
     * Test subject
     *
     * @var \App\Controller\Component\SalesStatComponent
     */
    public $SalesStatComponent;


    public $date_series = [];
    public $time_table = [];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->SalesStatComponent = new SalesStatComponent($registry);

        if(empty($this->date_series)){

            $today = new \DateTime();
            $early = Clone $today;
            $earlier = Clone $today;
            $late = Clone $today;
    
            $this->date_series['today'] = $today;
            $this->date_series['earlier'] = $earlier->modify('-2 month');        
            $this->date_series['early'] = $early->modify('-1 month');        
            $this->date_series['late'] = $late->modify('+1 month'); 
            
            $this->time_table = [
                ["year"=>$earlier->format("Y"),"month"=>$earlier->format("n")],
                ["year"=>$early->format("Y"),"month"=>$early->format("n")],
                ["year"=>$today->format("Y"),"month"=>$today->format("n")],
                ["year"=>$late->format("Y"),"month"=>$late->format("n")],
            ];
        }
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SalesStatComponent);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSalesProfit method
     *
     * @return void
     */
    public function testGetSalesProfit()
    {
        $start_date = $this->date_series['earlier'];
        $end_date = $this->date_series['late'];
        $result = $this->SalesStatComponent->getSalesProfit($start_date, $end_date);

        $expected = [
            $this->time_table[0] + ['rowdata'=>[30000,53.33]],
            $this->time_table[1] + ['rowdata'=>[15000,56.66]],
            $this->time_table[2] + ['rowdata'=>[15000,56.66]],          
        ];
        $expected = Hash::combine($expected, '{n}.month', '{n}.rowdata','{n}.year');

        foreach ($expected as $year => $yeardata) {
            foreach ($yeardata as $month => $monthdata) {
                $this->assertEquals($monthdata[0],$result[$year][$month][0]);    
                $this->assertEquals($monthdata[1], $result[$year][$month][1], '', 0.1);           
            }
        }

    }

    /**
     * Test getOrderCount method
     *
     * @return void
     */
    public function testGetOrderCount()
    {
        $start_date = $this->date_series['earlier'];
        $end_date = $this->date_series['late'];
        $result = $this->SalesStatComponent->getOrderCount($start_date, $end_date);

        $expected = [
            $this->time_table[0] + ['count'=>2],
            $this->time_table[1] + ['count'=>1],
            $this->time_table[2] + ['count'=>3],      
            $this->time_table[3] + ['count'=>2],      
        ];
        $expected = Hash::combine($expected, '{n}.month', '{n}.count','{n}.year');

        foreach ($expected as $year => $yeardata) {
            foreach ($yeardata as $month => $monthdata) {
                $this->assertEquals($monthdata,$result[$year][$month]);              
            }
        }

    }

    /**
     * Test getOrderCountForFilmsizes method
     *
     * @return void
     */
    public function testGetOrderCountForFilmsizes()
    {

        $start_date = $this->date_series['earlier'];
        $end_date = $this->date_series['late'];
        $result = $this->SalesStatComponent->getOrderCountForFilmsizes($start_date, $end_date);

        $expected = [
            ['rowdata'=>3,'name'=>'100mm'],
            ['rowdata'=>2,'name'=>'DR'],
            ['rowdata'=>1,'name'=>'四つ切'],
            ['rowdata'=>2,'name'=>'大角'],
        ];
        foreach ($expected as $key => $row) {
            $this->assertEquals($row,$result[$key]->toArray());
        }

    }

    /**
     * Test getSalesProfitForWorkContents method
     *
     * @return void
     */
    public function testGetSalesProfitForWorkContents()
    {
        $start_date = $this->date_series['earlier'];
        $end_date = $this->date_series['late'];
        $result = $this->SalesStatComponent->getSalesProfitForWorkContents($start_date, $end_date);

        $expected = [
            ['name'=>'撮影','rowdata'=>[45000,56.66]],
            ['name'=>'貸出','rowdata'=>[15000,50]],
                   
        ];

        foreach ($expected as $key => $data) {

            $this->assertEquals($data['rowdata'][0],$result[$key]['rowdata'][0]);    
            $this->assertEquals($data['rowdata'][1], $result[$key]['rowdata'][1], '', 0.1);           

        }

    }

    /**
     * Test getSalesProfitForPartners method
     *
     * @return void
     */
    public function testGetSalesProfitForPartners()
    {
        $start_date = $this->date_series['earlier'];
        $end_date = $this->date_series['late'];
        $result = $this->SalesStatComponent->getSalesProfitForPartners($start_date, $end_date);

        $expected = [
            ['name'=>'会社１','rowdata'=>[30000,56.66]],
            ['name'=>'会社３','rowdata'=>[15000,56.66]],                               
            ['name'=>'会社２','rowdata'=>[15000,50]],
        ];
        debug($result);
        foreach ($expected as $key => $data) {

            $this->assertEquals($data['rowdata'][0],$result[$key]['rowdata'][0]);    
            $this->assertEquals($data['rowdata'][1], $result[$key]['rowdata'][1], '', 0.1);           

        }
    }

    /**
     * Test createXScaleForGraphdata method
     *
     * @return void
     */
    public function testCreateXScaleForGraphdata()
    {
        $start_year = 2019;
        $start_mon = 10;
        $end_year = 2020;
        $end_mon = 2;

        $result = $this->SalesStatComponent->createXScaleForGraphdata($start_year,$start_mon,$end_year,$end_mon);
        $expected = [
            2019=>[10,11,12],
            2020=>[1,2],
        ];
        // debug($result);
        $this->assertEquals($expected,$result);
    }

    /**
     * Test getTimeSerialGraphdata method
     *
     * @return void
     */
    public function testGetTimeSerialGraphdata()
    {
        $end_year = 2020;
        $end_mon = 2;
        $statdata = [
            '2019'=>['11'=>['rowdata'=>5]],
            '2020'=>['1'=>['rowdata'=>4],
                     '2'=>['rowdata'=>3]],
        ];
        $x_scale = [
            '2019'=>[10,11,12],
            '2020'=>[1,2],
        ];
        $result = $this->SalesStatComponent->getTimeSerialGraphdata($x_scale,$statdata,"rowdata",0);
        $expected = [
            ["year"=>2019,"month"=>10,'rowdata'=>0],
            ["year"=>2019,"month"=>11,'rowdata'=>5],
            ["year"=>2019,"month"=>12,'rowdata'=>0],
            ["year"=>2020,"month"=>1,'rowdata'=>4],
            ["year"=>2020,"month"=>2,'rowdata'=>3],
        ];
        debug($result);
        $this->assertEquals($expected,$result);

    }
}
