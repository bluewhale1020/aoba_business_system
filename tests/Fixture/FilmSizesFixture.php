<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilmSizesFixture
 */
class FilmSizesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'film_sizes'];

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
                'name' => '100mm'
            ],
            [
                'id' => 2,
                'name' => 'DR'
            ],
            [
                'id' => 3,
                'name' => '大角'
            ],
            [
                'id' => 4,
                'name' => '四つ切'
            ],
        ];
        parent::init();
    }
}
