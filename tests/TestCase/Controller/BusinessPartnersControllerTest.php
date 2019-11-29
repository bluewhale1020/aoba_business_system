<?php
namespace App\Test\TestCase\Controller;

use App\Controller\BusinessPartnersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\BusinessPartnersController Test Case
 */
class BusinessPartnersControllerTest extends TestCase
{
    use IntegrationTestTrait;
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.business_partners',
        'app.bills',
        'app.orders',
        'app.contract_rates',
        'app.Zipcodes',        
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
        $this->BusinessPartners = TableRegistry::get('BusinessPartners');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BusinessPartners);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/businessPartners/index');
        $this->assertResponseOk();
        $this->assertResponseContains('取引先一覧');
        $this->assertCount(10, $this->viewVariable('businessPartners'));
        
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);
        
        $data = [
            '名称' => '田',
            '取引先種別' => 'is_work_place',
            '_csrfToken' => $token
        ];
        $this->post('/businessPartners/index', $data);
        $this->assertCount(4, $this->viewVariable('businessPartners'));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/businessPartners/view/2');
        $this->assertResponseOk();
        $this->assertResponseContains('登録取引先情報');
        $businessPartner = $this->viewVariable('businessPartner');
        // debug($businessPartner);
        $this->assertEquals('青葉化学',$businessPartner->name);
        $this->assertEquals('121-0011',$businessPartner->postal_code);
        $this->assertEmpty($businessPartner->parent_id);


    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $count = $this->BusinessPartners->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'name' => '青葉運輸',
            'kana' => 'あおばうんゆ',
            'postal_code' => '122-0211',
            'address' => '東京都aoba区onkyo',
            'banchi' => '1-22-23',
            'tatemono' => 'tatemono',
            'tel' => '00-3000-0002',
            'is_client' => 1,
            '_csrfToken' => $token            
        ];
        $this->post('/BusinessPartners/add', $data);
        $this->assertRedirectContains('/view');
        $this->assertEquals($count+1, $this->BusinessPartners->find()->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $token = 'my-csrf-token';
        
        $this->cookie('csrfToken', $token);
        
        $data = [
            'id'=>1,
            'name' => '青葉運輸',
            'kana' => 'あおばうんゆ',
            'postal_code' => '122-0211',
            'address' => '東京都aoba区onkyo',
            'banchi' => '1-22-23',
            'tatemono' => 'tatemono',
            'tel' => '00-3000-0002',
            'is_client' => 1,                    
            '_csrfToken' => $token            
        ];
        $this->post('/BusinessPartners/edit/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'view',1]);    
        $query = $this->BusinessPartners->find()->where(['id' => 1])->first();
        $this->assertEquals($data['name'], $query->name);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);
        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ]
        ]);

        $this->delete('/BusinessPartners/delete/1');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->BusinessPartners->find()->where(['id' => 1])->first();
        $this->assertEmpty($query);
    }

    /**
     * Test ajaxloadaddress method
     *
     * @return void
     */
    public function testAjaxloadaddress()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);
        $this->post('/BusinessPartners/ajaxloadaddress', ["zipcode" => "130021"]);
        $this->assertResponseCode(200);

        $this->assertEquals('墨田区緑', json_decode($this->_response->getBody(), false));        

        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);        
        $this->post('/BusinessPartners/ajaxloadaddress', ["zipcode" => "15050132"]);
        $this->assertResponseCode(400);      
 
    }

}
