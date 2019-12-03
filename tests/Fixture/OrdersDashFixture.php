<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersDashFixture
 */
class OrdersDashFixture extends TestFixture
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
                'id'=>1,
                'order_no'=>'order1',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>1,
                'start_date'=>$late_date,
                'end_date'=>$late_date,
                'is_charged'=>0, 
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,                             
            ],        
            [
                'id'=>2,
                'order_no'=>'order2',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>1,
                'start_date'=>$today_date,
                'end_date'=>$today_date, 
                'is_charged'=>0,
                'guaranty_charge'=>10000,   
                'transportation_cost'=>1000,                              
            ],        
            [
                'id'=>3,
                'order_no'=>'order3',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>1,
                'payer_id'=>1,
                'start_date'=>$today_date,
                'end_date'=>$late_date,
                'is_charged'=>0,
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
            ],        
            [
                'id'=>4,
                'order_no'=>'order4',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$early_date,
                'end_date'=>$early_date,
                'is_charged'=>0,
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
            ],        
            [
                'id'=>5,
                'order_no'=>'order5',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$early_date,
                'end_date'=>$today_date,
                'is_charged'=>0,
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
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
                'end_date'=>$early_date,
                'is_charged'=>0,
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
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
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
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
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
            ],        
            [
                'id'=>9,
                'order_no'=>'order9',
                'client_id'=>1,
                'work_place_id'=>3,
                'temporary_registration'=>0,
                'payer_id'=>1,
                'start_date'=>$early_date,
                'end_date'=>$today_date,
                'is_charged'=>1,
                'guaranty_charge'=>10000,  
                'transportation_cost'=>1000,
            ],        
       
        ];

        parent::init();
    }
}
