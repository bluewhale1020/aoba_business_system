<?php
namespace App\Controller;

use App\Controller\AppController;
use PHPExcel_IOFactory;
use PHPExcel_CachedObjectStorageFactory;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;
use Cake\Log\Log;
// use \PhpOffice\PhpWord\PhpWord;
// use \PhpOffice\PhpWord\IOFactory;
// use fpdi\FPDI;

///vendor/phpoffice/phpword/src/PhpWord/PhpWord.php
/**
 * Printers Controller
 *
 */

class PrintersController extends AppController {


 public $components = ["Date"];



	public function printOpnumTable(){

		$default = ini_get('max_execution_time');
		set_time_limit(0);

		$this->EquipmentRentals = TableRegistry::get('EquipmentRentals');
		
		$start_year = (int)$this->request->data['start_year'];
		$start_mon = (int)$this->request->data['start_mon'];
		$end_year = (int)$this->request->data['end_year'];
		$end_mon = (int)$this->request->data['end_mon'];

		$m = $start_mon;
		$y = $start_year;
		$x_scale = [];
		while($end_year > $y || ($end_year === $y && $end_mon >= $m) ){
			$x_scale[$y][] = $m;
			$m++;
			if($m > 12){ // loop to the next year
			$m = 1;
			$y++;
			}
		}            


		$start_date = new \DateTime($start_year."-".$start_mon."-1");
		$end_date =  new \DateTime($end_year."-".$end_mon."-1");
		
		$counts = $this->EquipmentRentals->getOperationInfo($start_date, $end_date);
		// debug($counts); die();
		$data = [];                                        
		// (int) 2019 => [(int) 10 => ['counts' => [
		//             (int) 0 => (int) 2,
		//             (int) 1 => (int) 0,
		//             ~~~
		//             (int) 9 => (int) 0
		//         ] ]]
		foreach ($x_scale as $year => $months) {
			foreach ($months as $key => $month) {
				$temp = ["year"=>$year,"month"=>$month,"counts"=>[0,0,0,0,0,0,0,0,0,0]];
				if(!empty($counts[$year][$month])){
					$temp['counts'] = $counts[$year][$month]['counts'];
				}
				$data[] = $temp;
			}
		}

		//データをエクセルファイルに出力	
		//excelファイルの生成
		$filename = 'opnum_table.xlsx';
	
		// 保存ファイルフルパス
		$uploadDir = realpath(TMP);
		$uploadDir .= DS . 'excels' . DS;
		$loadDir = $uploadDir . 'template' . DS;
		$path = $loadDir . $filename;
		
		//Create new PHPExcel object　　
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader -> load($path);
	
		//Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel -> setActiveSheetIndex(0);
		$sheet = $objPHPExcel -> getActiveSheet();
		// シート名をつける
		$sheet -> setTitle("稼働件数");
		// デフォルトのフォント
		$sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
	
		// デフォルトのフォントサイズ
		$sheet -> getDefaultStyle() -> getFont() -> setSize(9);

		$row_cnt = 5;

		//行のスタイル設定
		$style = $sheet->getStyle('A5');

		foreach ($data as $idx => $row){
			
		  //年月
		$cell_pos = 'A' . $row_cnt;
		$sheet -> setCellValue($cell_pos, $row['year'] . "年" . $row['month'] . "月");

		// 可搬			Ｂレ車			Ｍレ車			Ｐ
		// １００㎜	ＤＲ	大角	１００㎜	ＤＲ	大角	１００㎜	四ッ切	ＤＲ	ＤＲ
		$col_idx = 1;
		foreach($row['counts'] as $count){
			//columnIndex 0からスタート, rowIndex 1からスタート, writeString
			$sheet->setCellValueByColumnAndRow( $col_idx, $row_cnt, $count );       

		  $col_idx += 1;
		}			 
			

		//行のスタイル設定
		// AからZまでの文字番号をord()で取得してインクリメント
		for ($char = ord('A'); $char <= ord('K'); $char++) {
			$style = $sheet->getStyle(chr($char) . 5);
			
			// 生成された文字番号からchr()で文字列に戻す
			$sheet->duplicateStyle($style, chr($char) . $row_cnt);
		}                
		//$sheet->duplicateStyle($style, 'A' . $row_cnt);
		$sheet->getRowDimension( $row_cnt )->setRowHeight( 18 );

		
		$row_cnt++;
		
		
		}
	
		//日付
		$today = new \DateTime();
		$week = ["日", "月", "火", "水", "木", "金", "土"];
		$sheet -> setCellValue("A2", $today->format("Y年n月j日　").$week[$today->format('w')].'曜日');         
		$sheet->getStyle( 'A2' )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		// //印刷範囲
		$sheet -> getPageSetup()
		-> setPrintArea('A1:K' . ($row_cnt - 1));                                           

		// Excelファイルの保存 ------------------------------------------
	
		//ファイル名作成
		
		$filename = $today->format("Ymd") ."_".$filename;
		$savepath = $uploadDir . $filename;
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
		$objWriter -> save($savepath);
		
		
		//    Free up some of the memory
		$objPHPExcel -> disconnectWorksheets();
		unset($objPHPExcel);             
		
        $this -> set('filename', $filename);
    
        $this -> set('path', $savepath);

        $this->layout = false;            
    
        $this -> render("print_opnum_table");


		set_time_limit($default);
	}

