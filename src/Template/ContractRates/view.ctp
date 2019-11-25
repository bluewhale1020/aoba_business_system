<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contract Rate'), ['action' => 'edit', $contractRate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contract Rate'), ['action' => 'delete', $contractRate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractRate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contract Rates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contract Rate'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Business Partners'), ['controller' => 'BusinessPartners', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Business Partner'), ['controller' => 'BusinessPartners', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contract Types'), ['controller' => 'ContractTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contract Type'), ['controller' => 'ContractTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contractRates view large-9 medium-8 columns content">
    <h3><?= h($contractRate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Business Partner') ?></th>
            <td><?= $contractRate->has('business_partner') ? $this->Html->link($contractRate->business_partner->name, ['controller' => 'BusinessPartners', 'action' => 'view', $contractRate->business_partner->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractRate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Chest I Por') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Chest I Por') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Chest I Por') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transportable Equipment Cost Chest I Por') ?></th>
            <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Appointed Day Cost Chest I Por') ?></th>
            <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Chest Dg Por') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Chest Dg Por') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Chest Dg Por') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transportable Equipment Cost Chest Dg Por') ?></th>
            <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Appointed Day Cost Chest Dg Por') ?></th>
            <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Chest Dr Por') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dr_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Chest Dr Por') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_dr_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Chest Dr Por') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dr_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transportable Equipment Cost Chest Dr Por') ?></th>
            <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_dr_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Appointed Day Cost Chest Dr Por') ?></th>
            <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_dr_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Chest I Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Chest I Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Chest I Car') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Chest Dg Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dg_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Chest Dg Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_dg_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Chest Dg Car') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dg_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Chest Dr Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Chest Dr Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Chest Dr Car') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Stom I Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_stom_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Stom I Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_stom_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Stom I Car') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_stom_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Charge Stom Dr Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_stom_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guaranty Count Stom Dr Car') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_stom_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Additional Unit Price Stom Dr Car') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_stom_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Operating Cost') ?></th>
            <td><?= $this->Number->format($contractRate->operating_cost) ?></td>
        </tr>
    </table>
</div>
