<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

use Cake\ORM\TableRegistry;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

use Cake\Http\Response;

/**
 * FileHandler component
 */
class FileHandlerComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * This array stores all allowed mime types, a mime type
     * determines the type of file.
     *
     * The specified mime types below should be safe for uploads,
     * however the compressed formats could be a touch unsafe.
     *
     * This can be overwritten by setAllowedMime()
     */        
    var $_allowedMime = [];
    var $_allowedAmbiguousMime = [];
    protected $_mime_type = "";
    protected $_limit_file_size = 50 * 1000 * 1000; //50M
    
    public function initialize(array $config) {
        /*初期処理*/
        // mime_type	                                                        ext
        // application/vnd.openxmlformats-officedocument.spreadsheetml.sheet	xlsx
        
        $this->_allowedAmbiguousMime = ['application/vnd.ms-office'];
        $this->_allowedMime = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>'xlsx'];
        
    }    
                       
    
    protected function getAllowedMime(){
        $valArray = array_values($this->_allowedMime);
        $mimeList = array();
        foreach ($valArray as $key => $value) {
            $mimeList[$value]=$value;
        }
    
            return $mimeList;
        
    }
    
    protected function getFullMimeTypesFromExt($ext){
        $result = array_keys($this->_allowedMime, $ext);
        $mimeTypes = [];
        foreach ($result as $idx => $mimetype) {
            $mimeTypes[] = "'".$mimetype ."'";
        }
        
        return implode(",", $mimeTypes) ;
        
        
    }
    
    protected function getMimeType(){
        return $this->_mime_type;
    }

    public function file_upload ($file = null,$dir = null, $limitFileSize = 0){

        // debug($file);debug($dir);debug($limitFileSize);die();
        if($limitFileSize==0){$limitFileSize = $this->_limit_file_size;}
        
        try {
            // ファイルを保存するフォルダ $dirの値のチェック
            if ($dir){
                if(!file_exists($dir)){
                    throw new RuntimeException('指定のディレクトリがありません。');
                }
            } else {
                throw new RuntimeException('ディレクトリの指定がありません。');
            }
 
            // 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
            if (!isset($file['error']) || is_array($file['error'])){
                throw new RuntimeException('無効なパラメーターです。');
            }

            // エラーのチェック
            switch ($file['error']) {
                case 0:
                    break;
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('ファイルが送信されていません。');
                case UPLOAD_ERR_INI_SIZE:
                    //値: 1; アップロードされたファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています（post_max_size, upload_max_filesize）
                    throw new RuntimeException('アップロードされたファイルが大きすぎます。' . ini_get('upload_max_filesize') . '以下のファイルをアップロードしてください。');
                    break;
            
                case UPLOAD_ERR_FORM_SIZE:
                    //値: 2; アップロードされたファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています。
                    throw new RuntimeException('アップロードされたファイルが大きすぎます。' . ($_POST['MAX_FILE_SIZE'] / 1000) . 'KB以下のファイルをアップロードしてください。');
                    break;
                default:
                    throw new RuntimeException('不明なエラーです。');
            }
 
            
            
 
            // ファイル情報取得
            $fileInfo = new File($file["tmp_name"]);
 
            // ファイルサイズのチェック
            if ($fileInfo->size() > $limitFileSize) {
                throw new RuntimeException('ファイルサイズ（'.$fileInfo->size() .'）が、許容ファイルサイズ（'.$limitFileSize.'）を超えています。');
            }

            //ファイルタイプを取得
            $this->_mime_type = mime_content_type($file["tmp_name"]);
            if(in_array($this->_mime_type, $this->_allowedAmbiguousMime) or empty($this->_mime_type)){
                $this->_mime_type = $file["type"];
            }
 
            // ファイルタイプのチェックし、拡張子を取得
            if(!empty($this->_allowedMime[$this->_mime_type])){
                $ext = $this->_allowedMime[$this->_mime_type];
            }else{
                throw new RuntimeException('このファイルの形式('.$this->_mime_type.')には対応していません。');
            }
 
            // ファイル名の生成
            //Windows folder 日本語文字化け対策 ファイル名をSJISに
            //$uploadFile = $this->conv_sjis_auto($file["name"]);
            $filename = $file["name"];
            // $hashName = sha1_file($file["tmp_name"]) . "." . $ext;
 
             // if (strpos($uploadFile, '\\') !== false ) {
                // throw new RuntimeException('そのファイル名では保存できません。ファイル名は出来るだけアルファベットをご利用ください。');
            // }  
            // debug($dir . DS . $filename);
            // ファイルの移動
            
            if (!\copy($file["tmp_name"], $dir . DS . $filename)){
            // if (!@move_uploaded_file($file["tmp_name"], $dir . DS . $filename)){
                throw new RuntimeException('ファイルの移動に失敗しました。');
            }
 
        } catch (RuntimeException $e) {
            throw $e;
        }
        return $filename; //ファイル名 UTF-8
    }    
    
    protected function conv_sjis_auto($filename){
        
        return mb_convert_encoding($filename, "SJIS", "AUTO");
       
    }

   
}
