<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $order->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bills'), ['controller' => 'Bills', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bill'), ['controller' => 'Bills', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Work Contents'), ['controller' => 'WorkContents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Work Content'), ['controller' => 'WorkContents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Capturing Regions'), ['controller' => 'CapturingRegions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Capturing Region'), ['controller' => 'CapturingRegions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Radiography Types'), ['controller' => 'RadiographyTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Radiography Type'), ['controller' => 'RadiographyTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Works'), ['controller' => 'Works', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Work'), ['controller' => 'Works', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orders form large-9 medium-8 columns content">
    <?= $this->Form->create($order) ?>
    <fieldset>
        <legend><?= __('Edit Order') ?></legend>
        <?php
            echo $this->Form->input('client_id');
            echo $this->Form->input('work_place_id');
            echo $this->Form->input('cancel');
            echo $this->Form->input('temporary_registration');
            echo $this->Form->input('notes');
            echo $this->Form->input('bill_id', ['options' => $bills, 'empty' => true]);
            echo $this->Form->input('start_date', ['empty' => true]);
            echo $this->Form->input('end_date', ['empty' => true]);
            echo $this->Form->input('start_time', ['empty' => true]);
            echo $this->Form->input('end_time', ['empty' => true]);
            echo $this->Form->input('work_content_id', ['options' => $workContents, 'empty' => true]);
            echo $this->Form->input('capturing_region_id', ['options' => $capturingRegions, 'empty' => true]);
            echo $this->Form->input('radiography_type_id', ['options' => $radiographyTypes, 'empty' => true]);
            echo $this->Form->input('patient_num');
            echo $this->Form->input('need_image_reading');
            echo $this->Form->input('service_charge');
            echo $this->Form->input('guaranty_charge');
            echo $this->Form->input('guaranty_count');
            echo $this->Form->input('additional_count');
            echo $this->Form->input('additional_unit_price');
            echo $this->Form->input('other_charge');
            echo $this->Form->input('is_charged');
            echo $this->Form->input('transportable_equipment_cost');
            echo $this->Form->input('travel_cost');
            echo $this->Form->input('image_reading_cost');
            echo $this->Form->input('labor_cost');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
