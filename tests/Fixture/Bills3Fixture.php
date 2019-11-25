<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillsFixture
 */
class Bills3Fixture extends TestFixture
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
        $today = new \DateTime();
        $early = Clone $today;
        $late = Clone $today;

        $today_date = $today->format("Y-m-d");
        $early_date = $early->modify('-1 month')->format("Y-m-d");
        $late_date = $late->modify('+1 month')->format("Y-m-d");

        $this->records = [
            [
                'id'=>1,
                'bill_no'=>123,
                'business_partner_id'=>1,
                'due_date'=>$early_date,
                'received_date'=>null
        ],            
            [
                'id'=>2,
                'bill_no'=>124,
                'business_partner_id'=>1,
                'due_date'=>$today_date,
                'received_date'=>null
        ],            
            [
                'id'=>3,
                'bill_no'=>125,
                'business_partner_id'=>1,
                'due_date'=>$early_date,
                'received_date'=>$today_date
        ],            
            [
                'id'=>4,
                'bill_no'=>125,
                'business_partner_id'=>1,
                'due_date'=>$late_date,
                'received_date'=>null
        ],            
            [
                'id'=>5,
                'bill_no'=>125,
                'business_partner_id'=>1,
                'due_date'=>$late_date,
                'received_date'=>$late_date
        ],            
        ];


        parent::init();
    }
}
