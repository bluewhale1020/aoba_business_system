<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FileHandlerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * App\Controller\Component\FileHandlerComponent Test Case
 */
class FileHandlerComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\FileHandlerComponent
     */
    public $FileHandler;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->FileHandler = new FileHandlerComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FileHandler);

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
     * Test file_upload method
     *
     * @return void
     */
    public function testFileUpload()
    {
        $file = [
            'tmp_name' => TESTS . 'Fixture\excel\staff.xlsx',
            'error' => 0,
            'name' => 'staff.xlsx',
            'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'size' => 15163
        ];
        $fileInfo = new File($file["tmp_name"]);

        $limitFileSize = 1 * 1000 * 1000;
        $dir = realpath(WWW_ROOT . DS . "files");

        //例外処理も含めてテストケースを配列に入れる
        $options =[
            ['file'=>$file,'dir'=>$dir,'limit'=>$limitFileSize,'error'=>false],
            ['file'=>[],'dir'=>'','limit'=>$limitFileSize,'error'=>['message'=>'ディレクトリの指定がありません。']],
            ['file'=>[],'dir'=> WWW_ROOT . DS . "file",'limit'=>$limitFileSize,'error'=>['message'=>'指定のディレクトリがありません。']],

            ['file'=>['error'=>[]],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'無効なパラメーターです。']],
            ['file'=>['error'=>UPLOAD_ERR_NO_FILE],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'ファイルが送信されていません。']],
            ['file'=>['error'=>UPLOAD_ERR_INI_SIZE],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'アップロードされたファイルが大きすぎます。' . 
            ini_get('upload_max_filesize') . '以下のファイルをアップロードしてください。']],
            ['file'=>['error'=>UPLOAD_ERR_FORM_SIZE],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'アップロードされたファイルが大きすぎます。' . 
            ($_POST['MAX_FILE_SIZE'] / 1000) . 'KB以下のファイルをアップロードしてください。']],
            ['file'=>['error'=>1111],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'不明なエラーです。']],
 
            ['file'=>[],'dir'=>$dir,'limit'=>100,'error'=>['message'=>'ファイルサイズ（'.$fileInfo->size() .'）が、許容ファイルサイズ（100）を超えています。']],
            ['file'=>['type'=>'pwd','tmp_name'=>TESTS . 'Fixture\excel\staff.pwd'],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'このファイルの形式(pwd)には対応していません。']],
            ['file'=>[],'dir'=>$dir,'limit'=>$limitFileSize,'error'=>['message'=>'ファイルの移動に失敗しました。']],

        ];

        foreach ($options as $key => $option) {
            $mergefile = \array_merge($file,$option['file']);
            $dir = $option['dir'];
            $limitFileSize = $option['limit'];

            try {
                $result = $this->FileHandler->file_upload($mergefile,$dir, $limitFileSize);
                
                $expected = $mergefile['name'];
                $this->assertEquals($expected, $result);
                $this->assertFileExists($dir . DS . $expected);
                
            } catch (RuntimeException $e) {
                debug("expected:". $option['error']['message']);
                debug("actual:".$e->getMessage());
                $this->assertEquals($option['error']['message'], $e->getMessage());
            }

        }


    }

}
