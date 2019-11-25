<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentRentalsFixture
 */
class EquipmentRentalsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'equipment_rentals'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 5,
                'work_id' => 1,
                'start_date' => '2019-10-07 00:00:00',
                'end_date' => '2019-10-09 00:00:00',
                'equipment_id' => 5
            ],
            [
                'id' => 6,
                'work_id' => 1,
                'start_date' => '2019-10-09 00:00:00',
                'end_date' => '2019-10-11 00:00:00',
                'equipment_id' => 6
            ],
            [
                'id' => 7,
                'work_id' => 2,
                'start_date' => '2019-11-13 00:00:00',
                'end_date' => '2019-11-28 00:00:00',
                'equipment_id' => 1
            ],
            [
                'id' => 8,
                'work_id' => 4,
                'start_date' => '2019-10-20 00:00:00',
                'end_date' => '2019-10-31 00:00:00',
                'equipment_id' => 3
            ],
            [
                'id' => 9,
                'work_id' => 4,
                'start_date' => '2019-10-20 00:00:00',
                'end_date' => '2019-10-31 00:00:00',
                'equipment_id' => 4
            ],
            [
                'id' => 12,
                'work_id' => 5,
                'start_date' => '2019-11-01 00:00:00',
                'end_date' => '2019-11-08 00:00:00',
                'equipment_id' => 1
            ],
            [
                'id' => 13,
                'work_id' => 5,
                'start_date' => '2019-11-04 00:00:00',
                'end_date' => '2019-11-07 00:00:00',
                'equipment_id' => 5
            ],
            [
                'id' => 14,
                'work_id' => 5,
                'start_date' => '2019-11-06 00:00:00',
                'end_date' => '2019-11-08 00:00:00',
                'equipment_id' => 6
            ],
            [
                'id' => 15,
                'work_id' => 6,
                'start_date' => '2019-11-05 00:00:00',
                'end_date' => '2019-11-08 00:00:00',
                'equipment_id' => 7
            ],
            [
                'id' => 16,
                'work_id' => 7,
                'start_date' => '2019-11-10 00:00:00',
                'end_date' => '2019-11-12 00:00:00',
                'equipment_id' => 10
            ],
            [
                'id' => 17,
                'work_id' => 7,
                'start_date' => '2019-11-12 00:00:00',
                'end_date' => '2019-11-13 00:00:00',
                'equipment_id' => 11
            ],
            [
                'id' => 19,
                'work_id' => 9,
                'start_date' => '2019-11-20 00:00:00',
                'end_date' => '2019-11-23 00:00:00',
                'equipment_id' => 9
            ],
            [
                'id' => 20,
                'work_id' => 10,
                'start_date' => '2019-11-25 00:00:00',
                'end_date' => '2019-11-28 00:00:00',
                'equipment_id' => 7
            ],
            [
                'id' => 22,
                'work_id' => 8,
                'start_date' => '2019-11-15 00:00:00',
                'end_date' => '2019-11-18 00:00:00',
                'equipment_id' => 12
            ],
            [
                'id' => 23,
                'work_id' => 12,
                'start_date' => '2019-12-05 00:00:00',
                'end_date' => '2019-12-08 00:00:00',
                'equipment_id' => 1
            ],
            [
                'id' => 24,
                'work_id' => 11,
                'start_date' => '2019-11-30 00:00:00',
                'end_date' => '2019-12-02 00:00:00',
                'equipment_id' => 10
            ],
            [
                'id' => 25,
                'work_id' => 11,
                'start_date' => '2019-12-02 00:00:00',
                'end_date' => '2019-12-03 00:00:00',
                'equipment_id' => 11
            ],
            [
                'id' => 26,
                'work_id' => 11,
                'start_date' => '2019-12-03 00:00:00',
                'end_date' => '2019-12-03 00:00:00',
                'equipment_id' => 8
            ],
            [
                'id' => 27,
                'work_id' => 1,
                'start_date' => '2019-10-11 00:00:00',
                'end_date' => '2019-10-14 00:00:00',
                'equipment_id' => 8
            ],
            [
                'id' => 28,
                'work_id' => 16,
                'start_date' => '2019-11-25 00:00:00',
                'end_date' => '2019-11-28 00:00:00',
                'equipment_id' => 10
            ],
            [
                'id' => 29,
                'work_id' => 16,
                'start_date' => '2019-11-27 00:00:00',
                'end_date' => '2019-11-28 00:00:00',
                'equipment_id' => 11
            ],
        ];
        parent::init();
    }
}
