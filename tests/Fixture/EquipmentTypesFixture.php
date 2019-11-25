<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentTypesFixture
 */
class EquipmentTypesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'equipment_types'];

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
                'name' => '可搬',
                'capturing_region_id' => '1'
            ],
            [
                'id' => 2,
                'name' => 'Bレ車',
                'capturing_region_id' => '1'
            ],
            [
                'id' => 3,
                'name' => 'Mレ車',
                'capturing_region_id' => '2'
            ],
            [
                'id' => 4,
                'name' => 'P',
                'capturing_region_id' => null
            ],
        ];
        parent::init();
    }
}
