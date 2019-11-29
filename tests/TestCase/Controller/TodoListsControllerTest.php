<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TodoListsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\TodoListsController Test Case
 *
 * @uses \App\Controller\TodoListsController
 */
class TodoListsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TodoLists'
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
        $this->TodoLists = TableRegistry::get('TodoLists');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TodoLists);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);
        $this->get('/TodoLists/ajaxloadlist');
        $this->assertResponseCode(200);
        $list = json_decode($this->_response->getBody(),true);
        $this->assertEquals(14, count($list)); 
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $count = $this->TodoLists->find()->count();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);

        $data = [
            'description' => 'test desc',
            'due_date' => '2019-12-25',
            'priority' => 5,
            'done' => false,
            '_csrfToken' => $token            
        ];

        $this->post('/TodoLists/ajaxsavelistitem', $data);
        $this->assertResponseCode(200);          
        $this->assertEquals($count+1, $this->TodoLists->find()->count());        
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

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);        

        $data = [
            'id' => 2,
            'done' => true,
            'description' => 'test desc',
            'due_date' => '2019-12-25',
            'priority' => 5,         
            '_csrfToken' => $token            
        ];
        $this->post('/TodoLists/ajaxsavelistitem', $data);  
        $query = $this->TodoLists->find()->where(['id' => 2])->first();
        $this->assertEquals($data['done'], $query->done);        
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
                'X-Requested-With' => 'XMLHttpRequest',                
                'X-CSRF-Token' => $token,
            ]
        ]);

        $this->post('/TodoLists/ajaxdeletelistitem',['id'=>2]);   
        $this->assertResponseSuccess();
        $query = $this->TodoLists->find()->where(['id' =>2])->first();

        $this->assertEmpty($query);
    }
}
