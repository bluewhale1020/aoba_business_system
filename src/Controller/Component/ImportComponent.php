<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use PHPExcel_IOFactory;
use PHPExcel_CachedObjectStorageFactory;
use PHPExcel_Shared_Date;
use PHPExcel_Settings;
use PHPExcel_Style_NumberFormat;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Import component
 */
class ImportComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $tableModel;

    protected $convTable;

    //$rowdata {rowId: "10", フリガナ: "hoge", 生年月日: "1888-10-10", ...}
    public function import_staffs($rows){
        
        $this->tableModel = TableRegistry::get('Staffs');
        $this->initConvTable("staffs");

        $overall_message = "";
        $result = ['data'=>null];
        $success = true;
        foreach ($rows as $rowdata) {
            // データを整形	sort_import()
            $sorted_data = $this->sort_import($rowdata);
            // 書式内容をチェック
            $staff = $this->tableModel->findOrNew($sorted_data['kana'],$sorted_data['birth_date']);
            $staff = $this->tableModel->patchEntity($staff, $sorted_data);
            if ($staff->errors()) {
                // エンティティー検証失敗。
                $returnData = false;
            }else{
                // データを保存 
                $returnData = $this->tableModel->save($staff);
    
            }

            // 結果データを作成
            list($each_result,$message) = $this->create_result($returnData,$rowdata['id'],$rowdata['氏名']);

            $result['data'][] = $each_result;
            $overall_message .= $message; 
            if($each_result['result'] ==0){$success = false;} 
        } 
        if(empty($overall_message)){
            $overall_message = '処理されたデータはありません。';
        }

        return [$result,$overall_message,$success];
    }

    public function import_business_partners($rows){

        $this->tableModel = TableRegistry::get('BusinessPartners');
        $this->initConvTable("business_partners");

        $overall_message = "";
        $result = ['data'=>null];
        $success = true;        
        foreach ($rows as $rowdata) {
            //定休日[日月火水木金土] を 0~6　の数字に
            $rowdata = $this->tableModel->import_check_holidays($rowdata);
            // データを整形	sort_import()
            $sorted_data = $this->sort_import($rowdata);
            // 書式内容をチェック
            $partner = $this->tableModel->findOrNew($sorted_data['name']);
            $partner = $this->tableModel->patchEntity($partner, $sorted_data);
            if ($partner->errors()) {
                // エンティティー検証失敗。
                $returnData = false;
            }else{
                // データを保存 
                $returnData = $this->tableModel->save($partner);
    
            }

            // 結果データを作成
            list($each_result,$message) = $this->create_result($returnData,$rowdata['id'],$rowdata['取引先名称']);

            $result['data'][] = $each_result;
            $overall_message .= $message; 
            if($each_result['result'] ==0){$success = false;}             
        } 
        if(empty($overall_message)){
            $overall_message = '処理されたデータはありません。';
        }

        return [$result,$overall_message,$success];
    }


    public function import_orders($rows){
        
        $this->tableModel = TableRegistry::get('Orders');
        $this->Works = TableRegistry::get('Works');
        $this->initConvTable("orders");

        $overall_message = "";
        $result = ['data'=>null];
        $success = true;        
        foreach ($rows as $rowdata) {
            // インポートデータの一部修正
            $rowdata = $this->tableModel->modify_import_order($rowdata);

            // データを整形	sort_import()
            $sorted_data = $this->sort_import($rowdata);
            //請求関係設定
            $sorted_data['payment'] = '依頼元';
            $sorted_data = $this->tableModel->modify_requstdata($sorted_data);
            // 書式内容をチェック
            $order = $this->tableModel->findOrNew($sorted_data['order_no']);
            $order = $this->tableModel->patchEntity($order, $sorted_data);
            // debug($order);die();
            if ($order->errors()) {
                // エンティティー検証失敗。
                $returnData = false;
            }else{
                // データを保存 
                if($returnData = $this->tableModel->save($order)){
                    $order_id = $returnData->id;
                    //同時に作業データも作成
                    if($this->Works->find()->where(['order_id'=>$order_id])->count() == 0){
                        $work = $this->Works->newEntity();                                                         
                        $newData = ['order_id' => $order_id];               
                        $work = $this->Works->patchEntity($work, $newData);
                        if (!$this->Works->save($work)) {
                            $this->tableModel->delete($returnData);
                            $returnData = false;
                        }                                    

                    }
                }
    
            }

            // 結果データを作成
            list($each_result,$message) = $this->create_result($returnData,$rowdata['id'],$rowdata['受注No']);

            $result['data'][] = $each_result;
            $overall_message .= $message; 
            if($each_result['result'] ==0){$success = false;}             
        } 
        if(empty($overall_message)){
            $overall_message = '処理されたデータはありません。';
        }

        return [$result,$overall_message,$success];
    }

    

    // データ保存結果の表示メッセージ作成
    protected function create_result($returnData,$id,$name){
        if($returnData != false){

            $result =array('id'=>$id,'result'=>1,'message'=>'結果登録完了');
             $message ='<dl class="dl-horizontal"><dt>'.$name.'</dt>'.
          '<dd ><font color="green">データのインポートに成功しました。</font></dd></dl>';	
            
        }else{		
            $result =array('id'=>$id,'result'=>0,'message'=>'<font color="red">エラー:結果登録失敗！</font>'); 
             $message ='<dl class="dl-horizontal"><dt>'.$name.'</dt>'.
          '<dd ><font color="red">データのインポートに失敗しました。</font></dd></dl>';	
    
         }	

         return [$result,$message];
    }

    // データをテーブルに保存できる書式に整形
    protected function sort_import($rowdata){
        debug($rowdata);
        $importdata = [];
        
        foreach($rowdata as $colname => $value){
            if(!empty($this->convTable[$colname])){
                $col_info = $this->convTable[$colname];

                //idデータを、名前で受け取っている場合は、関連するテーブルからidを取得して、変換する
                if($col_info['is_id_number'] == 1 and !empty($value)){
                    $value = $this->_get_id_table_data($value,$col_info['id_tb_name']);
                }        
                
                //必要ならば値の変換
                if(!empty($col_info['conv'])){
                    $value = $this->{$col_info['conv']}($value);
                }
                // スタッフ、取引先、注文情報をキー配列 array($item_name=>$value)形式で$importdataに保存
                $importdata[$col_info['item_name']] = $value; 
 
            }//if $col_info      
            else{
                    // $importdata['Others'] = $value; 
            }             
        }
        debug($importdata);//die();
        
        // $importdataを返す
        return $importdata; 
    }

    //変換テーブルの初期化
    protected function initConvTable($category){
        $table = TableRegistry::get('ImportDataConversions');
        $query = $table->find()->where(['category' => $category]);
        $data = $query->all()->toArray();
        $this->convTable = Hash::combine($data, '{n}.name', '{n}');
    }

    // 対象テーブルからname==$valueまたは、description==$value(work_contents)のIDを返す
    protected function _get_id_table_data($value,$id_tb_name){
        $table = TableRegistry::get($id_tb_name);

        //debug($value);debug($id_tb_name);
        if($id_tb_name == 'WorkContents'){
            $data = $table->find()->where(['description' => $value])->first();       
        }else{
            $data = $table->find()->where(['name' => $value])->first();         
        } 
        if($data){
            return $data->id;
        }else{
            return null;
        }          
            
    }

    //性別データの変換
    protected function _conv_sex($value){

        if($value == '男'){
            return 1;
        }elseif($value == '女'){
            return 2;

        }

    }

    //ステータスデータの変換
    protected function _conv_status($value){
        if(\is_numeric($value)){
            return $value;
        }

        if($value == '正式登録'){
            return 0;
        }elseif($value == '仮登録'){
            return 1;

        }

    }


