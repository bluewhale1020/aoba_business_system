<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CapturingRegionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CapturingRegionsTable Test Case
 */
class CapturingRegionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CapturingRegionsTable
     */
    public $CapturingRegions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.capturing_regions',
        'app.orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CapturingRegions') ? [] : ['className' => 'App\Model\Table\CapturingRegionsTable'];
        $this->CapturingRegions = TableRegistry::get('CapturingRegions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CapturingRegions);

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
