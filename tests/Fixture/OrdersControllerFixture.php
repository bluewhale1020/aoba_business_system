<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersControllerFixture
 */
class OrdersControllerFixture extends TestFixture
{
    public $table = 'orders';

    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'orders'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $today = new \DateTime();
        $early = Clone $today;        
        $late = Clone $today;

        $today_date = $today->format("Y-m-d");
        $early_date = $early->modify('-1 month')->format("Y-m-d");
        $late_date = $late->modify('+1 month')->format("Y-m-d"); 

        $this->records = [
            [
                'id' => 1,
                'order_no' => 'order1',
                'client_id' => 1,
                'work_place_id' => 3,
                'cancel' => null,
                'temporary_registration' => 0,
                'description' => '片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
                'recipient' => null,
                'payment' => '依頼元',
                'payer_id' => 1,
                'notes' => 'test2',
                'bill_id' => 2,
                'start_date' => '2019-10-07 00:00:00',
                'end_date' => '2019-10-14 00:00:00',
                'start_time' => '2019-11-14 10:00:00',
                'end_time' => '2019-11-14 12:00:00',
                'work_content_id' => 1,
                'capturing_region_id' => 1,
                'film_size_id' => 4,
                'patient_num' => 500,
                'need_image_reading' => 1,
                'service_charge' => null,
                'guaranty_charge' => 500000,
                'guaranty_count' => 100,
                'additional_count' => 6,
                'additional_unit_price' => 150,
                'other_charge' => 0,
                'is_charged' => 1,
                'transportable_equipment_cost' => 35000,
                'transportation_cost' => 20000,
                'travel_cost' => 20000,
                'image_reading_cost' => 7000,
                'labor_cost' => 50000
            ],
            [
                'id' => 2,
                'order_no' => 'order2',
                'client_id' => 1,
                'work_place_id' => 3,
                'cancel' => null,
                'temporary_registration' => 1,
                'description' => '片栗学園　教職員 撮影 胸部 DR',
                'recipient' => null,
                'payment' => '依頼元',
                'payer_id' => 1,
                'notes' => 'test',
                'bill_id' => null,
                'start_date' => '2019-10-07 00:00:00',
                'end_date' => '2019-11-29 00:00:00',
                'start_time' => '2019-11-14 10:00:00',
                'end_time' => '2019-11-14 12:00:00',
                'work_content_id' => 1,
                'capturing_region_id' => 1,
                'film_size_id' => 2,
                'patient_num' => 500,
                'need_image_reading' => 0,
                'service_charge' => null,
                'guaranty_charge' => 2800,
                'guaranty_count' => 120,
                'additional_count' => 20,
                'additional_unit_price' => 3000,
                'other_charge' => 0,
                'is_charged' => 0,
                'transportable_equipment_cost' => 0,
                'transportation_cost' => 0,
                'travel_cost' => 0,
                'image_reading_cost' => 0,
                'labor_cost' => 0
            ],        
            [
                'id'=>3,
                'order_no'=>'order3',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$today_date,
                'end_date'=>$late_date,
                'is_charged'=>0,
            ],        
            [
                'id'=>4,
                'order_no'=>'order4',
                'client_id'=>2,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$late_date,
                'end_date'=>$late_date,
                'is_charged'=>0,
            ],        
            [
                'id'=>5,
                'order_no'=>'order5',
                'client_id'=>3,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$late_date,
                'end_date'=>$late_date,
                'is_charged'=>0,
            ],      
            //以下 works.done = 1  
            [
                'id'=>6,
                'order_no'=>'order6',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$early_date,
                'end_date'=>$late_date,
                'is_charged'=>0,
            ],        
            [
                'id'=>7,
                'order_no'=>'order7',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$early_date,
                'end_date'=>$today_date,
                'is_charged'=>0,
            ],        
            [
                'id'=>8,
                'order_no'=>'order8',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$early_date,
                'end_date'=>$early_date,
                'is_charged'=>1,
            ],

        ];
        parent::init();
    }
}
