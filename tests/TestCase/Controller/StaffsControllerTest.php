<?php
namespace App\Test\TestCase\Controller;

use App\Controller\StaffsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\StaffsController Test Case
 *
 * @uses \App\Controller\StaffsController
 */
class StaffsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Staffs',
        'app.Occupations',
        'app.Titles',
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
        $this->Staffs = TableRegistry::get('Staffs');
        $this->Occupations = TableRegistry::get('Occupations');
        $this->Titles = TableRegistry::get('Titles');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Staffs);
        unset($this->Occupations);
        unset($this->Titles);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/staffs/index');
        $this->assertResponseOk();
        $this->assertResponseContains('スタッフ一覧');
        $this->assertCount(10, $this->viewVariable('staffs'));

        $occupations = $this->Occupations->find('list', ['limit' => 200])->toArray();
        $titles = $this->Titles->find('list', ['limit' => 200])->toArray();
        $this->assertEquals($occupations,$this->viewVariable('occupations'));
        $this->assertEquals($titles,$this->viewVariable('titles'));

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            '肩書' => 5,
            '_csrfToken' => $token
        ];
        $this->post('/staffs/index', $data);
        $staffs =  $this->viewVariable('staffs');
        $this->assertEquals(8,count($staffs));        
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/staffs/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('登録されているスタッフの情報を表示します');
        $staff = $this->viewVariable('staff');
        // debug($staff);
        $this->assertEquals('青葉　太郎',$staff->name);
        $this->assertEquals('放射線技師',$staff->Occupation1->name);
        $this->assertEquals('正規社員',$staff->title->name);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {

        $count = $this->Staffs->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'name' => 'test name',
            'kana' => 'test kana',
            'birth_date' => '1977-12-31 00:00:00',
            'occupation_id' => 2,
            'occupation2_id' => 4,
            'title_id' => 3,
            'sex' => 1,
            '_csrfToken' => $token            
        ];
        $this->post('/staffs/add', $data);
        $this->assertRedirect(['action' => 'index']);    
        $this->assertEquals($count+1, $this->Staffs->find()->count());

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
            'name' => '青葉　次郎',
            'kana' => 'あおば　じろう',
            'birth_date' => '1976-10-21 00:00:00',
            'sex' => 1,                        
            '_csrfToken' => $token            
        ];
        $this->post('/staffs/edit/1', $data);
        $this->assertFlashElement('Flash/success');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Staffs->find()->where(['id' => 1])->first();
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

        $this->delete('/staffs/delete/1');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Staffs->find()->where(['id' => 1])->first();
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
        $this->post('/staffs/ajaxloadaddress', ["zipcode" => "130021"]);
        $this->assertResponseCode(200);

        $this->assertEquals('墨田区緑', json_decode($this->_response->getBody(), false));        

        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);        
        $this->post('/staffs/ajaxloadaddress', ["zipcode" => "15050132"]);
        $this->assertResponseCode(400);      
 
    }
}
