<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UtilitiesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UtilitiesController Test Case
 *
 * @uses \App\Controller\UtilitiesController
 */
class UtilitiesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.business_partners',         
        'app.orders3',    
        'app.bills3',    
        'app.works3',
    ];

    protected function setUserSession()
    {
        $this->session(['Auth' => [
            'User' => [
                'id' => 4,
                'username' => 'admin',
                'role' => 'admin',
            ]
        ]]);
    }    
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->setUserSession();
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {

        parent::tearDown();
    }

    /**
     * Test ajaxloadnotifications method
     *
     * @return void
     */
    public function testAjaxloadnotifications()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);

        $this->get('/Utilities/ajaxloadnotifications');
        $this->assertResponseCode(200);
        
        $notifications = json_decode($this->_response->getBody(), true);
        // debug($notifications);
        $this->assertArrayHasKey('totalcount', $notifications);
        $this->assertArrayHasKey('unconfirmed_orders', $notifications);
        $this->assertArrayHasKey('unfinished_works', $notifications);
        $this->assertArrayHasKey('unbilled_orders', $notifications);
        $this->assertArrayHasKey('unpaid_bills', $notifications);          



    }
}
