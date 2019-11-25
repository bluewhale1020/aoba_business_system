<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

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

    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->setUserSession();

        $data = [
            'username' => 'zzz',
            'role' => 'user',
            'formal_name' => 'zzz xxx',
        ];
    $this->post('/users/add', $data);
    $this->assertRedirect(['action' => 'index']);
    $this->assertEquals(19, $this->Users->find()->count());

    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
