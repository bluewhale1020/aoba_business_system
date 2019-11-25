<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractRatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractRatesTable Test Case
 */
class ContractRatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractRatesTable
     */
    public $ContractRates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contract_rates',
        'app.business_partners',
        'app.bills',
        'app.orders',
        'app.client',
        'app.order1',
        'app.work_place',
        'app.order2',
        'app.work_contents',
        'app.capturing_regions',
        'app.radiography_types',
        'app.works',
        'app.equipment1',
        'app.equipment_types',
        'app.equipments',
        'app.statuses',
        'app.work1',
        'app.equipment2',
        'app.work2',
        'app.equipment3',
        'app.work3',
        'app.equipment4',
        'app.work4',
        'app.equipment5',
        'app.work5',
        'app.staff1',
        'app.occupation1',
        'app.staff2',
        'app.occupation2',
        'app.titles',
        'app.staffs',
        'app.work6',
        'app.staff3',
        'app.work7',
        'app.staff4',
        'app.work8',
        'app.staff5',
        'app.work9',
        'app.staff6',
        'app.work10',
        'app.staff7',
        'app.work11',
        'app.staff8',
        'app.work12',
        'app.staff9',
        'app.work13',
        'app.staff10',
        'app.work14',
        'app.technician1',
        'app.work15',
        'app.technician2',
        'app.work16',
        'app.technician3',
        'app.work17',
        'app.technician4',
        'app.work18',
        'app.technician5',
        'app.work19',
        'app.technician6',
        'app.work20',
        'app.technician7',
        'app.technician8',
        'app.technician9',
        'app.technician10'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ContractRates') ? [] : ['className' => 'App\Model\Table\ContractRatesTable'];
        $this->ContractRates = TableRegistry::get('ContractRates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractRates);

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
}
