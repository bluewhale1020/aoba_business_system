<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SalesStatComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\SalesStatComponent Test Case
 */
class SalesStatComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\SalesStatComponent
     */
    public $SalesStat;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->SalesStat = new SalesStatComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SalesStat);

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