    public function printBill($bill_id){

        Configure::write("debug",true);
        $default = ini_get('max_execution_time');
        set_time_limit(0);
    


        //excelファイルの生成
        $filename = 'invoice.xlsx';
    
        // 保存ファイルフルパス
        $uploadDir = realpath(TMP);
        $uploadDir .= DS . 'excels' . DS;
        $loadDir = $uploadDir . 'template' . DS;
        $path = $loadDir . $filename;
     
        //using Cache to reduce memory usage
       // $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        // $cacheSettings = array(' memoryCacheSize ' => '8MB');
        // PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        //連続印刷で上記ラインにバグ発生！
        //原因不明の為、コメントアウト
        //Call to a member function getCellCacheController() on a non-object
    
        //Create new PHPExcel object　　
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader -> load($path);
        
        
        /////// $objPHPExcel = new PHPExcel();
    
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel -> setActiveSheetIndex(0);
        $sheet = $objPHPExcel -> getActiveSheet();
        // シート名をつける
        $sheet -> setTitle();
        // デフォルトのフォント
        $sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
    
        // デフォルトのフォントサイズ
        $sheet -> getDefaultStyle() -> getFont() -> setSize(9);
    
        // デフォルトの列幅指定
        //  $sheet->getDefaultColumnDimension()->setWidth(12);
    
        // デフォルトの行の高さ指定
        //$sheet -> getDefaultRowDimension() -> setRowHeight(24);

        $this->MyCompanies = TableRegistry::get('MyCompanies');
        
        $mycompany = $this->MyCompanies->find()
            ->where(['owner' => 1])
            ->first();        
        
               
        //請求データ取得
       $this->Bills = TableRegistry::get('Bills');            
        $bill = $this->Bills->get($bill_id, [
            'contain' => ['BusinessPartners', 'Orders'=>['Clients','WorkPlaces','WorkContents']]
        ]);
        

        // 送付日
        $sheet->setCellValue( "W1",  $bill->bill_sent_date->format("Y/m/d") );
        
        
       //自社情報印字
       //会社名
        $sheet->setCellValue( "T2",  $mycompany->name );            
        //住所
        $sheet->setCellValue( "T4",  $mycompany->address . $mycompany->banchi . $mycompany->tatemono );  
        //電話
        $sheet->setCellValue( "W6",  $mycompany->tel );  
        //FAX
        $sheet->setCellValue( "W7",  $mycompany->fax );
        
        
          
      if($bill){ 
            // 請求先
            if($bill->has('business_partner')){
                $sheet -> setCellValue("A4", $bill->business_partner->name);
            }
            // 請求No
            $sheet -> setCellValue("AE1", $bill->bill_no);
    
    
            //請求明細
            $total = 0;
            $subtotal = 0;
            $row_idx = 16;
            foreach ($bill->orders as $order):
                $subtotal = $order->guaranty_charge + 
                $order->additional_count * $order->additional_unit_price + $order->other_charge;    
                $total += $subtotal;
            
                //品名
                $sheet -> setCellValue("A" . $row_idx, $order->description);
                
                //数量
                    $sheet -> setCellValue("M" . $row_idx, 1);
                
                //単価
                $sheet -> setCellValue("P" . $row_idx, Number::currency($subtotal, "JPY"));
                
                //金額
                $sheet -> setCellValue("U" . $row_idx, Number::currency($subtotal, "JPY"));
                
                
                $row_idx++;
                if($row_idx >24 ){
                    $sheet -> setCellValue("A11","明細の項目数が用紙の最大行を超えています！");
                                
                    break;
                }
            
            endforeach;
    
    
    
            // 合計金額
            $sheet -> setCellValue("U25", Number::currency($total, "JPY"));

            // 消費税

            $sheet -> setCellValue("AB14", Number::currency($bill->consumption_tax, "JPY"));


            // 総額

            $sheet -> setCellValue("F13", Number::currency(($total + $bill->consumption_tax), "JPY"));

        } 


        
        // Excelファイルの保存 ------------------------------------------
    
        //ファイル名作成
        $filename = "no_" . $bill->bill_no ."_".$filename;
        $savepath = $uploadDir . $filename;
    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        $objWriter -> save($savepath);
    
        //    Free up some of the memory
        $objPHPExcel -> disconnectWorksheets();
        unset($objPHPExcel);    


        $this -> set('filename', $filename);
    
        $this -> set('path', $savepath);

        $this->layout = false;            
    
        $this -> render("print_bill");

        set_time_limit($default);        
    }
    
