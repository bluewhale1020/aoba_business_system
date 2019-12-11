<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\LogBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\LogBehavior Test Case
 */
class LogBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\LogBehavior
     */
    public $Log;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Log = new LogBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Log);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
