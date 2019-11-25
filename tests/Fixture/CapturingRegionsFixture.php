<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CapturingRegionsFixture
 */
class CapturingRegionsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'capturing_regions'];

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
                'name' => '胸部'
            ],
            [
                'id' => 2,
                'name' => '胃部'
            ],
            [
                'id' => 3,
                'name' => '乳房'
            ],
        ];
        parent::init();
    }
}