    public function printDeliverySlip($bill_id){
        Configure::write("debug",true);
        $default = ini_get('max_execution_time');
        set_time_limit(0);
    


        //excelファイルの生成
        $filename = 'delivery_slip.xlsx';
    
        // 保存ファイルフルパス
        $uploadDir = realpath(TMP);
        $uploadDir .= DS . 'excels' . DS;
        $loadDir = $uploadDir . 'template' . DS;
        $path = $loadDir . $filename;
     
        //using Cache to reduce memory usage
       // $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        // $cacheSettings = array(' memoryCacheSize ' => '8MB');
        // PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        //連続印刷で上記ラインにバグ発生！
        //原因不明の為、コメントアウト
        //Call to a member function getCellCacheController() on a non-object
    
        //Create new PHPExcel object　　
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader -> load($path);
        
        
        /////// $objPHPExcel = new PHPExcel();
    
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel -> setActiveSheetIndex(0);
        $sheet = $objPHPExcel -> getActiveSheet();
        // シート名をつける
        $sheet -> setTitle();
        // デフォルトのフォント
        $sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
    
        // デフォルトのフォントサイズ
        $sheet -> getDefaultStyle() -> getFont() -> setSize(9);
    
        // デフォルトの列幅指定
        //  $sheet->getDefaultColumnDimension()->setWidth(12);
    
        // デフォルトの行の高さ指定
        //$sheet -> getDefaultRowDimension() -> setRowHeight(24);

        $this->MyCompanies = TableRegistry::get('MyCompanies');
        
        $mycompany = $this->MyCompanies->find()
            ->where(['owner' => 1])
            ->first();        
        
        //請求先
        $this->Bills = TableRegistry::get('Bills');
        
        $bill = $this->Bills->find()
            ->contain(['BusinessPartners'])
            ->where(['Bills.id' => $bill_id])
            ->first();          
  
        //請求データ取得
       $this->Orders = TableRegistry::get('Orders');            
        $orders = $this->Orders->find()
            ->where(['Orders.bill_id' => $bill_id])
            ->contain(['WorkPlaces','WorkContents','Works','FilmSizes'])
            ->order(['Orders.id' => 'ASC'])
            ->all();
        


        
        
       //自社情報印字
       //会社名
        $sheet->setCellValue( "T2",  $mycompany->name );            
        //住所
        $sheet->setCellValue( "T4",  $mycompany->address . $mycompany->banchi . $mycompany->tatemono );  
        //電話
        $sheet->setCellValue( "W6",  $mycompany->tel );  
        //FAX
        $sheet->setCellValue( "W7",  $mycompany->fax );
        
        
          
      if($bill){
        // 送付日
        $sheet->setCellValue( "W1",  $bill->bill_sent_date->format("Y/m/d") );           
        // 請求先
        if($bill->has('business_partner')){
            $sheet -> setCellValue("A4", $bill->business_partner->name);
        }
         // 請求No
        $sheet -> setCellValue("AE1", $bill->bill_no);

      }
      
        //納品明細

        $row_idx = 14;
        foreach ($orders as $order){

        if($order->has('work_place')){
            //派遣先
            $sheet -> setCellValue("M" . $row_idx, $order->work_place->name); 
        } 
        //業務
        if($order->has('work_content')){
            $sheet -> setCellValue("A" . $row_idx, $order->work_content->description);
        }
        
        
        //実施期間
        $sheet -> setCellValue("D" . $row_idx, $order->start_date->format("Y/m/d") . " ～ " . $order->end_date->format("Y/m/d"));
        

        

        if($order->has('works')){
             //撮影番号
             $start_no = $order->works[0]->start_no;
             $end_no = $order->works[0]->end_no;
            $sheet -> setCellValue("Y" . $row_idx, $start_no . " ～ " . $end_no);        
            //欠番
            $absense = $order->works[0]->absent_nums;
            
            if(empty($absense)){
                $absent_num = 0;
            }else{
                $sheet -> setCellValue("AB" . $row_idx, $absense);
                $absentArray = explode(",", $absense);
                $absent_num = count($absentArray);
            }         


            //人数
            $patient_num = $end_no - $start_no + 1 - $absent_num;
            $sheet -> setCellValue("W" . $row_idx, $patient_num);
                         
        }
      
        //フィルム
         if($order->has('film_size')){       
            $sheet -> setCellValue("AF" . $row_idx, $order->film_size->name);
         }
         
         
                  
        $row_idx++;
        if($row_idx >25 ){
            $sheet -> setCellValue("A11","明細の項目数が用紙の最大行を超えています！");
                           
            break;
        }
        
       }//end foreach
 
 


        
        // Excelファイルの保存 ------------------------------------------
    
        //ファイル名作成
        $filename = "no_" . $bill->bill_no ."_".$filename;
        $savepath = $uploadDir . $filename;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        $objWriter -> save($savepath);
    
    
        //    Free up some of the memory
        $objPHPExcel -> disconnectWorksheets();
        unset($objPHPExcel);    

        $this -> set('filename', $filename);
    
        $this -> set('path', $savepath);

        $this->layout = false;            
    
        $this -> render("print_delivery_slip");


        set_time_limit($default); 
        
    }


