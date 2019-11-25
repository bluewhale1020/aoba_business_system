<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdersTable Test Case
 */
class OrdersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdersTable
     */
    public $Orders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders2',
        // 'app.clients',
        // 'app.work_places',
        'app.bills2',
        'app.business_partners',
        'app.contract_rates',
        'app.work_contents',
        'app.capturing_regions',
        'app.works2'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Orders') ? [] : ['className' => 'App\Model\Table\OrdersTable'];
        $this->Orders = TableRegistry::get('Orders', $config);
    }


    public function testFormatTime(){
        $rowdata['開始時間'] = "10:00";
        $rowdata['終了時間'] = "9:3";

        $result = $this->Orders->format_time($rowdata);
        $expected = [
            '開始時間' => '10:00:00',
            '終了時間' => '09:03:00',
        ];
        $this->assertEquals($expected, $result);

        $rowdata['開始時間'] = null;
        $rowdata['終了時間'] = "";

        $result = $this->Orders->format_time($rowdata);
        $expected = [
            '開始時間' => null,
            '終了時間' => '',
        ];
        $this->assertEquals($expected, $result);

        $rowdata['開始時間'] = "10:00:00";
        $rowdata['終了時間'] = "9:3:00";

        $result = $this->Orders->format_time($rowdata);
        $expected = [
            '開始時間' => '10:00:00',
            '終了時間' => '09:03:00',
        ];
        $this->assertEquals($expected, $result);

        
    }


    public function testGetCalendarData(){
        // 2019/9/1,2019/9/30			3件	
        // 2019/10/1,2019/10/31			8件	
        // 2019/11/1,2019/11/30			5件	
        // 2019/12/1,2019/12/31			2件	
        
        
        $start_date = "2019/9/1";
        $end_date = "2019/9/30";

        $result = $this->Orders->get_calendar_data($start_date, $end_date);
        $expected = 3;

        $this->assertEquals($expected, count($result)); 
        
        $start_date = "2019/10/1";
        $end_date = "2019/10/31";

        $result = $this->Orders->get_calendar_data($start_date, $end_date);
        $expected = 8;

        $this->assertEquals($expected, count($result));  
        
        $start_date = "2019/11/1";
        $end_date = "2019/11/30";

        $result = $this->Orders->get_calendar_data($start_date, $end_date);
        $expected = 5;

        $this->assertEquals($expected, count($result));  
        
        $start_date = "2019/12/1";
        $end_date = "2019/12/31";

        $result = $this->Orders->get_calendar_data($start_date, $end_date);
        $expected = 2;

        $this->assertEquals($expected, count($result));  
        
        
    }

    public function testGetTotalSales(){
       
        $start_date = new \DateTime("2019/9/1");
        $end_date = new \DateTime("2019/9/30");

        $result = $this->Orders->get_total_sales($start_date, $end_date);
        $sales = 40000;
        $cost = 10000;
        $this->assertEquals($sales, $result->sales);
        $this->assertEquals($cost, $result->cost);

        $start_date = new \DateTime("2019/10/1");
        $end_date = new \DateTime("2019/10/31");

        $result = $this->Orders->get_total_sales($start_date, $end_date);
        $sales = 160000;
        $cost = 40000;
        $this->assertEquals($sales, $result->sales);
        $this->assertEquals($cost, $result->cost);

        $start_date = new \DateTime("2019/11/1");
        $end_date = new \DateTime("2019/11/30");

        $result = $this->Orders->get_total_sales($start_date, $end_date);
        $sales = 20000;
        $cost = 5000;
        $this->assertEquals($sales, $result->sales);
        $this->assertEquals($cost, $result->cost);

        $start_date = new \DateTime("2019/12/1");
        $end_date = new \DateTime("2019/12/31");

        $result = $this->Orders->get_total_sales($start_date, $end_date);
        $sales = 0;
        $cost = 0;
        $this->assertEquals($sales, $result->sales);
        $this->assertEquals($cost, $result->cost);
    }

    public function testGetChargedOrderCount(){
        // 2019/9/1,2019/9/30			    2	2	2
        // 2019/10/1,2019/10/31			6	6	4
        // 2019/11/1,2019/11/30			4	1	0
        // 2019/12/1,2019/12/31			2	0	0
        

        $start_date = new \DateTime("2019/9/1");
        $end_date = new \DateTime("2019/9/30");

        $result = $this->Orders->get_charged_order_count($start_date, $end_date);
        $total = 2;
        $charged = 2;
        $this->assertEquals($total, $result['total']);
        $this->assertEquals($charged, $result['charged']);

        $start_date = new \DateTime("2019/10/1");
        $end_date = new \DateTime("2019/10/31");

        $result = $this->Orders->get_charged_order_count($start_date, $end_date);
        $total = 8;
        $charged = 6;
        $this->assertEquals($total, $result['total']);
        $this->assertEquals($charged, $result['charged']);

        $start_date = new \DateTime("2019/11/1");
        $end_date = new \DateTime("2019/11/30");

        $result = $this->Orders->get_charged_order_count($start_date, $end_date);
        $total = 1;
        $charged = 0;
        $this->assertEquals($total, $result['total']);
        $this->assertEquals($charged, $result['charged']);

        $start_date = new \DateTime("2019/12/1");
        $end_date = new \DateTime("2019/12/31");

        $result = $this->Orders->get_charged_order_count($start_date, $end_date);
        $total = 0;
        $charged = 0;
        $this->assertEquals($total, $result['total']);
        $this->assertEquals($charged, $result['charged']);

    }

    public function testSumSalesData(){
        // year:{month:sales}	2019	9	40000
        //                      2019	10	120000
        //                      2019	11	20000
        //                      2019	12	0
    
        

        $start_date = new \DateTime("2019/9/1");
        $end_date = new \DateTime("2019/12/31");

        $result = $this->Orders->sum_sales_data($start_date, $end_date);
        $expected = [
            '2019' => [
                '9'=>40000.0,
                '10'=>160000.0,
                '11'=>20000.0,
            ]
        ];

        $this->assertEquals($expected, $result);



    }

    public function testSortAccountReceivableData(){

        $order_data = [
        [1,1,1,'payer1',20000,16000,4000],
        [2,2,2,'payer2',20000,16000,4000],
        [3,2,3,'payer2',10000,8000,2000],];
        $bill_data = [
          '1'=>[1,44000,'2019-09-15'],
          '2'=>[2,44000,'2019-10-10'],
          '3'=>[3,22000,'']
        ];
        $orders = [];
        foreach ($order_data as $key => $row) {
            $order = $this->Orders->newEntity([
                    'id'=>$row[0],
                    'payer_id'=>$row[1],
                    'bill_id'=>$row[2],
                    'payer_name'=>$row[3],
                    'guaranty_charge'=>$row[4],
                    'additional_charge'=>$row[5],
                    'other_charge'=>$row[6],
                    'bill' => [
                        'id' => $bill_data[$row[2]][0],
                        'total_charge' => $bill_data[$row[2]][1],
                        'received_date' => $bill_data[$row[2]][2],
                    ]   
            ]);
            // debug($order);
            $orders[] = $order;

        }

        $result = $this->Orders->sort_account_receivable_data($orders);
        $expected = [
            '1' => [
                'payer_name'=>'payer1',
                'sales'=>44000,
                'charged'=>44000,
                'received'=>44000,
            ],
            '2' => [
                'payer_name'=>'payer2',
                'sales'=>66000,
                'charged'=>66000,
                'received'=>44000,
            ]
        ];

        $this->assertEquals($expected, $result);



    }

    public function testFindAccountReceivableData(){
        // bill_id	payer_id	payer_name	            guaranty_charge	received_date	is_charged
        // 1	1	一般財団法人野分記念医学財団　富井診療所	10000	    2019/10/25	        1
        // 2	1	一般財団法人野分記念医学財団　富井診療所	10000	    2019/11/7	        1
        // ""	1	一般財団法人野分記念医学財団　富井診療所	10000	                            
        // 2	4	青葉金融	                               10000      2019/11/7            1
        // 3	4	青葉金融	                               10000		                   1
        // ""	4	青葉金融	                               10000		


        $conditions[] = ["Orders.end_date BETWEEN '2019-10-1' AND '2019-10-31'"];

        $query = $this->Orders->find_account_receivable_data($conditions);

        $result = $query->order([
            'payer_id' => 'ASC',
            'is_charged' => 'ASC',           
            'Bills.total_charge' => 'ASC'               
           ])->all();
        // debug($result);
        $expected =[
            ["",1,'一般財団法人野分記念医学財団　富井診療所',10000,'',0],
            [1,1,'一般財団法人野分記念医学財団　富井診療所',10000,'2019/10/25',1],
            [2,1,'一般財団法人野分記念医学財団　富井診療所',30000,'2019/11/7',1],
            ["",4,'青葉金融',10000, '',0],
            [3,4,'青葉金融',20000,'',1],];
        foreach ($result as $key => $record) {
            $correct = $expected[$key];
            // debug($correct);debug($record);debug($bill_id.' '.$record->payer_id);
            $this->assertEquals($correct[2], $record->payer_name);        
            $this->assertEquals($correct[3], $record->guaranty_charge);        
            $this->assertEquals($correct[5], $record->is_charged);        
        }

    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orders);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    // public function testInitialize()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test validationDefault method
    //  *
    //  * @return void
    //  */
    // public function testValidationDefault()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test buildRules method
    //  *
    //  * @return void
    //  */
    // public function testBuildRules()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
