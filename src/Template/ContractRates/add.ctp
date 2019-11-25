
<section class="content-header">
<h1>
業務契約料金表設定
<small><?php 
    if(!empty($contractRate->business_partner_id)){
        echo $businessPartners[$contractRate->business_partner_id]."の";
    }  ?>
  業務契約料金を設定します</small>
</h1>
</section>
<section class="content voffset4">

    <?php

    echo $this->Form->create($contractRate,[
    'class' => 'form-horizontal'
    ]);
  // テンプレート設定
  $this->Form->templates([
    'label' => '<label class="control-label col-md-6"{{attrs}}>{{text}}</label>',
    'formGroup' => '{{label}}<div class=" col-md-6">{{prepend}}{{input}}{{append}}{{error}}{{help}}</div>',//custom
    'submitContainer' => '<div class="col-md-6 col-md-offset-6">{{content}}</div>',
  ]);
    
    
     ?>
<div class="col-md-12">
    <fieldset>
        <legend><?= __('業務契約料金入力フォーム') ?></legend>
        <?php
            
            if(!empty($contractRate->business_partner_id)){
                $isDisabled = true;
                echo $this->Form->input('business_partner_id', ['type'=> 'hidden']);
            }else{
                $isDisabled = false;
            }
            
            echo $this->Form->input('business_partner_id', 
            ['label'=> '取引先名称','disabled' => $isDisabled, 'options' => $businessPartners, 'empty' => '--']);
        ?>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">胸部</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<div class="clearfix">      
<legend>可搬</legend>
<div class="col-md-6">
    
 <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">間接</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<?php
    echo $this->Form->input('guaranty_charge_chest_i_por',[
    'label'=>"保証料金",'type'=>'number']);
    echo $this->Form->input('guaranty_count_chest_i_por',[
    'label'=>"保証人数" ]);
    echo $this->Form->input('additional_unit_price_chest_i_por',[
    'label'=>"追加料金単価" ]);
    echo $this->Form->input('transportable_equipment_cost_chest_i_por',[
    'label'=>"可搬費" ]);
    echo $this->Form->input('appointed_day_cost_chest_i_por',[
    'label'=>"当日" ]);
?>


  </div><!-- /.box-body -->
  <div class="box-footer">
  </div><!-- box-footer -->
</div><!-- /.box -->   

</div>
<div class="col-md-6">

 <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">デジタル</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<?php
    echo $this->Form->input('guaranty_charge_chest_dg_por',[
    'label'=>"保証料金" ,'type'=>'number']);
    echo $this->Form->input('guaranty_count_chest_dg_por',[
    'label'=>"保証人数" ]);
    echo $this->Form->input('additional_unit_price_chest_dg_por',[
    'label'=>"追加料金単価" ]);
    echo $this->Form->input('transportable_equipment_cost_chest_dg_por',[
    'label'=>"可搬費" ]);
    echo $this->Form->input('appointed_day_cost_chest_dg_por',[
    'label'=>"当日" ]);
?>
  </div><!-- /.box-body -->
  <div class="box-footer">
  </div><!-- box-footer -->
</div><!-- /.box -->   
   
</div>
</div>

<div class="clearfix">
<legend>レントゲン車</legend>

<div class="col-md-6">

 <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">デジタル</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<?php
    echo $this->Form->input('guaranty_charge_chest_dg_car',[
    'label'=>"保証料金" ,'type'=>'number']);
    echo $this->Form->input('guaranty_count_chest_dg_car',[
    'label'=>"保証人数" ]);
    echo $this->Form->input('additional_unit_price_chest_dg_car',[
    'label'=>"追加料金単価" ]);

?>
  </div><!-- /.box-body -->
  <div class="box-footer">
  </div><!-- box-footer -->
</div><!-- /.box -->   
   
</div>
<div class="col-md-6">

 <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">直接</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<?php
    echo $this->Form->input('guaranty_charge_chest_dr_car',[
    'label'=>"保証料金" ,'type'=>'number']);
    echo $this->Form->input('guaranty_count_chest_dr_car',[
    'label'=>"保証人数" ]);
    echo $this->Form->input('additional_unit_price_chest_dr_car',[
    'label'=>"追加料金単価" ]);
?>
  </div><!-- /.box-body -->
  <div class="box-footer">
  </div><!-- box-footer -->
</div><!-- /.box -->   
    
</div></div>

  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->        
 
 <!--  胃部 -->
 <div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">胃部</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<legend>レントゲン車</legend>

<div class="col-md-6">

 <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">間接（８枚）</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<?php
    echo $this->Form->input('guaranty_charge_stom_i_car',[
    'label'=>"保証料金" ,'type'=>'number']);
    echo $this->Form->input('guaranty_count_stom_i_car',[
    'label'=>"保証人数" ]);
    echo $this->Form->input('additional_unit_price_stom_i_car',[
    'label'=>"追加料金単価" ]);
?>
  </div><!-- /.box-body -->
  <div class="box-footer">
  </div><!-- box-footer -->
</div><!-- /.box -->   
   
</div>
<div class="col-md-6">

 <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">直接</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<?php
    echo $this->Form->input('guaranty_charge_stom_dr_car',[
    'label'=>"保証料金" ,'type'=>'number']);
    echo $this->Form->input('guaranty_count_stom_dr_car',[
    'label'=>"保証人数" ]);
    echo $this->Form->input('additional_unit_price_stom_dr_car',[
    'label'=>"追加料金単価" ]);
?>
  </div><!-- /.box-body -->
  <div class="box-footer">
  </div><!-- box-footer -->
</div><!-- /.box -->   
    
</div>



  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->
 
<legend>その他</legend>        
        <?php

    echo $this->Form->input('operating_cost',[
    'label'=>"稼働費" ]);        
        
 
            ?>
    </fieldset>
    <hr />

    <div class="pull-right">
    <?= $this->Form->button(__('これで設定する'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('取引先詳細に戻る'), ['controller'=>'BusinessPartners','action' => 'view',$contractRate->business_partner_id],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
    <?= $this->Form->end() ?>
</div>
</section>