/**
 * get_colNames_from_EXCEL_for_jqgrid method
 * 
 * $file_nameのエクセルファイルから、一列目のカラム名の配列を返す
 * 
 */
 	
    public function get_colNames_from_EXCEL_for_jqgrid($file_name){
	       
        // 保存ファイルフルパス
        $file = WWW_ROOT.'files'.DS.$file_name;
        

        //using Cache to reduce memory usage
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( ' memoryCacheSize ' => '8MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    
        //Create new PHPExcel object
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');

            //$objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file);
        
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex( 0 );
        $sheet = $objPHPExcel->getActiveSheet();    
            
        //$fileData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        //エクセルからデータを配列に一括格納 
        $highestColumn = $sheet->getHighestColumn();
        
        $sheetData = $sheet->rangeToArray(
            'A1:' . $highestColumn . '1',
            NULL,TRUE,FALSE
        );        

    
    
        // Excelファイルを閉じる ------------------------------------------
                //    Free up some of the memory 
        $objPHPExcel->disconnectWorksheets(); 
        unset($objPHPExcel);
        
       return $sheetData[0];
	}

    /**
     * get_data_from_file_for_jqgrid method
     * 
     * $file_nameのエクセルファイルから、データを取得してjqgrid用配列にして返す
     * 
     */
    public function create_data_from_file_for_jqgrid($file_name){
        
        // 保存ファイルフルパス   
       $file = WWW_ROOT.'files'.DS.$file_name;
        
   
        //using Cache to reduce memory usage
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( ' memoryCacheSize ' => '8MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    
        //Create new PHPExcel object
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
   
       //$objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file);
    
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex( 0 );
        $sheet = $objPHPExcel->getActiveSheet();		
           
       
        $row_idx = 1;
   
       //$fileData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
       //エクセルからデータを配列に一括格納	
       $highestRow = $sheet->getHighestRow(); 
       $highestColumn = $sheet->getHighestColumn();
       
       $sheetData = $sheet->rangeToArray(
           'A2:' . $highestColumn . $highestRow,
           NULL,TRUE,FALSE
       );
   
       $columns = $sheet->rangeToArray(
           'A1:' . $highestColumn . "1",
           NULL,TRUE,FALSE
       );


	    // Excelファイルを閉じる ------------------------------------------
        //    Free up some of the memory 
        $objPHPExcel->disconnectWorksheets(); 
        unset($objPHPExcel);

        $dateColArray = [];$timeColArray = [];
        foreach ($columns as $key => $arrCol) {
            for ($j=0; $j < count($arrCol); $j++) {
                if(in_array($arrCol[$j], array("開始日","終了日","生年月日"))){
                    $dateColArray[] = $j;
                }elseif(in_array($arrCol[$j], array("開始時間","終了時間"))){
                    $timeColArray[] = $j;
                } 
                
            }         
            
            
        }        

        $response = new \stdClass;  
    
        $response->page = 1 ;//$page; 
        $response->total = 1; //$total_pages; 
        $response->records = count( $sheetData );//$count;	
            
            
        $i=0;	
    
            
        //$sheetDataからグリッド用データ構造体を作成　　
        foreach ($sheetData as $row => $arrCol) {
            
            // $rowData = [];
            // $rowData [] = '';
            // $rowData[] = $i;
            $rowData = ['',$i];
            for ($j=0; $j < count($arrCol); $j++) {
                if(in_array($j, $timeColArray)){
                    //予約時間を変換 00:00:00から 00:00
                    if(!empty($arrCol[$j])){//debug($arrCol[$j]);die();
                    $rowData[] = PHPExcel_Style_NumberFormat::toFormattedString($arrCol[$j],
                        PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
                        
                    }else{
                        $rowData[] = null;
                    }
                }elseif(!in_array($j, $dateColArray) ){
                    $rowData[] = $arrCol[$j];				
                }else{//数字から日付に変換する
                // debug($arrCol[$j]);
                    if(is_numeric($arrCol[$j])){
                        $tempDateObj = PHPExcel_Shared_Date::ExcelToPHPObject($arrCol[$j]);
                        $rowData[] = $tempDateObj->format("Y-m-d");                   
                    }else{
                        $tempDateObj = new \DateTime($arrCol[$j]);
                        $rowData[] = $tempDateObj->format("Y-m-d");                       
                    }
    
                    
                }
                
            }      
                
            $response->rows[$i]['id']=$i;
            $response->rows[$i]['cell']= $rowData; 	
        
            $i++; 		
        }	
            
        return [$response,$columns[0]];   

    }

    //インポートデータのカテゴリ分け
    public function categorize_importdata($columns){
        $table = TableRegistry::get('ImportDataConversions');

        $data = $table->find('all');
        $data->select([
            'category',
            'count' => $data->func()->count('*')
        ])
            ->where(['name IN' => array_slice($columns,0,5)])
            ->group('category');
       
        $max = 0;$max_item= '';
        foreach ($data as $items) {
            if($max < $items['count']){
                $max = $items['count'];
                $max_item = $items['category'];
            }
        }
        return $max_item;

    }

}
