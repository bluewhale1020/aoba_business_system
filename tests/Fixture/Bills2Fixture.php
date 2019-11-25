<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillsFixture
 */
class Bills2Fixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'bills'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            ['id'=>1,
            'total_charge'=>66000,
            'received_date'=>'2019-10-25',
            'bill_sent_date'=>'2019-10-10'],
            ['id'=>2,
            'total_charge'=>88000,
            'received_date'=>'2019-11-07',
            'bill_sent_date'=>'2019-10-25'],
            ['id'=>3,
            'total_charge'=>22000,
            'received_date'=>'',
            'bill_sent_date'=>'2019-11-15'],            
        ];


        parent::init();
    }
}
