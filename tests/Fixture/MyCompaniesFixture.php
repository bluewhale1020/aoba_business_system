<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MyCompaniesFixture
 */
class MyCompaniesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'my_companies'];

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
                'name' => '青葉レントゲン株式会社',
                'kana' => 'アオバレントゲン',
                'postal_code' => '130-0021',
                'address' => '墨田区緑',
                'banchi' => '4-34-1',
                'tatemono' => '野尻ビル1階',
                'tel' => '03-5600-7101',
                'fax' => '03-5600-1021',
                'email' => 'info@aobax.co.jp',
                'url' => 'http://http://aobax.holy.jp/aobarentogen',
                'notes' => null,
                'owner' => 1,
                'created' => null,
                'modified' => null
            ],
        ];
        parent::init();
    }
}
