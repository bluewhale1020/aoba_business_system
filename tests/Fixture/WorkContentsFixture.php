<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WorkContentsFixture
 */
class WorkContentsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'work_contents'];

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
                'description' => '撮影'
            ],
            [
                'id' => 2,
                'description' => '貸出'
            ],
            [
                'id' => 3,
                'description' => '心電図'
            ],
            [
                'id' => 4,
                'description' => '保険面接'
            ],
        ];
        parent::init();
    }
}
