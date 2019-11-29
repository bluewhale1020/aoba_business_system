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
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test printBill method
     *
     * @return void
     */
    public function testPrintBill()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test printDeliverySlip method
     *
     * @return void
     */
    public function testPrintDeliverySlip()
    {
        $this->markTestIncomplete('Not implemented yet.');
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
        $filename = 'noorder1_irradiation record.xlsx';
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
        $filename = 'noorder1_work_sheet.xlsx';
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
        $filename = 'noorder1_order_confirmation.xlsx';
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
}
