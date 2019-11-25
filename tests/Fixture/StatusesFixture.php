<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StatusesFixture
 */
class StatusesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'statuses'];

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
                'name' => '稼働中',
                'active' => 2
            ],
            [
                'id' => 2,
                'name' => '故障',
                'active' => 1
            ],
            [
                'id' => 3,
                'name' => '修理中',
                'active' => 1
            ],
            [
                'id' => 4,
                'name' => '除却',
                'active' => 0
            ],
            [
                'id' => 5,
                'name' => '廃棄',
                'active' => 0
            ],
            [
                'id' => 6,
                'name' => '導入予定',
                'active' => 1
            ],
        ];
        parent::init();
    }
}
