<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorksTable Test Case
 */
class WorksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WorksTable
     */
    public $Works;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.works',
        // 'app.orders',
        // 'app.clients',
        // 'app.work_places',
        // 'app.bills',
        // 'app.business_partners',
        // 'app.contract_rates',
        // 'app.contract_types',
        // 'app.work_contents',
        // 'app.capturing_regions',
        // 'app.radiography_types',
        // 'app.equipment_as',
        // 'app.equipment_bs',
        // 'app.equipment_cs',
        // 'app.equipment_ds',
        // 'app.equipment_es',
        // 'app.staff1s',
        // 'app.staff2s',
        // 'app.staff3s',
        // 'app.staff4s',
        // 'app.staff5s',
        // 'app.staff6s',
        // 'app.staff7s',
        // 'app.staff8s',
        // 'app.staff9s',
        // 'app.staff10s',
        // 'app.technician1s',
        // 'app.technician2s',
        // 'app.technician3s',
        // 'app.technician4s',
        // 'app.technician5s',
        // 'app.technician6s',
        // 'app.technician7s',
        // 'app.technician8s',
        // 'app.technician9s',
        // 'app.technician10s'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Works') ? [] : ['className' => 'App\Model\Table\WorksTable'];
        $this->Works = TableRegistry::get('Works', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
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

    /**
     * Test addExtraData method
     *
     * @return void
     */
    public function testAddExtraData(){
        $work = $this->Works->newEntity();
        $data = [
            'operation_number' => '3',
            'equipmentA_id' => '1',
            'A_date_range' => '2019/10/16 - 2019/11/07',
            'A_start_date' => '2019/10/16',
            'A_end_date' => '2019/11/07',
            'equipmentB_id' => '3',
            'B_date_range' => '2019/11/03 - 2019/11/09',
            'B_start_date' => '2019/11/03',
            'B_end_date' => '2019/11/09',
            'equipmentC_id' => '4',
            'C_date_range' => '2019/10/23 - 2019/10/26',
            'C_start_date' => '2019/10/23',
            'C_end_date' => '2019/10/26',
        ];
        $expected = $this->Works->patchEntity($work, $data);
        $work = clone $expected;

        $result = $this->Works->addExtraData($work);

        $this->assertEquals($expected->toArray(), $result->toArray());


        $work->A_start_date = $work->A_end_date = '';

        $result = $this->Works->addExtraData($work);

        $this->assertEquals($expected->toArray(), $result->toArray());
        
        $work->B_start_date = $work->B_end_date = '';

        $result = $this->Works->addExtraData($work);

        $this->assertEquals($expected->toArray(), $result->toArray());

        $work->operation_number = 0;

        $result = $this->Works->addExtraData($work);

        $this->assertEquals($expected->toArray(), $result->toArray());



    }

    /**
     * Test setRentalDateRange method
     *
     * @return void
     */
    public function testSetRentalDateRange()
    {

        $data =[
            "A_start_date" => "2019-10-7",
            "A_end_date" => "2019-10-9",
            "B_start_date" => "2019-10-9",
            "B_end_date" => "2019-10-11",
            "C_start_date" => "2019-10-11",
            "C_end_date" => "2019-10-14",
        ];
        $work = $this->Works->newEntity($data);

        $result = $this->Works->setRentalDateRange($work);
        debug($result->A_date_range);
        $expected = [
            "A_date_range"=> "2019-10-7 - 2019-10-9",
            "B_date_range"=> "2019-10-9 - 2019-10-11",
            "C_date_range"=> "2019-10-11 - 2019-10-14",
        ];
        foreach($expected as $key => $val){
            $this->assertEquals($val, $result->{$key});                    
        }
    }    

}
