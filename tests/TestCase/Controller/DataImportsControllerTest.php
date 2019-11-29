<?php
namespace App\Test\TestCase\Controller;

use App\Controller\DataImportsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
use Cake\Event\EventManager;
/**
 * App\Controller\DataImportsController Test Case
 *
 * @uses \App\Controller\DataImportsController
 */
class DataImportsControllerTest extends TestCase
{
    use IntegrationTestTrait;


    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ImportDataConversions',
        'app.staffs'
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
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Staffs);

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/DataImports/index');
        $this->assertResponseOk();
        $this->assertResponseContains('データインポート');

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $filename = "test.xlsx";
        $path = TESTS . 'Fixture\excel\test.xlsx';        
        $data = [
            'title' => 'test title',
            'file_name' => [
                'name' => $filename,
                'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'tmp_name' => $path,
                'error' => UPLOAD_ERR_OK,
                'size' => 10*1024
            ],
            '_csrfToken' => $token
        ];
        $this->post('/DataImports/index', $data);
        $this->assertResponseCode(200);        

        $expected_cols = [
            'col1','col2','col3','col4',            
        ];
        $colNames =  $this->viewVariable('colNames');
        $this->assertEquals($expected_cols,$colNames); 

        $upload_file =  $this->viewVariable('upload_file');
        $this->assertEquals($filename,$upload_file);

        $filename = "test3.xlsx";
        $path = TESTS . 'Fixture\excel\test3.xlsx';        
        $data = [
            'title' => 'test title',
            'file_name' => [
                'name' => $filename,
                'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'tmp_name' => $path,
                'error' => UPLOAD_ERR_OK,
                'size' => 10*1024
            ],
            '_csrfToken' => $token
        ];

        $this->enableRetainFlashMessages();
        $this->post('/DataImports/index', $data);
        $this->assertFlashElement('Flash/error');
        $this->assertFlashMessage('ファイルのアップロードができませんでした.');         

    }

    /**
     * Test ajaxloadfiledata method
     *
     * @return void
     */
    public function testAjaxloadfiledata()
    {
        // text2.xlsx data
        // 11	12	13	14 15
        // 21	22	23	24 25
        // 31	32	33	34 35
        $filename = "test2.xlsx";
        $path = TESTS . 'Fixture\excel\test2.xlsx';
        \copy($path, WWW_ROOT.'files'.DS. $filename);        

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);
        $this->post('/DataImports/ajaxloadfiledata/'.$filename);
        $this->assertResponseCode(200);    
        
        $expected = [
            ['id'=>0,'cell'=>['',0,11,12,13,14,15],],
            ['id'=>1,'cell'=>['',1,21,22,23,24,25],],
            ['id'=>2,'cell'=>['',2,31,32,33,34,35],],            
        ];      
        
        $response = json_decode($this->_response->getBody());
        debug($response->rows);
        $this->assertEquals('staffs',$response->userdata->category);
        foreach ($response->rows as $key => $row) {
            $this->assertEquals($expected[$key]['cell'],$row->cell);            
        }
        
        \unlink(WWW_ROOT.'files'.DS. $filename);
 
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownload()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $data = [
            'filename' => 'staffs',
            '_csrfToken' => $token            
        ];
        $expected = WWW_ROOT.'files'.DS. 'import_staffs.xlsx';

        $this->post('/DataImports/download', $data);
        $this->assertNoRedirect();    
        $this->assertFileResponse($expected ,'指定のファイルがありません。');
    }

    /**
     * Test ajaxdataimport method
     *
     * @return void
     */
    public function testAjaxdataimport()
    {
        $overall_message = '<dl class="dl-horizontal"><dt>青葉　太郎</dt><dd ><font color="green">データのインポートに成功しました。</font></dd></dl>';
        $success = true;        

        $result = [
            'data'=> [
                ['id'=> "0", 'result'=> 1, 'message'=> "結果登録完了"]
            ],
        ];

        $return_val = [$result,$overall_message,$success];


        $expected = [
            'data'=> [
                ['id'=> "0", 'result'=> 1, 'message'=> "結果登録完了"]
            ],
            'overall'=>['message'=> $overall_message,
            'result'=> 1,]
        ];

        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);
        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X-CSRF-Token' => $token,
            ],
        ]);

        $data = [
            'num'=>1,
            'dat'=>[
                [
                    'id' => '0',
                    '氏名' => '青葉　太郎',
                    'フリガナ' => 'あおば　たろう',
                    '生年月日' => '1976-10-21 00:00:00',
                    '性別' => 1,
                    '住所' => '東京都aoba区a向島',
                    '番地' => '3-2-1',
                    '建物名' => 'medical',         
                ]
            ]
        ];
        $this->post('/DataImports/ajaxdataimport/staffs', $data);
        $this->assertResponseCode(200);
        $this->assertEquals($expected, json_decode($this->_response->getBody(), true));        
        
        $query = $this->Staffs->find()->where(['name' => $data['dat'][0]['氏名']])->first();
        // debug($query);
        $this->assertEquals($data['dat'][0]['住所'], $query->address);
        $this->assertEquals($data['dat'][0]['番地'], $query->banchi);
        $this->assertEquals($data['dat'][0]['建物名'], $query->tatemono);


    }


}
