<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TitlesFixture
 */
class TitlesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'titles'];

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
                'name' => '社長'
            ],
            [
                'id' => 2,
                'name' => '専務'
            ],
            [
                'id' => 3,
                'name' => '正規社員'
            ],
            [
                'id' => 4,
                'name' => 'バイト'
            ],
            [
                'id' => 5,
                'name' => '派遣'
            ],
        ];
        parent::init();
    }
}
