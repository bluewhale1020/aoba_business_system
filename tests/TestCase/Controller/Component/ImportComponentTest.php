<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ImportComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use App\Model\Table\ImportDataConversions;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\Component\ImportComponent Test Case
 */
class ImportComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\ImportComponent
     */

    public $fixtures = [
        'app.ImportDataConversions',
        'app.occupations',
        'app.titles',
        'app.staffs',    
        'app.business_partners',    
        'app.WorkContents',    
        'app.CapturingRegions',    
        'app.FilmSizes',    
        'app.orders',    
        'app.works',    
    ];

    public $Import;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Import = new ImportComponent($registry);
    
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Import);

        parent::tearDown();
    }

    /**
     * Test import_staffs method
     *
     * @return void
     */
    public function testImportStaffs()
    {
        $this->Staffs = TableRegistry::get('Staffs');

        $rowdata = [
            [
                'id'=>1,
                '氏名' => 'hoge',
                'フリガナ' => 'ほげ',
                '生年月日' => '1980-01-01',
                '性別' => '男',
                '電話番号' => '01-2222-3333',
                '郵便番号' => '120-0001',
                '住所' => '東京都青葉区青葉',
                '番地' => '1-2-3',
                '建物名' => 'たてもの',
                '職種１' => '放射線技師',
                '職種２' => '臨床検査技師',
                '肩書' => '正規社員',
                '備考' => '備考'
            ],
            [
                'id'=>2,
                '氏名' => 'hoge2',
                'フリガナ' => 'ほげ2',
                '生年月日' => '1980-01-02',
                '性別' => '女',
                '職種１' => '一般',
                '職種２' => '看護師',
                '肩書' => 'バイト'
            ],            
            [
                'id'=>3,
                '氏名' => 'hoge3',
                'フリガナ' => '',
                '生年月日' => '',
                '性別' => '女',
                '職種１' => '一般',
                '職種２' => '看護師',
                '肩書' => 'バイト'
            ],            
        ];
        $expected = [
            [
                'name' => 'hoge',
                'kana' => 'ほげ',
                'sex' => 1,
                'tel' => '01-2222-3333',
                'postal_code' => '120-0001',
                'address' => '東京都青葉区青葉',
                'banchi' => '1-2-3',
                'tatemono' => 'たてもの',
                'occupation_id' =>  2,
                'occupation2_id' =>  4,
                'title_id' =>  3,
                'notes' => '備考'
            ],
            [
                'name' => 'hoge2',
                'kana' => 'ほげ2',
                'sex' => 2,
                'occupation_id' =>  5,
                'occupation2_id' =>  3,
                'title_id' =>  4,
            ],
            false,
        ];
        list($result,$overall_message,$success) = $this->Import->import_staffs($rowdata); 
        foreach ($rowdata as $idx => $row) {
            $name = $row['氏名'];
            $actual = $this->Staffs->findByName($name)->first();
            if($actual){
                $actual = $actual->toArray();
                // debug($actual);
                foreach ($expected[$idx] as $key => $value) {
                    $this->assertEquals($value,$actual[$key]);              
                 }
            }else{
                $this->assertFalse($expected[$idx]);
            }
        }
        unset($this->Staffs);
    }

    /**
     * Test import_business_partners method
     *
     * @return void
     */
    public function testImportBusinessPartners()
    {
        $this->BusinessPartners = TableRegistry::get('BusinessPartners');

        $rowdata = [
            [
                'id' => '1',
                '取引先名称' => '青葉学園　教職員',
                'フリガナ' => 'あおばがくえん',
                '請負元' => '0',
                '派遣先' => '1',
                '請負元名称' => '一般財団法人野分記念医学財団　富井診療所',
                '仕入先' => '0',
                '定休日' => '木,金,土',
                '特定休日' => '2019/10/09,2019/10/08',
            ],
            [
                'id' => '2',
                '取引先名称' => '株式会社 青葉',
                'フリガナ' => 'あおば',
                '郵便番号' => '4727410',
                '住所' => '兵庫県渡辺市',
                '番地' => '津田町青山7-2-7',
                '電話番号' => '0013-26-3741',
                'FAX' => '080-6197-8874',
                '請負元' => '1',
                '派遣先' => '0',
                '請負元名称' => '',
                '仕入先' => '',
            ],            
            [
                'id' => '3',
                '取引先名称' => 'test',
                'フリガナ' => 'ttest',
                '請負元' => '0',
                '派遣先' => '1',
                '請負元名称' => '一般財団法人野分記念医学財団　富井診療所',
                '仕入先' => '0',
                '定休日' => '木,金,土',
                '特定休日' => 'awefa2342',
            ],            
            [
                'id' => '4',
                '取引先名称' => 'test2',
                'フリガナ' => 'ttest2',
                '請負元' => '0',
                '派遣先' => '1',
                '請負元名称' => '一般財団法富井診療所',
                '仕入先' => '0',
                '定休日' => '木,金,土',
            ],            
            [
                'id' => '4',
                'フリガナ' => 'ttest2',
                '請負元' => '1',
                '派遣先' => '0',
                '仕入先' => '0',
                '定休日' => '木,金,土',
            ],            
        ];
        $expected = [
            [
                'name' => '青葉学園　教職員',
                'kana' => 'あおばがくえん',
                'is_client' => 0,
                'is_work_place' => 1,
                'parent_id' => 1,
                'is_supplier' => 0,
                'holiday_numbers' => '4,5,6',
                'specific_holidays' => '2019/10/09,2019/10/08'
            ],
            [
                'name' => '株式会社 青葉',
                'kana' => 'あおば',
                'postal_code' => '4727410',
                'address' => '兵庫県渡辺市',
                'banchi' => '津田町青山7-2-7',
                'tel' => '0013-26-3741',
                'fax' => '080-6197-8874',
                'is_client' => 1,
                'is_work_place' => 0,
                'parent_id' => '',
                'is_supplier' => '',
            ],
            false,false,false,
        ];
        list($result,$overall_message,$success) = $this->Import->import_business_partners($rowdata); 
        debug($result);debug($overall_message);debug($success);
        foreach ($rowdata as $idx => $row) {
            $name = $row['取引先名称'];
            $actual = $this->BusinessPartners->findByName($name)->first();
            if($actual){
                $actual = $actual->toArray();
                // debug($actual);
                foreach ($expected[$idx] as $key => $value) {
                    $this->assertEquals($value,$actual[$key]);              
                 }
            }else{
                $this->assertFalse($expected[$idx]);
            }
        }

        unset($this->BusinessPartners);

    }

    /**
     * Test import_orders method
     *
     * @return void
     */
    public function testImportOrders()
    {
        $this->Orders = TableRegistry::get('Orders');

        $rowdata = [
            [
                'id' => '0',
                '受注No' => 'order30',
                '請負元' => '株式会社 廣川',
                '派遣先' => '有限会社 伊藤',
                'ステータス' => '0',
                '備考' => '',
                '開始日' => '2019-11-05',
                '終了日' => '2019-11-08',
                '開始時間' => '10:00:00',
                '終了時間' => '15:00:00',
                '業務内容' => '貸出',
                '撮影部位' => '胃部',
                'フィルムサイズ' => '100mm',
                '受診者数' => '100',
                '読影' => '1',
                '保証料金' => '100000',
                '保証人数' => '50',
                '追加人数' => '50',
                '追加料金単価' => '1000',
                'description' => '有限会社 伊藤 貸出 胃部 100mm'
            ],
            [
                'id' => '1',
                '受注No' => 'order31',
                '請負元' => '株式会社 吉田',
                '派遣先' => '株式会社 井上',
                'ステータス' => '仮登録',
                '開始日' => '2019-11-10',
                '終了日' => '2019-11-13',
                '開始時間' => '10:00:00',
                '終了時間' => '15:00:00',
                '業務内容' => '撮影',
                '撮影部位' => '胸部',
                'フィルムサイズ' => 'DR',
                'description' => '株式会社 井上 撮影 胸部 DR'
            ],            
            [
                'id' => '2',
                '受注No' => 'order32',
                '請負元' => '株式会社 青葉ホールディングス',
                '派遣先' => '株式会社 井下',
                'ステータス' => '正式登録',
                '開始日' => '2019-11-10',
                '終了日' => '2019-11-13',
                '開始時間' => '10:00:00',
                '終了時間' => '15:00:00',
            ],            
            [
                'id' => '3',
                '受注No' => 'order33',
                '請負元' => '',
                '派遣先' => '',
                'ステータス' => '正式登録',
                '開始日' => '2019-11-10',
                '終了日' => '2019-11-13',
                '開始時間' => '10:00:00',
                '終了時間' => '15:00:00',
            ],            
            [
                'id' => '4',
                '受注No' => 'order34',
                '請負元' => '株式会社 吉田',
                '派遣先' => '株式会社 井上',
                'ステータス' => '仮登録',
                '開始日' => 'aewf',
                '終了日' => 'fw',
                '開始時間' => '0000',
                '終了時間' => '15100',
                '業務内容' => '撮影',
                '撮影部位' => '胸部',
                'フィルムサイズ' => 'DR',
                'description' => '株式会社 井上 撮影 胸部 DR'
            ],            
        ];
        $expected = [
            [
                'order_no' => 'order30',
                'client_id' => 6,
                'work_place_id' => 19,
                'temporary_registration' => 0,
                'start_date' => '2019-11-05',
                'end_date' => '2019-11-08',
                'start_time' => '10:00:00',
                'end_time' => '15:00:00',
                'work_content_id' => 2,
                'capturing_region_id' => 2,
                'film_size_id' => 1,
                'patient_num' => 100,
                'need_image_reading' => 1,
                'guaranty_charge' => 100000,
                'guaranty_count' => 50,
                'additional_count' => 50,
                'additional_unit_price' => 1000,
                'description' => '有限会社 伊藤 貸出 胃部 100mm'
            ],
            [
                'order_no' => 'order31',
                'client_id' => 7,
                'work_place_id' => 20,
                'temporary_registration' => 1,
                'start_date' => '2019-11-10',
                'end_date' => '2019-11-13',
                'start_time' => '10:00:00',
                'end_time' => '15:00:00',
                'work_content_id' => 1,
                'capturing_region_id' => 1,
                'film_size_id' => 2,
                'description' => '株式会社 井上 撮影 胸部 DR'
            ],
            false,false,false,
        ];
        list($result,$overall_message,$success) = $this->Import->import_orders($rowdata); 
        debug($result);debug($overall_message);debug($success);
        foreach ($rowdata as $idx => $row) {
            $name = $row['受注No'];
            $actual = $this->Orders->find()->where(['order_no'=>$name])->first();
            if($actual){
                $actual = $actual->toArray();
                // debug($actual);
                foreach ($expected[$idx] as $key => $value) {
                    if(\in_array($key, ['start_date','end_date']) and !\is_string($actual[$key])){
                        $actual[$key] = $actual[$key]->i18nFormat('YYYY-MM-dd');
                    }else if(\in_array($key, ['start_time','end_time']) and !\is_string($actual[$key])){
                        $actual[$key] = $actual[$key]->i18nFormat('HH:mm:ss');
                    }

                    $this->assertEquals($value,$actual[$key]);              

                }
            }else{
                $this->assertFalse($expected[$idx]);
            }
        }

        unset($this->Orders);

    }

    /**
     * Test get_colNames_from_EXCEL_for_jqgrid method
     *
     * $file_nameのエクセルファイルから、一列目のカラム名の配列を返す
     * @return void
     */
    public function testGetColNamesFromEXCELForJqgrid()
    {
        $filename = "import_staffs.xlsx";

        $result = $this->Import->get_colNames_from_EXCEL_for_jqgrid($filename); 

        $expected = [
            '氏名','フリガナ','生年月日','性別','電話番号','郵便番号','住所','番地','建物名','職種１','職種２','肩書','備考',            
        ];

        $this->assertEquals($expected,$result);

    }

    /**
     * Test create_data_from_file_for_jqgrid method
     *
     * $file_nameのエクセルファイルから、データを取得してjqgrid用配列にして返す
     * @return void
     */
    public function testCreateDataFromFileForJqgrid()
    {
        // text.xlsx data
        // 11	12	13	14
        // 21	22	23	24
        // 31	32	33	34
        $filename = "test.xlsx";
        $path = TESTS . 'Fixture\excel\test.xlsx';
        \copy($path, WWW_ROOT.'files'.DS. $filename);

        list($response,$column) = $this->Import->create_data_from_file_for_jqgrid($filename); 

        $expected_cols = [
            'col1','col2','col3','col4',            
        ];        
        
        $expected = [
            ['id'=>0,'cell'=>['',0,11,12,13,14],],
            ['id'=>1,'cell'=>['',1,21,22,23,24],],
            ['id'=>2,'cell'=>['',2,31,32,33,34],],            
        ];
        $expected_res = (object) $expected;          
        
        $this->assertEquals($expected_cols,$column);
        $this->assertEquals($expected,$response->rows);

        \unlink(WWW_ROOT.'files'.DS. $filename);
    }

    /**
     * Test categorize_importdata method
     *
     * @return void
     */
    public function testCategorizeImportdata()
    {
        // $this->loadFixtures('importdataconversions');

        $columns=['氏名','フリガナ','生年月日','性別','電話番号','郵便番号',];
        $result = $this->Import->categorize_importdata($columns);        
        $this->assertEquals('staffs',$result);
        
        $columns=['取引先名称','フリガナ','郵便番号','住所','番地','建物名','電話番号',];
        $result = $this->Import->categorize_importdata($columns);        
        $this->assertEquals('business_partners',$result);
        
        
        $columns=['受注No','ステータス','description','請負元','派遣先','開始日','終了日','開始時間',];
        $result = $this->Import->categorize_importdata($columns);        
        $this->assertEquals('orders',$result);
    }
}
