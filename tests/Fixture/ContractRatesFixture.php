<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContractRatesFixture
 */
class ContractRatesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'contract_rates'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 2,
                'business_partner_id' => 7,
                'guaranty_charge_chest_i_por' => 1500,
                'guaranty_count_chest_i_por' => 50,
                'additional_unit_price_chest_i_por' => 2000,
                'transportable_equipment_cost_chest_i_por' => 20000,
                'appointed_day_cost_chest_i_por' => 8000,
                'guaranty_charge_chest_dg_por' => 1800,
                'guaranty_count_chest_dg_por' => 80,
                'additional_unit_price_chest_dg_por' => 2500,
                'transportable_equipment_cost_chest_dg_por' => 30000,
                'appointed_day_cost_chest_dg_por' => 10000,
                'guaranty_charge_chest_dr_por' => null,
                'guaranty_count_chest_dr_por' => null,
                'additional_unit_price_chest_dr_por' => null,
                'transportable_equipment_cost_chest_dr_por' => null,
                'appointed_day_cost_chest_dr_por' => null,
                'guaranty_charge_chest_i_car' => null,
                'guaranty_count_chest_i_car' => null,
                'additional_unit_price_chest_i_car' => null,
                'guaranty_charge_chest_dg_car' => 1800,
                'guaranty_count_chest_dg_car' => 80,
                'additional_unit_price_chest_dg_car' => 2500,
                'guaranty_charge_chest_dr_car' => 1600,
                'guaranty_count_chest_dr_car' => 70,
                'additional_unit_price_chest_dr_car' => 2000,
                'guaranty_charge_stom_i_car' => 2300,
                'guaranty_count_stom_i_car' => 100,
                'additional_unit_price_stom_i_car' => 2500,
                'guaranty_charge_stom_dr_car' => 2800,
                'guaranty_count_stom_dr_car' => 120,
                'additional_unit_price_stom_dr_car' => 3000,
                'operating_cost' => 15000
            ],
            [
                'id' => 3,
                'business_partner_id' => 1,
                'guaranty_charge_chest_i_por' => 3000,
                'guaranty_count_chest_i_por' => 100,
                'additional_unit_price_chest_i_por' => 1500,
                'transportable_equipment_cost_chest_i_por' => 2000,
                'appointed_day_cost_chest_i_por' => 800,
                'guaranty_charge_chest_dg_por' => 3500,
                'guaranty_count_chest_dg_por' => 150,
                'additional_unit_price_chest_dg_por' => 2000,
                'transportable_equipment_cost_chest_dg_por' => 2500,
                'appointed_day_cost_chest_dg_por' => 1300,
                'guaranty_charge_chest_dr_por' => null,
                'guaranty_count_chest_dr_por' => null,
                'additional_unit_price_chest_dr_por' => null,
                'transportable_equipment_cost_chest_dr_por' => null,
                'appointed_day_cost_chest_dr_por' => null,
                'guaranty_charge_chest_i_car' => null,
                'guaranty_count_chest_i_car' => null,
                'additional_unit_price_chest_i_car' => null,
                'guaranty_charge_chest_dg_car' => 2500,
                'guaranty_count_chest_dg_car' => 50,
                'additional_unit_price_chest_dg_car' => 1000,
                'guaranty_charge_chest_dr_car' => 2000,
                'guaranty_count_chest_dr_car' => 30,
                'additional_unit_price_chest_dr_car' => 500,
                'guaranty_charge_stom_i_car' => 1800,
                'guaranty_count_stom_i_car' => 75,
                'additional_unit_price_stom_i_car' => 1250,
                'guaranty_charge_stom_dr_car' => 2200,
                'guaranty_count_stom_dr_car' => 120,
                'additional_unit_price_stom_dr_car' => 2300,
                'operating_cost' => 10000
            ],
        ];
        parent::init();
    }
}
