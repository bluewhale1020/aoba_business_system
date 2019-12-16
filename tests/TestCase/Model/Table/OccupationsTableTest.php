<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OccupationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OccupationsTable Test Case
 */
class OccupationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OccupationsTable
     */
    public $Occupations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        // 'app.occupations',
        // 'app.staffs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Occupations') ? [] : ['className' => 'App\Model\Table\OccupationsTable'];
        $this->Occupations = TableRegistry::get('Occupations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Occupations);

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
