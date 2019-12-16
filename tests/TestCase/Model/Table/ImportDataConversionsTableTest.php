<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportDataConversionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportDataConversionsTable Test Case
 */
class ImportDataConversionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportDataConversionsTable
     */
    public $ImportDataConversions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        // 'app.ImportDataConversions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ImportDataConversions') ? [] : ['className' => ImportDataConversionsTable::class];
        $this->ImportDataConversions = TableRegistry::getTableLocator()->get('ImportDataConversions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ImportDataConversions);

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
