<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ZipcodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ZipcodesTable Test Case
 */
class ZipcodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ZipcodesTable
     */
    public $Zipcodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.zipcodes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Zipcodes') ? [] : ['className' => 'App\Model\Table\ZipcodesTable'];
        $this->Zipcodes = TableRegistry::get('Zipcodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Zipcodes);

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
