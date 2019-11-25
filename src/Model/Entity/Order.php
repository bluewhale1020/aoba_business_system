<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $work_place_id
 * @property int $cancel
 * @property int $temporary_registration
 * @property string $notes
 * @property int $bill_id
 * @property \Cake\I18n\Time $start_date
 * @property \Cake\I18n\Time $end_date
 * @property \Cake\I18n\Time $start_time
 * @property \Cake\I18n\Time $end_time
 * @property int $work_content_id
 * @property int $capturing_region_id
 * @property int $radiography_type_id
 * @property int $patient_num
 * @property int $need_image_reading
 * @property int $service_charge
 * @property int $guaranty_charge
 * @property int $guaranty_count
 * @property int $additional_count
 * @property int $additional_unit_price
 * @property int $other_charge
 * @property int $is_charged
 * @property int $transportable_equipment_cost
 * @property int $travel_cost
 * @property int $image_reading_cost
 * @property int $labor_cost
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\WorkPlace $work_place
 * @property \App\Model\Entity\Bill $bill
 * @property \App\Model\Entity\WorkContent $work_content
 * @property \App\Model\Entity\CapturingRegion $capturing_region
 * @property \App\Model\Entity\Work[] $works
 */
class Order extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
