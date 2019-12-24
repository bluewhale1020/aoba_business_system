<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersDashFixture
 */
class Orders4Fixture extends TestFixture
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
        $earlier = Clone $today;
        $late = Clone $today;

        $today_date = $today->format("Y-m-d");
        $earlier_date = $earlier->modify('-2 month')->format("Y-m-d");        
        $early_date = $early->modify('-1 month')->format("Y-m-d");        
        $late_date = $late->modify('+1 month')->format("Y-m-d");        

        $this->records = [
            [
                'id'=>1,
                'start_date'=>$earlier_date,
                'end_date'=>$earlier_date,
                'payer_id'=>1,
                'client_id'=>1,
                'work_content_id'=>1,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>	500,
                'travel_cost'=>	2000,
                'image_reading_cost'=>0,
                'labor_cost'=>	2000,
                'film_size_id'=>3,
            ],
            [
                'id'=>	2,
                'start_date'=>$earlier_date,
                'end_date'=>$earlier_date,
                'payer_id'=>2,
                'client_id'=>2,
                'work_content_id'=>2,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>1000,
                'labor_cost'=>2000,
                'film_size_id'=>2,                                
            ],
            [
                'id'=>3,
                'start_date'=>$early_date,
                'end_date'=>$early_date,
                'payer_id'=>3,
                'client_id'=>3,
                'work_content_id'=>1,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>0,
                'labor_cost'=>2000,
                'film_size_id'=>4,
                
            ],
            [
                'id'=>4,
                'start_date'=>$today_date,
                'end_date'=>$today_date,
                'payer_id'=>1,
                'client_id'=>1,
                'work_content_id'=>1,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>0,
                'labor_cost'=>2000,
                'film_size_id'=>1,
                
            ],
            // 以下 work.done = 0
            [
                'id'=>5,
                'start_date'=>$today_date,
                'end_date'=>$today_date,
                'payer_id'=>2,
                'client_id'=>2,
                'work_content_id'=>2,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>1000,
                'labor_cost'=>2000,
                'film_size_id'=>3,
                
            ],
            [
                'id'=>6,
                'start_date'=>$today_date,
                'end_date'=>$today_date,
                'payer_id'=>3,
                'client_id'=>3,
                'work_content_id'=>1,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>1000,
                'labor_cost'=>2000,
                'film_size_id'=>2,
                
            ],
            [
                'id'=>7,
                'start_date'=>$late_date,
                'end_date'=>$late_date,
                'payer_id'=>3,
                'client_id'=>3,
                'work_content_id'=>2,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>0,
                'labor_cost'=>2000,
                'film_size_id'=>1,
                
            ],
            [
                'id'=>8,
                'start_date'=>$late_date,
                'end_date'=>$late_date,
                'payer_id'=>4,
                'client_id'=>4,
                'work_content_id'=>2,
                'guaranty_charge'=>10000,
                'additional_count'=>10,
                'additional_unit_price'=>500,
                'transportable_equipment_cost'=>2000,
                'transportation_cost'=>500,
                'travel_cost'=>2000,
                'image_reading_cost'=>0,
                'labor_cost'=>2000,
                'film_size_id'=>1,
                
            ],
       
        ];

        parent::init();
    }
}
