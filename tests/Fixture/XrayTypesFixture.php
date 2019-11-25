<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * XrayTypesFixture
 */
class XrayTypesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'xray_types'];

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
                'name' => '直接'
            ],
            [
                'id' => 2,
                'name' => '間接'
            ],
            [
                'id' => 3,
                'name' => 'デジタル'
            ],
            [
                'id' => 4,
                'name' => 'デジタル ・直接'
            ],
            [
                'id' => 5,
                'name' => '直接・間接'
            ],
            [
                'id' => 6,
                'name' => 'デジタル・間接'
            ],
        ];
        parent::init();
    }
}
