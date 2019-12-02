<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillsFixture
 */
class BillsFixture extends TestFixture
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
            [
                'id' => 1,
                'bill_no' => 'B3333',
                'due_date' => '2019-12-31 00:00:00',
                'bill_sent_date' => '2019-11-12 00:00:00',
                'is_sent' => null,
                'business_partner_id' => 6,
                'total_value' => 150000,
                'consumption_tax' => 15000,
                'total_charge' => 165000,
                'received_date' => '2019-11-12 00:00:00',
                'uncollectible' => null,
                'notes' => ''
            ],
            [
                'id' => 2,
                'bill_no' => 'A1235',
                'due_date' => '2019-11-30 00:00:00',
                'bill_sent_date' => '2019-11-13 00:00:00',
                'is_sent' => null,
                'business_partner_id' => 1,
                'total_value' => 500900,
                'consumption_tax' => 50090,
                'total_charge' => 550990,
                'received_date' => null,
                'uncollectible' => null,
                'notes' => ''
            ],
            [
                'id' => 3,
                'bill_no' => 'A1255',
                'due_date' => '2019-12-31 00:00:00',
                'bill_sent_date' => '2019-11-13 00:00:00',
                'is_sent' => null,
                'business_partner_id' => 9,
                'total_value' => 490000,
                'consumption_tax' => 49000,
                'total_charge' => 539000,
                'received_date' => '2019-11-28 00:00:00',
                'uncollectible' => null,
                'notes' => ''
            ],
            [
                'id' => 4,
                'bill_no' => 'A1266',
                'due_date' => '2019-12-31 00:00:00',
                'bill_sent_date' => '2019-12-05 00:00:00',
                'is_sent' => null,
                'business_partner_id' => 11,
                'total_value' => 200000,
                'consumption_tax' => 20000,
                'total_charge' => 220000,
                'received_date' => null,
                'uncollectible' => null,
                'notes' => ''
            ],
            [
                'id' => 5,
                'bill_no' => 'A2323',
                'due_date' => '2019-12-31 00:00:00',
                'bill_sent_date' => '2019-11-05 00:00:00',
                'is_sent' => null,
                'business_partner_id' => 1,
                'total_value' => 200000,
                'consumption_tax' => 20000,
                'total_charge' => 220000,
                'received_date' => null,
                'uncollectible' => null,
                'notes' => ''
            ],
        ];
        parent::init();
    }
}
