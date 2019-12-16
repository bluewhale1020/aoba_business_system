<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkContentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkContentsTable Test Case
 */
class WorkContentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkContentsTable
     */
    public $WorkContents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        // 'app.work_contents',
        // 'app.orders',
        // 'app.clients',
        // 'app.work_places',
        // 'app.bills',
        // 'app.business_partners',
        // 'app.contract_rates',
        // 'app.contract_types',
        // 'app.capturing_regions',
        // 'app.radiography_types',
        // 'app.works'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WorkContents') ? [] : ['className' => 'App\Model\Table\WorkContentsTable'];
        $this->WorkContents = TableRegistry::get('WorkContents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WorkContents);

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
}
