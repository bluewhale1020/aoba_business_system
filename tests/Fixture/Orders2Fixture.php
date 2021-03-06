<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class Orders2Fixture extends TestFixture
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

        $this->records = [
        ['id'=>1,
        'order_no'=>'order1',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>1,
        'start_date'=>'2019/9/5',
        'end_date'=>'2019/9/6',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content'=>1,
        'capturing_region'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>2,
        'order_no'=>'order2',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>1,
        'start_date'=>'2019/9/20',
        'end_date'=>'2019/9/25',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content'=>1,
        'capturing_region'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>3,
        'order_no'=>'order3',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>1,
        'start_date'=>'2019/9/25',
        'end_date'=>'2019/10/1',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content'=>1,
        'capturing_region'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>4,
        'order_no'=>'order4',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>2,
        'start_date'=>'2019/10/1',
        'end_date'=>'2019/10/6',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content'=>1,
        'capturing_region'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>5,
        'order_no'=>'order5',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>2,
        'start_date'=>'2019/10/11',
        'end_date'=>'2019/10/20',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content'=>1,
        'capturing_region'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>6,
        'order_no'=>'order6',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>2,
        'start_date'=>'2019/10/21',
        'end_date'=>'2019/10/23',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content'=>1,
        'capturing_region'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>7,
        'order_no'=>'order7',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>	'',
        'start_date'=>'2019/10/25',
        'end_date'=>'2019/10/31',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>8,
        'order_no'=>'order8',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>	'',
        'start_date'=>'2019/11/3',
        'end_date'=>'2019/11/9',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>9,
        'order_no'=>'order9',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>	'',
        'start_date'=>'2019/11/8',
        'end_date'=>'2019/11/15',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>10,
        'order_no'=>'order10',
        'client_id'=>1,
        'work_place_id'=>3,
        'temporary_registration'=>0,
        'description'=>'片栗学園　教職員 撮影 胸部 四つ切 Bレ車',
        'payer_id'=>1,
        'bill_id'=>	'',
        'start_date'=>'2019/11/30',
        'end_date'=>'2019/12/3',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>1,
        'film_size_id'=>4,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>11,
        'order_no'=>'order11',
        'client_id'=>4,
        'work_place_id'=>5,
        'temporary_registration'=>0,
        'description'=>'青葉金融東京営業所 撮影 胃部 DR',
        'payer_id'=>4,
        'bill_id'=>3,
        'start_date'=>'2019/10/5',
        'end_date'=>'2019/10/10',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>2,
        'film_size_id'=>2,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>12,
        'order_no'=>'order12',
        'client_id'=>4,
        'work_place_id'=>5,
        'temporary_registration'=>0,
        'description'=>'青葉金融東京営業所 撮影 胃部 DR',
        'payer_id'=>4,
        'bill_id'=>3,
        'start_date'=>'2019/10/11',
        'end_date'=>'2019/10/20',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>2,
        'film_size_id'=>2,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>1,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>13,
        'order_no'=>'order13',
        'client_id'=>4,
        'work_place_id'=>5,
        'temporary_registration'=>0,
        'description'=>'青葉金融東京営業所 撮影 胃部 DR',
        'payer_id'=>4,
        'bill_id'=>	'',
        'start_date'=>'2019/10/24',
        'end_date'=>'2019/10/31',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>2,
        'film_size_id'=>2,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000 ],
        ['id'=>14,
        'order_no'=>'order14',
        'client_id'=>4,
        'work_place_id'=>5,
        'temporary_registration'=>0,
        'description'=>'青葉金融東京営業所 撮影 胃部 DR',
        'payer_id'=>4,
        'bill_id'=>	'',
        'start_date'=>'2019/11/13',
        'end_date'=>'2019/11/18',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>2,
        'capturing_region_id'=>2,
        'film_size_id'=>2,        
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>15,
        'order_no'=>'order15',
        'client_id'=>4,
        'work_place_id'=>5,
        'temporary_registration'=>0,
        'description'=>'青葉金融東京営業所 撮影 胃部 DR',
        'payer_id'=>4,
        'bill_id'=>	'',
        'start_date'=>'2019/11/16',
        'end_date'=>'2019/11/20',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>2,
        'film_size_id'=>2,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ['id'=>16,
        'order_no'=>'order16',
        'client_id'=>4,
        'work_place_id'=>5,
        'temporary_registration'=>0,
        'description'=>'青葉金融東京営業所 撮影 胃部 DR',
        'payer_id'=>4,
        'bill_id'=>	'',
        'start_date'=>'2019/12/3',
        'end_date'=>'2019/12/13',
        'start_time'=>'8:00:00',
        'end_time'=>'12:00:00',
        'work_content_id'=>1,
        'capturing_region_id'=>2,
        'film_size_id'=>2,
        'patient_num'=>100,
        'guaranty_charge'=>10000,
        'guaranty_count'=>100,
        'additional_count'=>8,
        'additional_unit_price'=>1000,
        'other_charge'=>2000,
        'is_charged'=>0,
        'transportable_equipment_cost'=>1000,
        'transportation_cost'=>1000,
        'travel_cost'=>1000,
        'image_reading_cost'=>1000,
        'labor_cost'=>1000],
        ];

        parent::init();
    }
}
