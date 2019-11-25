<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentsFixture
 */
class Equipments2Fixture extends TestFixture
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
                'name' => 'car1',
                'equipment_type_id' => 3,
                'number_of_times' => 5,
                'equipment_no' => 11
            ],
            [
                'id' => 2,
                'name' => 'car2',
                'equipment_type_id' => 1,//可搬
                'number_of_times' => 4,
                'equipment_no' => 12
            ],
            [
                'id' => 3,
                'name' => 'car3',
                'equipment_type_id' => 1,//可搬
                'number_of_times' => 3,
                'equipment_no' => 13
            ],
            [
                'id' => 4,
                'name' => 'car4',
                'equipment_type_id' => 2,//Bレ車
                'number_of_times' => 2,
                'equipment_no' => 14
            ],
            [
                'id' => 5,
                'name' => 'car5',
                'equipment_type_id' => 2,//Bレ車
                'number_of_times' => 0,
                'equipment_no' => 15
            ],
        ];
        parent::init();
    }
}
