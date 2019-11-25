<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
],
['block' => 'script']);
?>
<script type="text/javascript">

$(document).ready(function(){  

    // ロケールを設定
    moment.locale('ja');

    var picker_option = {
        format:'YYYY/MM/DD',
        singleDatePicker: true,
        autoUpdateInput:false,
        showDropdowns: true,
               locale: {
         applyLabel: '反映',
         cancelLabel: '取消',
         fromLabel: '開始日',
         toLabel: '終了日',
         weekLabel: 'W',
         
         customRangeLabel: '自分で指定',
         daysOfWeek: moment.weekdaysMin(),
         monthNames: moment.monthsShort(),
         firstDay: moment.localeData()._week.dow
       },
    };

$('#install-date').daterangepicker(picker_option, (start, end, label)=> {
  $("#install-date").val(start.format('YYYY/MM/DD'));
});



  

});    
    
    
</script>
<section class="content-header">
<h1>
登録装置の情報編集
<small>登録済の装置の情報を更新します</small>
</h1>
</section>
<section class="content voffset4">

    <?= $this->Form->create($equipment,[
    'class' => 'form-horizontal'
    ]) ?>
<div class="col-md-10">
    <fieldset>
        <legend><?= __('装置情報編集フォーム') ?></legend>
        <?php
            echo $this->Form->input('equipment_no',[
            'label'=>"装置番号"
            ]);        
            echo $this->Form->input('name',[
            'label'=>"装置名称"
            ]);
            echo $this->Form->input('equipment_type_id', [
            'label' => '装置種類',
            'options' => $equipmentTypes, 'empty' => true]);
            echo $this->Form->input('xray_type_id',[
            'label'=>"撮影種類",
            'empty' => '--',
            'options' =>$xrayTypes
            ]);
            echo $this->Form->input('transportable',[
            'label'=>"可搬性",
            'empty' => '--',
            'options' =>[
            '0' => 'なし',
            '1' => 'あり'
            ]
            ]);
            echo $this->Form->input('number_of_times',[
            'label'=>"使用頻度"
            ]);
            echo $this->Form->input('status_id', [
            'label'=>"状態",
            'empty' => '',            
            'options' => $statuses, 'empty' => '--']);
            echo $this->Form->input('install_date',[
            'type' => 'text',
            'label'=>"使用開始日",
            'append'=>'<i class="fa fa-calendar"></i>'


            ]);             
            echo $this->Form->input('notes',[
            'type' => 'textarea',
            'label'=>"備考"
            ]);
        ?>
    </fieldset>
    <hr />

    <div class="pull-right">
    <?= $this->Form->button(__('情報更新'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('装置一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
    <?= $this->Form->end() ?>
</div>
</section>

