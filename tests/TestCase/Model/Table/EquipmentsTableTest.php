<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentsTable Test Case
 */
class EquipmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentsTable
     */
    public $Equipments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Equipments2',
        'app.EquipmentTypes',
        'app.XrayTypes',
        'app.Statuses',
        'app.Works4',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Equipments') ? [] : ['className' => EquipmentsTable::class];
        $this->Equipments = TableRegistry::getTableLocator()->get('Equipments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Equipments);

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
     * Test incrementNumberOfTimes method
     *
     * @return void
     */
    public function testIncrementNumberOfTimes()
    {
        $this->Works = TableRegistry::get('Works');
        $work = $this->Works->get(1);

        $result = $this->Equipments->incrementNumberOfTimes($work);

        $equips = $this->Equipments->find()->order(['id' => 'ASC'])->all();
        $expected = [6,5,4,3,0];
        foreach ($equips as $key => $equip) {
            $this->assertEquals($expected[$key], $equip->number_of_times);            
        }


    }

    /**
     * Test getEquipmentData method
     *
     * @return void
     */
    public function testGetEquipmentData()
    {

        $capturing_region_id = 1;//equipment_type_id = 1:可搬 2:Bレ車
        list($equipment_types,$equipments) = $this->Equipments->getEquipmentData($capturing_region_id);

        $expected = ["可搬","Bレ車"];
        $this->assertEquals($expected, \array_values($equipment_types)); 

        // $equipments[$edata->id] = $edata->equipment_type->name . " " . $edata->equipment_no . "号車";
        $expected = [
            2 =>"可搬 12号車",
            3 =>"可搬 13号車",
            4 =>"Bレ車 14号車",
            5 =>"Bレ車 15号車",
        ];
        foreach ($expected as $key => $desc) {
            $this->assertEquals($desc, $equipments[$key]);             
        }


    }
}
