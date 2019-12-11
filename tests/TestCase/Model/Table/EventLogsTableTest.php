<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventLogsTable Test Case
 */
class EventLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventLogsTable
     */
    public $EventLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EventLogs',
        'app.Records',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EventLogs') ? [] : ['className' => EventLogsTable::class];
        $this->EventLogs = TableRegistry::getTableLocator()->get('EventLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventLogs);

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
