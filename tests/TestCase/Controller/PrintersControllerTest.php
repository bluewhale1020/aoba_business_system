<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PrintersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * App\Controller\PrintersController Test Case
 *
 * @uses \App\Controller\PrintersController
 */
class PrintersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EquipmentRentals',
        'app.MyCompanies',
        'app.Bills',
        'app.BusinessPartners',
        'app.Orders',
        'app.WorkContents',
        'app.Equipments',
        'app.EquipmentTypes',
        'app.CapturingRegions',
        'app.FilmSizes',
        'app.Works',
        'app.EquipmentTypes',
        'app.Users',
        'app.EventLogs',
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
        $this->Orders = TableRegistry::get('Orders');
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orders);

        parent::tearDown();
    }



    /**
     * Test printOpnumTable method
     *
     * @return void
     */
    public function testPrintOpnumTable()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ],
        ]);        
        $filename = 'opnum_table.xlsx';
        $filename = (new \DateTime())->format("Ymd") ."_".$filename;
        $expected = TMP.'excels'. DS . $filename;

        $data = [
            'start_year'=>2019,    
            'start_mon'=>10,    
            'end_year'=>2019,    
            'end_mon'=>12,    
            ];        

        $this->get('/Printers/printOpnumTable', $data);
        $this->assertResponseCode(200);        
 
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_opnum_table');
        $this->assertResponseContains("xml");

    }

    /**
     * Test printBill method
     *
     * @return void
     */
    public function testPrintBill()
    {
        $filename = 'invoice.xlsx';
        $filename = "no_B3333_".$filename;
        $expected = TMP.'excels'. DS . $filename;


        $this->get('/Printers/printBill/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_bill');
        $this->assertResponseContains("xml");
    }

    /**
     * Test printDeliverySlip method
     *
     * @return void
     */
    public function testPrintDeliverySlip()
    {
        $filename = 'delivery_slip.xlsx';
        $filename = "no_B3333_".$filename;
        $expected = TMP.'excels'. DS . $filename;


        $this->get('/Printers/printDeliverySlip/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_delivery_slip');
        $this->assertResponseContains("xml");
    }

    /**
     * Test printLabelSheet method
     *
     * @return void
     */
    public function testPrintLabelSheet()
    {
        $filename = "work_label.docx";
        $expected = TMP.'words'. DS . $filename;


        $this->get('/Printers/printLabelSheet/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_label_sheet');
        $this->assertResponseContains("xml");
        // $this->assertFileResponse($expected ,'雛形ファイルのコピーに失敗しました。');

    }

    /**
     * Test printIrradiationRecord method
     *
     * @return void
     */
    public function testPrintIrradiationRecord()
    {
        $filename = 'no_order1_irradiation record.xlsx';
        $expected = TMP.'excels'. DS . $filename;


        $this->get('/Printers/printIrradiationRecord/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_irradiation_record');
        $this->assertResponseContains("xml");
    }

    /**
     * Test printWorkSheet method
     *
     * @return void
     */
    public function testPrintWorkSheet()
    {
        $filename = 'no_order1_work_sheet.xlsx';
        $expected = TMP.'excels'. DS . $filename;


        $this->get('/Printers/printWorkSheet/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_work_sheet');
        $this->assertResponseContains("xml");

    }

    /**
     * Test printOrderConfirmation method
     *
     * @return void
     */
    public function testPrintOrderConfirmation()
    {
        $filename = 'no_order1_order_confirmation.xlsx';
        $expected = TMP.'excels'. DS . $filename;


        $this->get('/Printers/printOrderConfirmation/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_order_confirmation');
        $this->assertResponseContains("xml");

    }


    /**
     * Test printAccountReceivable method
     *
     * @return void
     */
    public function testPrintAccountReceivable()
    {
        $filename = 'account_receivable.xlsx';
        $filename = (new \DateTime())->format("Ymd") ."_".$filename;
        $expected = TMP.'excels'. DS . $filename;


        $this->get('/Printers/printAccountReceivable/2019/10/1');
        $this->assertNoRedirect();  
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_account_receivable');
        $this->assertResponseContains("xml");
    }

    /**
     * Test printLogData method
     *
     * @return void
     */
    public function testPrintLogData()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
            ],
        ]);        
        $filename = (new \DateTime())->format("y_m_d_") . 'eventlog.csv';
        $expected = TMP.'csvs'. DS . $filename;

        $data = [];        

        $this->post('/Printers/printLogData', $data);
        $this->assertResponseCode(200);        
 
        $this->assertEquals($filename,$this->viewVariable('filename'));         
        $this->assertEquals($expected,$this->viewVariable('path'));         
        $this->assertTemplate('print_log_data');
 
        $this->assertResponseContains("id,created,event,action_type,table_name,record_id,user_id,remote_addr,old_val,new_val");

    }

}
