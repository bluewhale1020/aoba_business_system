<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contract Rate'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Business Partners'), ['controller' => 'BusinessPartners', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Business Partner'), ['controller' => 'BusinessPartners', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contract Types'), ['controller' => 'ContractTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contract Type'), ['controller' => 'ContractTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractRates index large-9 medium-8 columns content">
    <h3><?= __('Contract Rates') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('business_partner_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_chest_i_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_chest_i_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_chest_i_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transportable_equipment_cost_chest_i_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('appointed_day_cost_chest_i_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_chest_dg_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_chest_dg_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_chest_dg_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transportable_equipment_cost_chest_dg_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('appointed_day_cost_chest_dg_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_chest_dr_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_chest_dr_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_chest_dr_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transportable_equipment_cost_chest_dr_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('appointed_day_cost_chest_dr_por') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_chest_i_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_chest_i_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_chest_i_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_chest_dg_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_chest_dg_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_chest_dg_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_chest_dr_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_chest_dr_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_chest_dr_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_stom_i_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_stom_i_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_stom_i_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_charge_stom_dr_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guaranty_count_stom_dr_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_unit_price_stom_dr_car') ?></th>
                <th scope="col"><?= $this->Paginator->sort('operating_cost') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contractRates as $contractRate): ?>
            <tr>
                <td><?= $this->Number->format($contractRate->id) ?></td>
                <td><?= $contractRate->has('business_partner') ? $this->Html->link($contractRate->business_partner->name, ['controller' => 'BusinessPartners', 'action' => 'view', $contractRate->business_partner->id]) : '' ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_chest_i_por) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_chest_i_por) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_chest_i_por) ?></td>
                <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_i_por) ?></td>
                <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_i_por) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dg_por) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_chest_dg_por) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dg_por) ?></td>
                <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_dg_por) ?></td>
                <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_dg_por) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dr_por) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_chest_dr_por) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dr_por) ?></td>
                <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_dr_por) ?></td>
                <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_dr_por) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_chest_i_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_chest_i_car) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_chest_i_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dg_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_chest_dg_car) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dg_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dr_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_chest_dr_car) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dr_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_stom_i_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_stom_i_car) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_stom_i_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_charge_stom_dr_car) ?></td>
                <td><?= $this->Number->format($contractRate->guaranty_count_stom_dr_car) ?></td>
                <td><?= $this->Number->format($contractRate->additional_unit_price_stom_dr_car) ?></td>
                <td><?= $this->Number->format($contractRate->operating_cost) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contractRate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contractRate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractRate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractRate->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
