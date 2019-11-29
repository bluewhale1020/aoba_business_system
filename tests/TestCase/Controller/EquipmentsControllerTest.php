<?php
namespace App\Test\TestCase\Controller;

use App\Controller\EquipmentsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
/**
 * App\Controller\EquipmentsController Test Case
 */
class EquipmentsControllerTest extends TestCase
{
    use IntegrationTestTrait;
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipments',
        'app.equipment_types',
        'app.statuses',
        'app.xray_types',
        'app.equipment_rentals',
        'app.works',
        'app.orders',
        'app.business_partners'
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
        $this->Equipments = TableRegistry::get('Equipments');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Equipments);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/Equipments/index');
        $this->assertResponseOk();
        $this->assertResponseContains('装置一覧');
        $this->assertCount(14, $this->viewVariable('equipments'));

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '装置種類' => 1,
            '状態' => 1,
            '_csrfToken' => $token
        ];
        $this->post('/Equipments/index', $data);
        $equipments =  $this->viewVariable('equipments');
        $this->assertEquals(3,count($equipments));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/Equipments/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('装置情報');
        $equipment = $this->viewVariable('equipment');
        // debug($staff);
        $this->assertEquals('テスト装置',$equipment->name);
        $this->assertEquals('稼働中',$equipment->status->name);
        $this->assertEquals('Mレ車',$equipment->equipment_type->name);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $count = $this->Equipments->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'name' => '装置20',
            'equipment_type_id' => 2,
            'xray_type_id' => 1,
            'transportable' => 0,
            'number_of_times' => 0,
            'status_id' => 1,
            'notes' => 'test',
            'install_date' => '2019-10-13 00:00:00',
            'equipment_no' => 20,
            '_csrfToken' => $token            
        ];
        $this->post('/Equipments/add', $data);
        $this->assertRedirect(['action' => 'index']);    
        $this->assertEquals($count+1, $this->Equipments->find()->count());
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
            'id' => 1,
            'name' => 'テスト装置改',
            'equipment_type_id' => 3,
            'xray_type_id' => 2,
            'status_id' => 2,
            'notes' => '改良',             
            '_csrfToken' => $token            
        ];
        $this->post('/Equipments/edit/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Equipments->find()->where(['id' => 1])->first();
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

        $this->delete('/Equipments/delete/1');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Equipments->find()->where(['id' => 1])->first();
        $this->assertEmpty($query);
    }
}
