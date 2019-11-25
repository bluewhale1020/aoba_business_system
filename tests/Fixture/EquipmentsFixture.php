<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentsFixture
 */
class EquipmentsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'equipments'];

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
                'name' => 'テスト装置',
                'equipment_type_id' => 3,
                'xray_type_id' => 2,
                'transportable' => 0,
                'number_of_times' => 50,
                'status_id' => 1,
                'notes' => 'ｋぽｋ',
                'install_date' => '2016-10-13 00:00:00',
                'equipment_no' => 5
            ],
            [
                'id' => 3,
                'name' => 'テスト2号',
                'equipment_type_id' => 1,
                'xray_type_id' => 2,
                'transportable' => 1,
                'number_of_times' => 1,
                'status_id' => 6,
                'notes' => '444',
                'install_date' => null,
                'equipment_no' => 11
            ],
            [
                'id' => 4,
                'name' => '可搬',
                'equipment_type_id' => 1,
                'xray_type_id' => 1,
                'transportable' => 1,
                'number_of_times' => 0,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-15 00:00:00',
                'equipment_no' => 6
            ],
            [
                'id' => 5,
                'name' => '胸部車',
                'equipment_type_id' => 2,
                'xray_type_id' => 1,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-14 00:00:00',
                'equipment_no' => 7
            ],
            [
                'id' => 6,
                'name' => '胃部',
                'equipment_type_id' => 2,
                'xray_type_id' => 2,
                'transportable' => 0,
                'number_of_times' => 11,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2016-10-13 00:00:00',
                'equipment_no' => 8
            ],
            [
                'id' => 7,
                'name' => '胃部2',
                'equipment_type_id' => 3,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => null,
                'install_date' => '2019-11-01 00:00:00',
                'equipment_no' => 9
            ],
            [
                'id' => 8,
                'name' => '胸部車1',
                'equipment_type_id' => 2,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 2,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-11-01 00:00:00',
                'equipment_no' => 13
            ],
            [
                'id' => 9,
                'name' => '胸部車２',
                'equipment_type_id' => 2,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-15 00:00:00',
                'equipment_no' => 14
            ],
            [
                'id' => 10,
                'name' => '可搬３',
                'equipment_type_id' => 1,
                'xray_type_id' => 4,
                'transportable' => 1,
                'number_of_times' => 2,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-07 00:00:00',
                'equipment_no' => 2
            ],
            [
                'id' => 11,
                'name' => '可搬４',
                'equipment_type_id' => 1,
                'xray_type_id' => 4,
                'transportable' => 1,
                'number_of_times' => 2,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2016-10-13 00:00:00',
                'equipment_no' => 3
            ],
            [
                'id' => 12,
                'name' => '胃部車３',
                'equipment_type_id' => 3,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-14 00:00:00',
                'equipment_no' => 16
            ],
            [
                'id' => 13,
                'name' => '胃部車4',
                'equipment_type_id' => 3,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-14 00:00:00',
                'equipment_no' => 17
            ],
            [
                'id' => 14,
                'name' => '胃部車5',
                'equipment_type_id' => 3,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-14 00:00:00',
                'equipment_no' => 18
            ],
            [
                'id' => 15,
                'name' => '胃部車6',
                'equipment_type_id' => 3,
                'xray_type_id' => 4,
                'transportable' => 0,
                'number_of_times' => 1,
                'status_id' => 1,
                'notes' => '',
                'install_date' => '2019-10-14 00:00:00',
                'equipment_no' => 19
            ],
        ];
        parent::init();
    }
}