    public function printLabelSheet($order_id)
    {
        
        Configure::write("debug",false);

        // 保存ファイルフルパス
        $filename = "work_label.docx";
        $uploadDir = realpath(TMP);
        $uploadDir .= DS . 'words' . DS;
        $loadDir = $uploadDir . 'template' . DS;
        $path = $loadDir . $filename;
        $savepath = $uploadDir . $filename;
  
        if(copy($path, $savepath)){            

                //注文データ取得
            $table = TableRegistry::get('Orders');            
            $order = $table->get($order_id, [
                'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes', 'Works']
            ]);
    
            
            //撮影期間
            $date_range = $order->start_date->format("Y年m/d") . " ~ " .$order->end_date->format("m/d");

            // 事業所名  
            if($order->has('work_place')){
                $work_place = $order->work_place->name;
            }else{
                $work_place = '';
            }
    
    
        

            $zip = new \ZipArchive;
            if ($zip->open($savepath) === TRUE) {
            
                $xmlString = $zip->getFromName('word/document.xml');
                $xmlString = str_replace('date_range', $date_range, $xmlString);
                $xmlString = str_replace('work_place', $work_place, $xmlString); 
                $zip->addFromString('word/document.xml', $xmlString);
            
                $zip->close();
            } else {
                throw new Exception('プレースホルダーの置き換え処理に失敗しました。');
            }

            $this -> set('filename', $filename);
            
            $this -> set('path', $savepath);

            $this->layout = false;            
        
            $this -> render("print_label_sheet");

        

        } else{//if copy
             throw new Excetion('雛形ファイルのコピーに失敗しました。');
        }
     
    }

    public function printIrradiationRecord($order_id){
        
            Configure::write("debug",false);
            $default = ini_get('max_execution_time');
            set_time_limit(0);
        
            //excelファイルの生成
            $filename = 'irradiation record.xlsx';
        
            // 保存ファイルフルパス
            $uploadDir = realpath(TMP);
            $uploadDir .= DS . 'excels' . DS;
            $loadDir = $uploadDir . 'template' . DS;
            $path = $loadDir . $filename;
            
            //Create new PHPExcel object　　
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader -> load($path);
            
            
            /////// $objPHPExcel = new PHPExcel();
        
            //Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel -> setActiveSheetIndex(0);
            $sheet = $objPHPExcel -> getActiveSheet();
            // シート名をつける
            $sheet -> setTitle();
            // デフォルトのフォント
            $sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
        
            // デフォルトのフォントサイズ
            $sheet -> getDefaultStyle() -> getFont() -> setSize(9);
        
            // デフォルトの列幅指定
            //  $sheet->getDefaultColumnDimension()->setWidth(12);
        
            // デフォルトの行の高さ指定
            $sheet -> getDefaultRowDimension() -> setRowHeight(13.20);
            
            //注文データ取得
           $table = TableRegistry::get('Orders');            
            $order = $table->get($order_id, [
                'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes', 'Works']
            ]);
                
            //曜日配列
            $week_str_list = ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'];
   
            
            // 開始日
        
            $startDate = new \DateTime($order->start_date->format("Y-m-d"));
            
            $sheet->setCellValue( "C3",  $startDate->format('Y年m月d日　') . $week_str_list[$startDate->format('w')] );
 
            // 終了日
        
             $endDate = new \DateTime($order->end_date->format("Y-m-d"));
             
            // $sheet->setCellValue( "S2",  $endDate->format('Y年m月d日　') . $week_str_list[$endDate->format('w')] );
             
            //期間
           $week = [];$given_holidays =[];
           
           if($order->has('work_place')){
               if(!empty($order->work_place->holiday_numbers) or $order->work_place->holiday_numbers === '0'){
                   $week = explode(",", $order->work_place->holiday_numbers);
               }
               
               $given_holidays = [$order->work_place->holiday1,$order->work_place->holiday2,$order->work_place->holiday3,
           $order->work_place->holiday4,$order->work_place->holiday5,$order->work_place->holiday6,$order->work_place->holiday7];
           }
            //$week = [0,4];
            $holidayCount = $this->Date->getHolidayCount($order->start_date->format("Y-m-d"), $order->end_date->format("Y-m-d"), $week,$given_holidays,false);
            //debug($week);
            $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;
            //debug($num_o_days);die();

            $sheet -> setCellValue("D18", $num_o_days);           
 
            // 開始時間
        
            $startTime = new \DateTime($order->start_time->format("H:i:s"));
            
            $sheet->setCellValue( "C4",  $startTime->format('H:i'));

            // 終了時間
        
            $endTime = new \DateTime($order->end_time->format("H:i:s"));
            
            $sheet->setCellValue( "F4",$endTime->format('H:i'));

            
            //予定人数
             $sheet->setCellValue( "F18", $order->patient_num );
 
            //元請け情報
            if($order->has('client')){
                //元請け名    
                $sheet->setCellValue( "A30",  $order->client->name );
               //DRデータ
               $sheet->setCellValue( "B16",  $order->client->dr );
                                                                            
            }  

             
            //派遣先情報
            if($order->has('work_place')){
                //派遣先名    
                $sheet->setCellValue( "B5",  $order->work_place->name );
                //派遣先住所
                $sheet->setCellValue( "B7",  $order->work_place->address . $order->work_place->banchi . $order->work_place->tatemono );
                //派遣先電話番号
                // $sheet->setCellValue( "AF6",  $order->work_place->tel );
            }
            
        
              
            //部位  
            if($order->has('capturing_region')){            
                $sheet->setCellValue( "B10",  $order->capturing_region->name );
            }
            //サイズ    
            if($order->has('film_size')){            
                $sheet->setCellValue( "D20",  $order->film_size->name );
            }  
            
            //作業データ
            if($order->has('works')){
                 
                  $num_o_equipment = 0;
                
                if(!empty($order->works[0]->equipmentA_id)){
                    
                   $table = TableRegistry::get('Equipments'); 
                    $equipment = $table->find()
                    ->contain(['EquipmentTypes'])
                    ->where(['Equipments.id' => $order->works[0]->equipmentA_id] )
                    ->first();

                    //A装置名
                    if($equipment->has('equipment_type')){
                        $sheet->setCellValue( "H18",  $equipment->equipment_type->name ); 
                     }
                }
                                                             

            }
            
        //幅を設定
        $addedWidth = 0.55; $factor = 1.2;
        $sheet->getColumnDimension( 'A' )->setWidth( (6.22 * $factor +$addedWidth ) );
        $sheet->getColumnDimension( 'B' )->setWidth( (1.67 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'C' )->setWidth( (2.44 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'D' )->setWidth( (3.67 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'E' )->setWidth( (2.22 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'F' )->setWidth( (2.11 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'G' )->setWidth( (3.22 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'H' )->setWidth( (18.44 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'I' )->setWidth( (19.00 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'J' )->setWidth( (6.22 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'K' )->setWidth( (1.67 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'L' )->setWidth( (2.44 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'M' )->setWidth( (3.67 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'N' )->setWidth( (2.22 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'O' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'P' )->setWidth( (3.22 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'Q' )->setWidth( (18.44 * $factor +$addedWidth) );
            
        //高さ指定
          $sheet->getRowDimension( 15 )->setRowHeight( 10 );         
          $sheet->getRowDimension( 31 )->setRowHeight( 9 );

        // //印刷範囲
         $sheet -> getPageSetup()
         ->setHorizontalCentered(true)
          -> setPrintArea('A1:Q31');                                          
 
            // Excelファイルの保存 ------------------------------------------
        
            //ファイル名作成
            $filename = "no_" . $order->order_no ."_".$filename;
            $savepath = $uploadDir . $filename;
        
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
            $objWriter -> save($savepath);
        
            $this -> set('filename', $filename);
        
            $this -> set('path', $savepath);
            
            
            //    Free up some of the memory
            $objPHPExcel -> disconnectWorksheets();
            unset($objPHPExcel);
            
            // $this->autoRender = false;

        
        //ファイルの種類によってContent-Typeを指定　後述するfirefoxのため。
        // $this->response->type('excel');
        
        // response->file()でダウンロードもしくは表示するファイルをセット
        // $this->response->file(
        //   //ファイルパス
        //   $savepath,
        //   [
        //     //ダウンロードしたときのファイル名。省略すれば元のファイル名。
        //     'name'=> $filename,
        //     //これは必須
        //     'download'=>true,
        //   ]
        // );

            $this->layout = false;
             
            
            $this -> render("print_irradiation_record");

            set_time_limit($default);  
        
    }

    public function printWorkSheet($order_id){
        
        Configure::write("debug",true);
        $default = ini_get('max_execution_time');
        set_time_limit(0);
    
        //excelファイルの生成
        $filename = 'work_sheet.xlsx';
    
        // 保存ファイルフルパス
        $uploadDir = realpath(TMP);
        $uploadDir .= DS . 'excels' . DS;
        $loadDir = $uploadDir . 'template' . DS;
        $path = $loadDir . $filename;
        
        //Create new PHPExcel object　　
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader -> load($path);
        
        
        /////// $objPHPExcel = new PHPExcel();
    
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel -> setActiveSheetIndex(0);
        $sheet = $objPHPExcel -> getActiveSheet();
        // シート名をつける
        $sheet -> setTitle();
        // デフォルトのフォント
        $sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
    
        // デフォルトのフォントサイズ
        $sheet -> getDefaultStyle() -> getFont() -> setSize(9);
    
        // デフォルトの列幅指定
        //  $sheet->getDefaultColumnDimension()->setWidth(12);
    
        // デフォルトの行の高さ指定
        //$sheet -> getDefaultRowDimension() -> setRowHeight(24);
        
        //注文データ取得
        $table = TableRegistry::get('Orders');            
        $order = $table->get($order_id, [
            'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes', 'Works']
        ]);
            
        //曜日配列
        $week_str_list = ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'];
   
            
        // 開始日
    
        $startDate = new \DateTime($order->start_date->format("Y-m-d"));
        
        $sheet->setCellValue( "H2",  $startDate->format('Y年m月d日　') . $week_str_list[$startDate->format('w')] );

        // 終了日
    
        $endDate = new \DateTime($order->end_date->format("Y-m-d"));
        
        $sheet->setCellValue( "S2",  $endDate->format('Y年m月d日　') . $week_str_list[$endDate->format('w')] );
        
        //期間
        $week = [];$given_holidays =[];
        
        if($order->has('work_place')){
            if(!empty($order->work_place->holiday_numbers) or $order->work_place->holiday_numbers === '0'){
                $week = explode(",", $order->work_place->holiday_numbers);
            }
            
        $given_holidays = [$order->work_place->holiday1,$order->work_place->holiday2,$order->work_place->holiday3,
        $order->work_place->holiday4,$order->work_place->holiday5,$order->work_place->holiday6,$order->work_place->holiday7];
        }
        //$week = [0,4];
        $holidayCount = $this->Date->getHolidayCount($order->start_date->format("Y-m-d"), $order->end_date->format("Y-m-d"), $week,$given_holidays,false);
        //debug($week);
        $num_o_days = $endDate->diff($startDate)->format('%a') + 1 - $holidayCount;
        //debug($num_o_days);die();

        $sheet -> setCellValue("AB2", $num_o_days);           


        // 開始時間
    
        $startTime = new \DateTime($order->start_time->format("H:i:s"));
        
        $sheet->setCellValue( "H4",  $startTime->format('H時i分'));

        // 終了時間
    
        $endTime = new \DateTime($order->end_time->format("H:i:s"));
        
        $sheet->setCellValue( "O4",$endTime->format('H時i分'));

        
        //予定人数
            $sheet->setCellValue( "Z4", $order->patient_num );
        
        //派遣先情報
        if($order->has('work_place')){
            //派遣先名    
            $sheet->setCellValue( "H6",  $order->work_place->name );
            //派遣先住所
            $sheet->setCellValue( "H10",  $order->work_place->address . $order->work_place->banchi . $order->work_place->tatemono );
            //派遣先電話番号
            $sheet->setCellValue( "AF6",  $order->work_place->tel );
        }
        
        //元請け情報
        if($order->has('client')){
            //元請け名    
            $sheet->setCellValue( "H14",  $order->client->name );
            //元請け郵便番号
            $sheet->setCellValue( "H18", "〒" . $order->client->postal_code );                
            //元請け住所
            $sheet->setCellValue( "M18",  $order->client->address . $order->work_place->banchi . $order->work_place->tatemono );
            //元請け電話番号
            $sheet->setCellValue( "AF14",  $order->client->tel );
            //元請けFAX    
            $sheet->setCellValue( "AF16",  $order->client->fax ); 
            //元請け担当者１    
            $sheet->setCellValue( "AF20",  $order->client->staff );
            //元請け担当者２
            $sheet->setCellValue( "AF18",  $order->client->staff2 );
                                                                            
        }  
        
        //届け先   
        $sheet->setCellValue( "H22",  $order->recipient );
        //請求先    
        $sheet->setCellValue( "R22",  $order->payment );              
            
            
        //部位  
        if($order->has('capturing_region')){            
            $sheet->setCellValue( "AD4",  $order->capturing_region->name );
        }
        //サイズ    
        if($order->has('film_size')){            
            $sheet->setCellValue( "AG4",  $order->film_size->name );
        }  
        //業務    
        if($order->has('work_content')){            
            $sheet->setCellValue( "T4",  $order->work_content->name );
        }
        
        //作業データ
        if($order->has('works')){
                
                $num_o_equipment = 0;
            
            if(!empty($order->works[0]->equipmentA_id)){
                $num_o_equipment++;
                $table = TableRegistry::get('Equipments'); 
                $equipment = $table->find()
                ->contain(['EquipmentTypes'])
                ->where(['Equipments.id' => $order->works[0]->equipmentA_id] )
                ->first();

                //A装置名
                if($equipment->has('equipment_type')){
                    $sheet->setCellValue( "AA22",  $equipment->equipment_type->name ); 
                }
            }
            if(!empty($order->works[0]->equipmentB_id)){
                $num_o_equipment++;
            }
            if(!empty($order->works[0]->equipmentC_id)){
                $num_o_equipment++;
                }
            if(!empty($order->works[0]->equipmentD_id)){
                $num_o_equipment++;
            }
            if(!empty($order->works[0]->equipmentE_id)){
                $num_o_equipment++;
            }   
            //台数
            $sheet->setCellValue( "AF2",  $num_o_equipment );
                                                            

        }
 
        //幅を設定
        $addedWidth = 0.7; $factor = 1.3;
        $sheet->getColumnDimension( 'A' )->setWidth( (1.89 * $factor +$addedWidth ) );
        $sheet->getColumnDimension( 'B' )->setWidth( (3.33 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'C' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'D' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'E' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'F' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'G' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'H' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'I' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'J' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'K' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'L' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'M' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'N' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'O' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'P' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'Q' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'R' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'S' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'T' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'U' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'V' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'W' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'X' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'Y' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'Z' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AA' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AB' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AC' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AD' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AE' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AF' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AG' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AH' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AI' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AJ' )->setWidth( (1.89 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'AK' )->setWidth( (1.89 * $factor +$addedWidth) );
            
        //高さ指定
         // $sheet->getRowDimension( 5 )->setRowHeight( 13.2 );

        // //印刷範囲
          $sheet -> getPageSetup()
         // ->setHorizontalCentered(true)
           -> setPrintArea('A1:AK43');
                                             
 
            // Excelファイルの保存 ------------------------------------------
        
            //ファイル名作成
            $filename = "no_" . $order->order_no ."_".$filename;
            $savepath = $uploadDir . $filename;
        
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
            $objWriter -> save($savepath);
        
            $this -> set('filename', $filename);
        
            $this -> set('path', $savepath);
        
            //    Free up some of the memory
            $objPHPExcel -> disconnectWorksheets();
            unset($objPHPExcel);             
            

            $this->layout = false;
            
           
            $this -> render("print_work_sheet");

            set_time_limit($default);           
    }

      
    public function printOrderConfirmation($order_id){
        
        Configure::write("debug",false);
            $default = ini_get('max_execution_time');
            set_time_limit(0);
        
            $this -> export_order_confirmation($order_id);

           // $this->viewBuilder()->layout(false);
            $this->layout = false;
            
           
            $this -> render("print_order_confirmation");

            set_time_limit($default);        
        
    }
    
    protected function export_order_confirmation($order_id){
 

        //excelファイルの生成
        $filename = 'order_confirmation.xlsx';
    
        // 保存ファイルフルパス
        $uploadDir = realpath(TMP);
        $uploadDir .= DS . 'excels' . DS;
        $loadDir = $uploadDir . 'template' . DS;
        $path = $loadDir . $filename;
    
        //using Cache to reduce memory usage
        // $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        // $cacheSettings = array(' memoryCacheSize ' => '8MB');
        // PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        //連続印刷で上記ラインにバグ発生！
        //原因不明の為、コメントアウト
        //Call to a member function getCellCacheController() on a non-object
    
        //Create new PHPExcel object　　
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader -> load($path);
        
        
        /////// $objPHPExcel = new PHPExcel();
    
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel -> setActiveSheetIndex(0);
        $sheet = $objPHPExcel -> getActiveSheet();
        // シート名をつける
        $sheet -> setTitle();
        // デフォルトのフォント
        $sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
    
        // デフォルトのフォントサイズ
        $sheet -> getDefaultStyle() -> getFont() -> setSize(9);
    
        // デフォルトの列幅指定
        //  $sheet->getDefaultColumnDimension()->setWidth(12);
    
        // デフォルトの行の高さ指定
        //$sheet -> getDefaultRowDimension() -> setRowHeight(24);
        
        //注文データ取得
        $table = TableRegistry::get('Orders');    

        $order = $table->get($order_id, [
            'contain' => ['Clients','WorkPlaces', 'WorkContents', 'CapturingRegions', 'FilmSizes', 'Works']
        ]);
        
        
        // 作成日
    
        $createdDate = new \DateTime();
        
        $sheet->setCellValue( "W1",  $createdDate->format('Y-m-d') );
        
        if($order){ 
            // 元請け
            if($order->has('client')){
                $sheet -> setCellValue("A4", $order->client->name);
            }

            // 受注No
            $sheet -> setCellValue("AE1", $order->order_no);

            // 合計金額
            $total = $order->guaranty_charge +
            $order->additional_count * $order->additional_unit_price; 

            $sheet -> setCellValue("U25", $total);

            // 消費税
            $sheet -> setCellValue("AB14", floor($total * 0.1));

            
            // 総額
            $sheet -> setCellValue("F13", floor($total * (1.1)));
                                                    
            
            //撮影装置名をまとめる
            if($order->has('works')){
                $table = TableRegistry::get('Equipments'); 
                $equipments = $table->find('list')->toArray();
                
                $item_name = [];
                
                if(!empty($order->works->equipmentA_id)){
                        $item_name[] = $equipments[$order->works->equipmentA_id];  
                }
                if(!empty($order->works->equipmentB_id)){
                        $item_name[] = $equipments[$order->works->equipmentB_id];  
                }
                if(!empty($order->works->equipmentC_id)){
                    $item_name[] = $equipments[$order->works->equipmentC_id];  
                }
                if(!empty($order->works->equipmentD_id)){
                    $item_name[] = $equipments[$order->works->equipmentD_id];  
                }
                if(!empty($order->works->equipmentE_id)){
                    $item_name[] = $equipments[$order->works->equipmentE_id];  
                }
                    
                
                $str_itemname = implode(" ", $item_name);
            }
            // 品名
            $item_name = (($order->has('work_place'))? $order->work_place->name : ""). " " .
                (($order->has('work_content'))? $order->work_content->description : ""). " " .
                (($order->has('capturing_region'))? $order->capturing_region->name : ""). " " .
                $str_itemname. " " .
            (($order->has('film_size'))? $order->film_size->name : "");
            
            $sheet -> setCellValue("A16", $item_name);

        } 
        
        // Excelファイルの保存 ------------------------------------------
    
        //ファイル名作成
        $filename = "no_" . $order->order_no ."_".$filename;
        $savepath = $uploadDir . $filename;
    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        $objWriter -> save($savepath);
    
        $this -> set('filename', $filename);
    
        $this -> set('path', $savepath);
    
        //    Free up some of the memory
        $objPHPExcel -> disconnectWorksheets();
        unset($objPHPExcel);             
        
        
    }


    function printAccountReceivable($year,$month,$partner_id = null){
        
        //データを検索する
        $conditions = [];
        
        //対象月
            if(!empty($year) and !empty($month)){
                
            $targetDate =new \DateTime($year."/".($month)."/1");
            
            $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 
            
        }else{
            $targetDate = new \DateTime();

            $conditions[] = ["Orders.end_date BETWEEN '".$targetDate->format("Y-m-1")."' AND '".$targetDate->format("Y-m-t")."'"]; 

        }           
        //取引先
        if(!empty($partner_id)){
                $conditions[] = ['payer_id' => $partner_id];       

            }

            $this->Orders = TableRegistry::get('Orders');
            
            $query = $this->Orders->find_account_receivable_data($conditions); 
            $orders = $query->all()->toArray();
            $accountReceivables = $this->Orders->sort_account_receivable_data($orders);			      

    
    
        //Configure::write("debug",false);
        $default = ini_get('max_execution_time');
        set_time_limit(0);
    
        //excelファイルの生成
        $filename = 'account_receivable.xlsx';
    
        // 保存ファイルフルパス
        $uploadDir = realpath(TMP);
        $uploadDir .= DS . 'excels' . DS;
        $loadDir = $uploadDir . 'template' . DS;
        $path = $loadDir . $filename;
        
        //Create new PHPExcel object　　
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //$objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader -> load($path);
        
        
        /////// $objPHPExcel = new PHPExcel();
    
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel -> setActiveSheetIndex(0);
        $sheet = $objPHPExcel -> getActiveSheet();
        // シート名をつける
        $sheet -> setTitle();
        // デフォルトのフォント
        $sheet -> getDefaultStyle() -> getFont() -> setName('ＭＳ Ｐゴシック');
    
        // デフォルトのフォントサイズ
        $sheet -> getDefaultStyle() -> getFont() -> setSize(9);
    
        // デフォルトの列幅指定
        //  $sheet->getDefaultColumnDimension()->setWidth(12);
    
        // デフォルトの行の高さ指定
        $sheet -> getDefaultRowDimension() -> setRowHeight(13.20);

        $row_cnt = 5;

        //行のスタイル設定
        $style = $sheet->getStyle('A5');

        foreach ($accountReceivables as $payer_id => $accountReceivable){
            
            //請求先名
            $cell_pos = 'A' . $row_cnt;
            $sheet -> setCellValue($cell_pos, $accountReceivable['payer_name']);
                            
            //売上高
            $cell_pos = 'B' . $row_cnt;
            $sheet -> setCellValue($cell_pos, $accountReceivable['sales']); 

            //請求額
            $cell_pos = 'C' . $row_cnt;
            $sheet -> setCellValue($cell_pos, $accountReceivable['charged']); 

            //未請求残高
            $cell_pos = 'D' . $row_cnt;
            $unbilled = $accountReceivable['sales'] -  $accountReceivable['charged'];            
            $sheet -> setCellValue($cell_pos, $unbilled);

            //回収高
            $cell_pos = 'E' . $row_cnt;
            $sheet -> setCellValue($cell_pos, $accountReceivable['received']);             
                
            

            //行のスタイル設定
            // AからZまでの文字番号をord()で取得してインクリメント
            for ($char = ord('A'); $char <= ord('Z'); $char++) {
                $style = $sheet->getStyle(chr($char) . 5);
                
                // 生成された文字番号からchr()で文字列に戻す
                $sheet->duplicateStyle($style, chr($char) . $row_cnt);
            }

            $row_cnt++;
            
        }
        
        //日付
        $today = new \DateTime();
        $sheet -> setCellValue("E1", $today->format("Y/m/d"));         
        $sheet->getStyle( 'E1' )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //題
        $sheet -> setCellValue("B1", $year . "年" . $month . "月分");         
            
        //幅を設定
        $addedWidth = 0; $factor = 1.1;
        $sheet->getColumnDimension( 'A' )->setWidth( (28 * $factor +$addedWidth ) );
        $sheet->getColumnDimension( 'B' )->setWidth( (20 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'C' )->setWidth( (15.10 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'D' )->setWidth( (15.10 * $factor +$addedWidth) );
        $sheet->getColumnDimension( 'E' )->setWidth( (15.10 * $factor +$addedWidth) );

        
        //字下げ
        $sheet->getStyle("A1:A".($row_cnt -1))->getAlignment()->setWrapText(true);
        
        // //印刷範囲
         $sheet -> getPageSetup()
         //->setHorizontalCentered(true)
          -> setPrintArea('A1:E' . ($row_cnt - 1));                                            
 
        // Excelファイルの保存 ------------------------------------------
    
        //ファイル名作成
        
        $filename = $today->format("Ymd") ."_".$filename;
        $savepath = $uploadDir . $filename;
    

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        $objWriter -> save($savepath);
    
        $this -> set('filename', $filename);
        
        $this -> set('path', $savepath);
        
        
        //    Free up some of the memory
        $objPHPExcel -> disconnectWorksheets();
        unset($objPHPExcel);             
        

        $this->layout = false;
        
        $this -> render("print_account_receivable");

        set_time_limit($default);  
        
    }


    /**
     * ログデータをCSVで出力する
     * 
     */
    public function printLogData()
    {
        $this->EventLogs = TableRegistry::get('EventLogs');

        // 条件（作成期間・ユーザーID・アクション）で検索したログデータを
        // テーブルから取得               
        $conditions = [];
        if($this->request->is('post')){
            //データを検索する
            
            //user id
            if(!empty($this->request->data['ユーザー'])){
                $conditions[] = ['EventLogs.user_id '=> $this->request->data['ユーザー']]; 
            }           
            //期間
            if(!empty($this->request->data['date_range'])){
                $conditions[] = ['EventLogs.created >=' => $this->request->data['start_date']]; 
                  $conditions[] = ['EventLogs.created <=' => $this->request->data['end_date'].' 23:59:59'];              
            }
                        
            //action_type
            if(!empty($this->request->data['アクション'])){
                $conditions[] = ['EventLogs.action_type' => $this->request->data['アクション']]; 
               
            }               
          
        }
        
        // debug($conditions);
        $eventLogs = $this->EventLogs->find()->contain(['Users'])->where($conditions)->order(['EventLogs.created'=>'DESC'])->all();       

        $columns = $this->EventLogs->schema()->columns();


        // CSVフォーマットでログデータを整理する
        
        // ログデータをCSV出力する

        // 保存ファイルパス作成
        $today = new \DateTime();
        $filename = $today->format("y_m_d_") . 'eventlog.csv';

        $uploadDir = realpath( TMP );
        $uploadDir .= DS . 'csvs' . DS;
        $file_path = $uploadDir.$filename;    
            //ヘッダー
        $data_array[] = $columns;
        if(!empty($eventLogs)){ 
            foreach ($eventLogs as $key => $oneRecord) {
                $rec_array = [
                    $oneRecord->id,
                    $oneRecord->created->format("Y/m/d H:i:s"),
                    $oneRecord->event,
                    $oneRecord->action_type,
                    $oneRecord->table_name,
                    $oneRecord->record_id,
                    $oneRecord->user->username,
                    $oneRecord->remote_addr,
                    $this->format_modified_value_object($oneRecord->old_val),
                    $this->format_modified_value_object($oneRecord->new_val),
                ];

                // debug($rec_array);die();
                $data_array[] = $rec_array;
            }
        } 
        
        mb_convert_variables('SJIS-win','UTF-8',$data_array);
        $fp = fopen($file_path, 'w');

        foreach ($data_array as $line) {
            fputcsv($fp, $line);
        }
            
        fclose($fp);

        // ファイルに書き込む
        // $str_data = implode(",", $data_array);
        // file_put_contents($file_path, mb_convert_encoding($str_data, "SJIS"));
   
        //////////////////////////////// csv 出力            
           
       $this -> set('filename', $filename);
    
       $this -> set('path', $file_path);

       $this->layout = false;            
   
       $this -> render("print_log_data");              
    }

    protected function format_modified_value_object($value)
    {
        $value_obj = unserialize($value);

        return  print_r($value_obj,true);

    }
}
