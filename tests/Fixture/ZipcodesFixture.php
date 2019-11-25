<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ZipcodesFixture
 */
class ZipcodesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'zipcodes'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1000000,
                'zipcode' => '0010000',
                'address' => '北海道札幌市北区'
            ],
        ];
        parent::init();
    }
}
