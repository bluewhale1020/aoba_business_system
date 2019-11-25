<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentRentalsTable;
use App\Model\Table\WorksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentRentalsTable Test Case
 */
class EquipmentRentalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentRentalsTable
     */
    public $EquipmentRentals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EquipmentRentals',
        'app.Orders2',
        'app.Works',
        'app.Equipments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EquipmentRentals') ? [] : ['className' => EquipmentRentalsTable::class];
        $this->EquipmentRentals = TableRegistry::getTableLocator()->get('EquipmentRentals', $config);
        $config = TableRegistry::getTableLocator()->exists('Works') ? [] : ['className' => WorksTable::class];
        $this->Works = TableRegistry::getTableLocator()->get('Works', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipmentRentals);
        unset($this->Works);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetOperationInfo(){
        $start_date = new \DateTime('2019-09-01');
        $end_date = new \DateTime('2019-12-31');

        $result = $this->EquipmentRentals->getOperationInfo($start_date, $end_date);
        // (int) 2019 => [(int) 10 => ['counts' => [
        //             (int) 0 => (int) 2,
        //             (int) 1 => (int) 0,
        //             ~~~
        //             (int) 9 => (int) 0
        //  ] ]]        
        $expected = [
            2019 =>[
                10=>['counts'=>[0,0,0,0,0,0,0,0,0,0]],
                11=>['counts'=>[0,3,0,0,0,0,0,0,5,0]],
                12=>['counts'=>[0,1,0,0,1,0,0,1,0,0]],
            ]
        ];
        // debug($result);
        $this->assertEquals($expected,$result );        
    }

    public function testGetCountIdx(){

        $reflection = new \ReflectionClass($this->EquipmentRentals);
        $method = $reflection->getMethod('get_count_idx');
        $method->setAccessible(true);

        // 1			2			3			4
        // 1	2	3	1	2	3	1	2	4	2
        // 0    1   2   3   4   5   6   7   8   9  

        $work_id = 6;$equipment_id=5;
        $expected = [
            0,1,2,-1,3,4,5,-1,6,7,-1,8,-1,9,-1,-1
        ];
        $idx = 0;
        for ($i=1; $i <= 4; $i++) { 
            for ($j=1; $j <= 4; $j++) { 
                $e_type_id=$i;$f_size_id=$j;
                $result = $method->invoke($this->EquipmentRentals,$e_type_id,$f_size_id);
                // $result = $this->EquipmentRentals->get_count_idx($e_type_id,$f_size_id);        
                $this->assertEquals($expected[$idx],$result);
                $idx++;
                
            }
        }

    }

    public function testSaveRentalPeriod(){

        $work = $this->Works->find()->where(['id' => 3])->first();
        $work->A_start_date = '2019-11-1';
        $work->A_end_date = '2019-11-3';
        $work->B_start_date = '2019-11-4';
        $work->B_end_date = '2019-11-5';
        $work->C_start_date = '2019-11-6';
        $work->C_end_date = '2019-11-7';
        // print($work->id);
        $this->EquipmentRentals->saveRentalPeriod($work); 

        $result = $this->EquipmentRentals->find()->select(['work_id','start_date','end_date','equipment_id'])
        ->where(['work_id' => 3])->order(['equipment_id'=>'ASC'])->toArray();
        debug($result);
        $expected = [
            ['work_id' => 3, 'start_date'=>'2019-11-01','end_date'=>'2019-11-03','equipment_id'=>13],
            ['work_id' => 3, 'start_date'=>'2019-11-04','end_date'=>'2019-11-05','equipment_id'=>14],
            ['work_id' => 3, 'start_date'=>'2019-11-06','end_date'=>'2019-11-07','equipment_id'=>15]
        ];
        // print(count($result));
        foreach ($result as $key => $eObj) {
            $this->assertEquals($expected[$key]['work_id'], $eObj->work_id);  // アサーション
            $this->assertEquals($expected[$key]['start_date'], $eObj->start_date->format('Y-m-d'));  // アサーション
            $this->assertEquals($expected[$key]['end_date'], $eObj->end_date->format('Y-m-d'));  // アサーション
            $this->assertEquals($expected[$key]['equipment_id'], $eObj->equipment_id);  // アサーション
            
        }


    }

    public function testHasOverlappingDates(){  
        
        $work = $this->EquipmentRentals->find()->where(['equipment_id' => 5])->first();
        // 'start_date' => '2019-10-7',
        // 'end_date' => '2019-10-9',

        $work = $this->EquipmentRentals->getRentalPeriod($work);
        $work_id = 6;$equipment_id=5;
        
        $start_date='2019-10-8';$end_date='2019-10-15';
        $result = $this->EquipmentRentals->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date);        
        $this->assertTrue($result);
        
        $start_date='2019-10-3';$end_date='2019-10-6';
        $result = $this->EquipmentRentals->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date);        
        $this->assertFalse($result);

        $start_date='2019-10-16';$end_date='2019-11-3';
        $result = $this->EquipmentRentals->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date);        
        $this->assertFalse($result);

        $start_date='2019-8-4';$end_date='2019-10-12';
        $result = $this->EquipmentRentals->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date);        
        $this->assertTrue($result);

        $start_date='2019-10-9';$end_date='2019-12-15';
        $result = $this->EquipmentRentals->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date);        
        $this->assertTrue($result);

        $start_date='2019-10-5';$end_date='2019-10-7';
        $result = $this->EquipmentRentals->hasOverlappingDates($work_id,$equipment_id,$start_date,$end_date);        
        $this->assertTrue($result);



    }

    public function testGetRentalPeriod(){
        
        $work = $this->Works->find()->where(['id' => 1])->first();

        $work = $this->EquipmentRentals->getRentalPeriod($work);
        
        $this->assertEquals('2019-10-07', $work->A_start_date->format('Y-m-d'));
        $this->assertEquals('2019-10-09', $work->A_end_date->format('Y-m-d'));
        $this->assertEquals('2019-10-09', $work->B_start_date->format('Y-m-d'));
        $this->assertEquals('2019-10-11', $work->B_end_date->format('Y-m-d'));
        $this->assertEquals('2019-10-11', $work->C_start_date->format('Y-m-d'));
        $this->assertEquals('2019-10-14', $work->C_end_date->format('Y-m-d'));
    }
}
