<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ContractRatesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\ContractRatesController Test Case
 *
 * @uses \App\Controller\ContractRatesController
 */
class ContractRatesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractRates',
        'app.BusinessPartners'
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
        $this->ContractRates = TableRegistry::get('ContractRates');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractRates);

        parent::tearDown();
    }

    /**
     * Test manage method
     *
     * @return void
     */
    public function testManage()
    {
        $this->get('/ContractRates/manage/1');
        $this->assertResponseCode(302);
        $this->assertRedirect(['action' => 'edit',3,1]);        
        
        
        $this->get('/ContractRates/manage/2');
        $this->assertResponseCode(302);
        $this->assertRedirect(['action' => 'add',2]);        
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $count = $this->ContractRates->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'business_partner_id' => 2,
            'guaranty_charge_chest_i_por' => 1000,
            'additional_unit_price_chest_dg_por' => 2000,
            'guaranty_charge_stom_i_car' => 2000,
            'additional_unit_price_stom_dr_car' => 1000,
            'operating_cost' => 8000,
            '_csrfToken' => $token            
        ];
        $this->post('/ContractRates/add/2', $data);
        $this->assertRedirect(['controller'=>'BusinessPartners','action' => 'view',2]);    
        $this->assertEquals($count+1, $this->ContractRates->find()->count());
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
            'id'=>3,
            'business_partner_id' => 1,
            'guaranty_charge_chest_i_por' => 1000,
            'additional_unit_price_chest_dg_por' => 2000,
            'guaranty_charge_stom_i_car' => 2000,
            'additional_unit_price_stom_dr_car' => 1000,
            'operating_cost' => 8000,                  
            '_csrfToken' => $token            
        ];
        $this->post('/ContractRates/edit/3/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['controller'=>'BusinessPartners','action' => 'view',1]);    
        $query = $this->ContractRates->get(3);
        $this->assertEquals($data['guaranty_charge_chest_i_por'], $query->guaranty_charge_chest_i_por);
        $this->assertEquals($data['guaranty_charge_stom_i_car'], $query->guaranty_charge_stom_i_car);
        $this->assertEquals($data['operating_cost'], $query->operating_cost);
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

        $this->delete('/ContractRates/delete/1');
        $this->assertRedirect(['controller'=>'BusinessPartners','action' => 'view',1]);    
        $this->assertFlashElement('Flash/success');
        $query = $this->ContractRates->find()->where(['id' => 1])->first();
        $this->assertEmpty($query);

        $this->cookie('csrfToken', $token);
        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ]
        ]);

        $this->delete('/ContractRates/delete/2');
        $this->assertRedirect(['controller'=>'BusinessPartners','action' => 'view',2]);    
        $this->assertFlashElement('Flash/error');
    }

    /**
     * Test ajaxloadcontractrates method
     *
     * @return void
     */
    public function testAjaxloadcontractrates()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);
        $this->post('/ContractRates/ajaxloadcontractrates', ["client_id" => 1]);
        $this->assertResponseCode(200);

        $response_data = json_decode($this->_response->getBody(),true);
        // debug($response_data);
        $this->assertEquals(10000, $response_data['operating_cost']);        
        $this->assertEquals(1, $response_data['business_partner_id']);        

        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);        

        $this->post('/ContractRates/ajaxloadcontractrates', ["client_id" => 2]);
        $this->assertResponseCode(400); 


    }
}
