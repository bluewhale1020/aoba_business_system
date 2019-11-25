<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OccupationsFixture
 */
class OccupationsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'occupations'];

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
                'name' => '医師'
            ],
            [
                'id' => 2,
                'name' => '放射線技師'
            ],
            [
                'id' => 3,
                'name' => '看護師'
            ],
            [
                'id' => 4,
                'name' => '臨床検査技師'
            ],
            [
                'id' => 5,
                'name' => '一般'
            ],
        ];
        parent::init();
    }
}
