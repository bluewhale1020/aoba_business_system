<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractRate Entity
 *
 * @property int $id
 * @property int $business_partner_id
 * @property int $guaranty_charge_chest_i_por
 * @property int $guaranty_count_chest_i_por
 * @property int $additional_unit_price_chest_i_por
 * @property int $transportable_equipment_cost_chest_i_por
 * @property int $appointed_day_cost_chest_i_por
 * @property int $guaranty_charge_chest_dg_por
 * @property int $guaranty_count_chest_dg_por
 * @property int $additional_unit_price_chest_dg_por
 * @property int $transportable_equipment_cost_chest_dg_por
 * @property int $appointed_day_cost_chest_dg_por
 * @property int $guaranty_charge_chest_dr_por
 * @property int $guaranty_count_chest_dr_por
 * @property int $additional_unit_price_chest_dr_por
 * @property int $transportable_equipment_cost_chest_dr_por
 * @property int $appointed_day_cost_chest_dr_por
 * @property int $guaranty_charge_chest_i_car
 * @property int $guaranty_count_chest_i_car
 * @property int $additional_unit_price_chest_i_car
 * @property int $guaranty_charge_chest_dg_car
 * @property int $guaranty_count_chest_dg_car
 * @property int $additional_unit_price_chest_dg_car
 * @property int $guaranty_charge_chest_dr_car
 * @property int $guaranty_count_chest_dr_car
 * @property int $additional_unit_price_chest_dr_car
 * @property int $guaranty_charge_stom_i_car
 * @property int $guaranty_count_stom_i_car
 * @property int $additional_unit_price_stom_i_car
 * @property int $guaranty_charge_stom_dr_car
 * @property int $guaranty_count_stom_dr_car
 * @property int $additional_unit_price_stom_dr_car
 * @property int $operating_cost
 *
 * @property \App\Model\Entity\BusinessPartner $business_partner
 */
class ContractRate extends Entity
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
