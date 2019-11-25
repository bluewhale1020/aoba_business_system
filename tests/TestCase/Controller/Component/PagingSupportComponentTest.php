<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\PagingSupportComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\PagingSupportComponent Test Case
 */
class PagingSupportComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\PagingSupportComponent
     */
    public $PagingSupport;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->PagingSupport = new PagingSupportComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PagingSupport);

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
