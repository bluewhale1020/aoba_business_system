<?php
namespace App\Controller;

use App\Controller\AppController;
use RuntimeException;

/**
 * DataImports Controller
 *
 *
 * @method \App\Model\Entity\DataImport[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DataImportsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('FileHandler');
        $this->loadComponent('Import');
    }    



    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        if ($this->request->is(['post'])) {
            
            // 下記のログ出力処理を追記
            //$this->log($this->request->data['file_name'],LOG_DEBUG);
            
 
            $dir = realpath(WWW_ROOT . DS . "files");
            $limitFileSize = 1 * 1000 * 1000;//50MB 1024 * 1024;
            try {
                $filename = $this->FileHandler->file_upload($this->request->data['file_name'], $dir, $limitFileSize);
                $colNames = $this->Import->get_colNames_from_EXCEL_for_jqgrid($filename);
                if($colNames){//jqgridのヘッダー名配列
                    $this->set('colNames', $colNames);
                }            

                $this->set('upload_file', $filename);
                $this->Flash->success(__('データファイルを読み込みました。'));             
            } catch (RuntimeException $e){

                $this->Flash->error(__('ファイルのアップロードができませんでした.'));
                $this->Flash->error(__($e->getMessage()));
            }
        }

    }

	public function ajaxloadfiledata($file_name){

        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {

            [$response,$columns] = $this->Import->create_data_from_file_for_jqgrid($file_name);

            $category = $this->Import->categorize_importdata($columns);

            $response->userdata = array('category'=>$category);

            return $this->response->withStringBody(json_encode($response));                 
            // $this->set('result',$response);	            
       
        }

    }



    /**
     * download method
     *
     * @param string|null $id File Upload id.
     * @return \Cake\Http\Response|file $response
     * @throws \Cake\Datasource\Exception\RuntimeException When file not found.
     */
    public function download()
    {
        if ($this->request->is(['post'])) {
            $filename = 'import_' . $this->request->data['filename'] . '.xlsx';
            $dir = realpath(WWW_ROOT . "files");          
            // ダウンロードファイルフルパス
            $file_path = $dir . DS . $filename; 
            try {
                //view無しで 出力
                $this->autoRender = false;

                if(!file_exists($file_path)){
                    throw new RuntimeException('指定のファイルがありません。');
                }          

                $response = $this->response->withFile($file_path, ['download' => true, 'name' => $filename]);                
                // $response = $this->FileHandler->file_download($filename, $dir);
            } catch (RuntimeException $e){
                debug($e->getMessage());
                $this->Flash->error(__('ファイルのダウンロード出力ができませんでした.'));
                $this->Flash->error(__($e->getMessage()));
                return $this->redirect(['action' => 'index']);
            }
            
            return $response;
        }
        
    }


    public function ajaxdataimport($category){
        if ($this->request->is("ajax")) {

            // パラメータ
            $values = array();

            if (isset($this->request->data['dat']))
            {
                $vals = $this->request->data['dat'];
            }
            if (isset($this->request->data['num']))
            {
                $recordNum = $this->request->data['num'];
            }

            switch($category){
                case 'staffs':
                    list($result,$overall_message,$success) = $this->Import->import_staffs($vals);
                break;  
                case 'business_partners':
                    list($result,$overall_message,$success) = $this->Import->import_business_partners($vals);  
                break;
                case 'orders':
                    list($result,$overall_message,$success) = $this->Import->import_orders($vals);  
                break;
            }

            if($success){
                $result['overall'] =array('result'=>1,'message'=>$overall_message);	
            }else{      
                $result['overall'] =array('result'=>0,'message'=>$overall_message);
            }

            return $this->response->withStringBody(json_encode($result));                 
            
            // $this->set('result', $result);

        }        
    }

}
