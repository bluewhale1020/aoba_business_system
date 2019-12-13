<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventLogsFixture
 */
class EventLogs2Fixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'event_logs'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $today = new \DateTime();
        $early = Clone $today;

        $today_date = $today->format("Y-m-d");
        $early_date = $early->modify('-2 month')->format("Y-m-d");      

        $this->records = [
            [
                'id' => 1,
                'created' => $today_date,
            ],
            [
                'id' => 2,
                'created' => $early_date,
            ],
            [
                'id' => 3,
                'created' => $early_date,
            ],
            [
                'id' => 4,
                'created' => $today_date,
            ],

        ];
        parent::init();
    }
}
