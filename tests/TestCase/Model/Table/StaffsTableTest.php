<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StaffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StaffsTable Test Case
 */
class StaffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StaffsTable
     */
    public $Staffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        // 'app.staffs',
        // 'app.occupations',
        // 'app.occupation2s',
        // 'app.titles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Staffs') ? [] : ['className' => 'App\Model\Table\StaffsTable'];
        $this->Staffs = TableRegistry::get('Staffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Staffs);

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
