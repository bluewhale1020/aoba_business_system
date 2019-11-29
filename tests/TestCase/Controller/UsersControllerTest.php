<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users'
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
        $this->Users = TableRegistry::get('Users');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
    }

    public function testSignup(){

        $this->get('/users/signup');

        $this->assertTemplate('signup');


        $token = 'my-csrf-token';

        $this->cookie('csrfToken', $token);

        $this->post('/users/signup', [
            'username' => 'xxx',
            'password' => 'xxx',
            'role' => 'admin',
            'formal_name' => 'ccc xxx',            
            '_csrfToken' => $token            
          ]);

        $this->assertEquals(19, $this->Users->find()->count());
        $query = $this->Users->find()->where(['username' => 'xxx'])->first();
        $this->assertEquals('ccc xxx', $query->formal_name);          
          
          // ログインに成功したら目的のページにリダイレクトする
          $this->assertRedirect(['controller' => 'Dashboards', 'action' => 'index']);
          $this->assertSession('xxx', 'Auth.User.username');        

    }


    public function testLogin(){

        $this->get('/users/login');

        $this->assertTemplate('login');


        $token = 'my-csrf-token';

        $this->cookie('csrfToken', $token);

        $this->post('/users/login', [
            'username' => 'admin',
            'password' => 'admin',
            '_csrfToken' => $token            
          ]);
          
          // ログインに成功したら目的のページにリダイレクトする
          $this->assertRedirect(['controller' => 'Dashboards', 'action' => 'index']);
          $this->assertSession(4, 'Auth.User.id');        

    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/users/index'); 
        $this->assertRedirectContains('/users/login');

        $this->setUserSession();

        $this->get('/users/index');
        $this->assertResponseOk();
        $this->assertResponseContains('ユーザー一覧');
        $this->assertCount(5, $this->viewVariable('users'));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->setUserSession();

        $this->get('/users/view/7');
        $this->assertResponseOk();
        $this->assertResponseContains('登録されているユーザー情報を');
        $user = $this->viewVariable('user');
        // debug($user);
        $this->assertEquals('yyy',$user->username);
        $this->assertEquals('user',$user->role);
        $this->assertEquals('yyy nameawefa',$user->formal_name);
        $this->assertTemplate('view');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->setUserSession();

        $token = 'my-csrf-token';

        $this->cookie('csrfToken', $token);

        $data = [
            'username' => 'zzz',
            'role' => 'user',
            'formal_name' => 'zzz xxx',
            '_csrfToken' => $token            
        ];
        $this->post('/users/add', $data);
        $this->assertNoRedirect();    
        $this->assertEquals(18, $this->Users->find()->count());
        $data['password'] = 'pass';
        $this->post('/users/add', $data);
        $this->assertRedirect(['action' => 'index']);    
        // $this->assertRedirectContains('/users/index');    
        $this->assertEquals(19, $this->Users->find()->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->setUserSession();

        $token = 'my-csrf-token';

        $this->cookie('csrfToken', $token);

        $data = [
            'formal_name' => 'zzz yyy',
            '_csrfToken' => $token            
        ];
        $this->post('/users/edit/7', $data);
        $this->assertRedirect(['action' => 'view',7]);    
        $query = $this->Users->find()->where(['id' => 7])->first();
        $this->assertEquals($data['formal_name'], $query->formal_name);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->setUserSession();
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);
        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ]
        ]);

        $this->delete('/users/delete/7');
        $this->assertRedirect(['action' => 'index']);    
        $query = $this->Users->find()->where(['id' => 7])->first();
        $this->assertEmpty($query);

    }
}
