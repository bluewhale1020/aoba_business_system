<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BusinessPartnersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BusinessPartnersTable Test Case
 */
class BusinessPartnersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BusinessPartnersTable
     */
    public $BusinessPartners;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.business_partners',
        // 'app.bills',
        // 'app.orders',
        // 'app.contract_rates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BusinessPartners') ? [] : ['className' => 'App\Model\Table\BusinessPartnersTable'];
        $this->BusinessPartners = TableRegistry::get('BusinessPartners', $config);
    }


    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        // エラーが無いとき
        $bpartner = $this->BusinessPartners->newEntity([
            'name' => str_repeat('a', 10),
            'specific_holidays' => '2019/10/01,2019/10/02,2019/10/03',
        ]);
        $expected = [];
        $this->assertEquals($expected, $bpartner->getErrors());

        // 
        $bpartner = $this->BusinessPartners->newEntity([
            'name' => str_repeat('a', 10),
            'specific_holidays' => 'wefaf23,2019/10/02,2019/10/03',
        ]);
        $expected = [
            'specific_holidays' => ['myRule' => '適切な年月書式ではありません。'],            
        ];
        $this->assertEquals($expected, $bpartner->getErrors());

        // エラーが無いとき
        $bpartner = $this->BusinessPartners->newEntity([
            'name' => str_repeat('a', 10),
            'specific_holidays' => '2019-10-01,2019/10/02,2019-10-03',
        ]);
        $expected = [];
        $this->assertEquals($expected, $bpartner->getErrors());
    }    

    /**
     * Test sortOptions method
     *
     * @return void
     */
    public function testSortOptions()
    {
        $reflection = new \ReflectionClass($this->BusinessPartners);
        $method = $reflection->getMethod('sortOptions');
        $method->setAccessible(true);

        $data =[
            ['id'=>1,'parent_id'=>10 ,'data'=>'aefawf'],
            ['id'=>2,'parent_id'=>10 ,'data'=>'aefawf'],
            ['id'=>3,'parent_id'=>null ,'data'=>'aefawf'],
            ['id'=>4,'parent_id'=>20 ,'data'=>'aefawf'],

        ];

        $result = $method->invoke($this->BusinessPartners,$data);

        $expected = [
            10=>[
                ['id'=>1,'parent_id'=>10 ,'data'=>'aefawf'],
                ['id'=>2,'parent_id'=>10 ,'data'=>'aefawf'],
            ],
            3=>[['id'=>3,'parent_id'=>null ,'data'=>'aefawf']],
            20=>[['id'=>4,'parent_id'=>20 ,'data'=>'aefawf']]
        ];
        $this->assertEquals($expected, $result);
    }


    /**
     * Test import_check_holidays method
     *
     * @return void
     */    
    public function testImportCheckHolidays(){
        $rowdata = [
            '定休日'=>'日,月,火,水、木、金、土'
        ];
        $result = $this->BusinessPartners->import_check_holidays($rowdata);

        $expected = ['定休日'=>'0,1,2,3,4,5,6'];
        $this->assertEquals($expected,$result);

        $rowdata = [
            '定休日'=>'日,火,木、土'
        ];
        $result = $this->BusinessPartners->import_check_holidays($rowdata);

        $expected = ['定休日'=>'0,2,4,6'];
        $this->assertEquals($expected,$result);

        $rowdata = [
            '定休日'=>'月,水、金'
        ];
        $result = $this->BusinessPartners->import_check_holidays($rowdata);

        $expected = ['定休日'=>'1,3,5'];
        $this->assertEquals($expected,$result);


    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BusinessPartners);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        // $this->markTestIncomplete('Not implemented yet.');
    }


}
