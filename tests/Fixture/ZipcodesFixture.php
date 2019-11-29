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
                'id' => 1,
                'zipcode' => '0010000',
                'address' => '北海道札幌市北区'
            ],
            [
                'id' => 2,
                'zipcode' => '130021',
                'address' => '墨田区緑'
            ],
        ];
        parent::init();
    }
}
