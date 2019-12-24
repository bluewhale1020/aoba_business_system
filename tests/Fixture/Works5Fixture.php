<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WorksFixture
 */
class Works5Fixture extends TestFixture
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
            ['id'=>1,'order_id'=>1,'done'=>1],
            ['id'=>2,'order_id'=>2,'done'=>1],
            ['id'=>3,'order_id'=>3,'done'=>1],
            ['id'=>4,'order_id'=>4,'done'=>1],
            ['id'=>5,'order_id'=>5,'done'=>0],
            ['id'=>6,'order_id'=>6,'done'=>0],
            ['id'=>7,'order_id'=>7,'done'=>0],
            ['id'=>8,'order_id'=>8,'done'=>0],

        ];


        parent::init();
    }
}
