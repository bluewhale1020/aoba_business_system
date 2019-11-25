<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\NotificationsComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\NotificationsComponent Test Case
 */
class NotificationsComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\NotificationsComponent
     */
    public $Notifications;


    public $fixtures = [  
        'app.business_partners',         
        'app.orders3',    
        'app.bills3',    
        'app.works3',    
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Notifications = new NotificationsComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Notifications);

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
     * Test getNotificationInfo method
     *
     * @return void
     */
    public function testGetNotificationInfo()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getUnconfirmedOrders method
     *
     * @return void
     */
    public function testGetUnconfirmedOrders()
    {
        $result = $this->Notifications->getUnconfirmedOrders();

        $expected = 1;
        $this->assertEquals($expected, count($result));
    }

    /**
     * Test getUnfinishedWorks method
     *
     * @return void
     */
    public function testGetUnfinishedWorks()
    {
        $result = $this->Notifications->getUnfinishedWorks();

        $expected = 1;
        $this->assertEquals($expected, count($result));
    }

    /**
     * Test getUnbilledOrders method
     *
     * @return void
     */
    public function testGetUnbilledOrders()
    {
        $result = $this->Notifications->getUnbilledOrders();

        $expected = 2;
        $this->assertEquals($expected, count($result));
    }

    /**
     * Test getUnpaidBills method
     *
     * @return void
     */
    public function testGetUnpaidBills()
    {
        $result = $this->Notifications->getUnpaidBills();

        $expected = 1;
        $this->assertEquals($expected, count($result));

    }
}
