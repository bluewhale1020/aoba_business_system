<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\DateComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\DateComponent Test Case
 */
class DateComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\DateComponent
     */
    public $Date;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Date = new DateComponent($registry);
    }

    /**
     * setIndexDefaultDateRange method
     *
     * @return void
     */
    public function testSetIndexDefaultDateRange(){

        $startDate = new \DateTime();
        $endDate = (new \DateTime())->modify("+2 months");
        $request_data = ['item'=>'data'];
        $conditions = [['test line']];

        list($request_data, $conditions) = $this->Date->setIndexDefaultDateRange($request_data,$conditions);
        $expected_request = [
            'item'=>'data',
            'start_date' => $startDate->format("Y-m-1"),
            'end_date' => $endDate->format("Y-m-t"),
            'date_range' => $startDate->format("Y/m/1")." - ".$endDate->format("Y/m/t")
        ];
        $expected_cond = [
            ['test line'],
            ['start_date >=' => $startDate->format("Y-m-1")],
            ['start_date <=' => $endDate->format("Y-m-t")]
        ];
        $this->assertEquals($expected_request,$request_data);
        $this->assertEquals($expected_cond,$conditions);

    }

    /**
     * testGetGivenHolidays method
     *
     * @return void
     */
    public function testGetHolidayCount(){

        $start = '2019-11-01';
        $end = '2019-11-30';
        $week = [0,6];//日土
        $given_holidays = ['2019-11-01','2019-11-17','2020-11-05'];

        $result = $this->Date->getHolidayCount($start, $end, $week,$given_holidays, true);
        $expected = 9+1+1;
        $this->assertEquals($expected,$result);


    }


    /**
     * testGetWeekdays method
     *
     * @return void
     */
    public function testGetWeekdays(){

        $diffDays = 30;
        $week = [1,6];
        $firstWeekday = 5;

        $result = $this->Date->getWeekdays($diffDays,$week, $firstWeekday);
        $expected = 9;
        $this->assertEquals($expected,$result);

        $diffDays = 30;
        $week = [2,3,4];
        $firstWeekday = 2;
        
        $result = $this->Date->getWeekdays($diffDays,$week, $firstWeekday);
        $expected = 14;
        $this->assertEquals($expected,$result);

        $diffDays = 30;
        $week = [5,6];
        $firstWeekday = 0;
        
        $result = $this->Date->getWeekdays($diffDays,$week, $firstWeekday);
        $expected = 8;
        $this->assertEquals($expected,$result);

    }


    /**
     * testGetGivenHolidays method
     *
     * @return void
     */
    public function testGetGivenHolidays(){

        $start = '2019-10-01';
        $end = '2019-10-31';
        $denyWeek = [1,6];//月土
        $given_holidays = ['2019-05-02','2019-9-30','2019-10-01','2019-10-05','2019-10-22','2019-10-31','2019-11-01'];

        $result = $this->Date->getGivenHolidays($start, $end, $denyWeek,$given_holidays);
        $expected = 3;
        $this->assertEquals($expected,$result);


    }

    /**
     * testGetHolidayList method
     *
     * @return void
     */
    public function testGetHolidayList(){
        $date_start = '2019-11-01';
        $date_end = '2019-11-30';
        $denyWeek = [0];

        $result = $this->Date->getHolidayList($date_start, $date_end,$denyWeek);
        $expected = 2;
        $this->assertEquals($expected, count($result));

        $date_start = '2019-11-01';
        $date_end = '2019-11-30';
        $denyWeek = [0,6];

        $result = $this->Date->getHolidayList($date_start, $date_end,$denyWeek);
        $expected = 1;
        $this->assertEquals($expected, count($result));
    }


    /**
     * tearDown method
     *
     * @return void
     */    
    public function testgetFiscalYear(){

        $strDate = '2019-10-10';
        $result = $this->Date->getFiscalYear($strDate);
        $expected = 2019;
        $this->assertEquals($expected,$result);
        
        $strDate = '2019-2-20';
        $result = $this->Date->getFiscalYear($strDate);
        $expected = 2018;
        $this->assertEquals($expected,$result);

        $strDate = '2019-4-1';
        $result = $this->Date->getFiscalYear($strDate);
        $expected = 2019;
        $this->assertEquals($expected,$result);

        $strDate = '2019-3-31';
        $result = $this->Date->getFiscalYear($strDate);
        $expected = 2018;
        $this->assertEquals($expected,$result);

    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Date);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
