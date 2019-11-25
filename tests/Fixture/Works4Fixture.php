<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WorksFixture
 */
class Works4Fixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'works'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            ['id'=>1,
            'order_id'=>4,
            'equipmentA_id' => 1,
            'equipmentB_id' => 2,
            'equipmentC_id' => 3,
            'equipmentD_id' => 4,
            'equipmentE_id' => null,
            ],
        ];


        parent::init();
    }
}
