<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BusinessPartnersFixture
 */
class BusinessPartners2Fixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'business_partners'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            ['id'=>1,'name'=>'会社１'],
            ['id'=>2,'name'=>'会社２'],
            ['id'=>3,'name'=>'会社３'],
            ['id'=>4,'name'=>'会社４'],
        ];
        parent::init();
    }
}
