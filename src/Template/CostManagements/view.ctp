<style>
.cost-number{
    color:#dc590b;
    font-size:large;
    font-weight:bold;
}
</style>
<section class="content-header">
<h1>
費用閲覧
<small>受注業務の費用データを閲覧します</small>
</h1>
</section>
<section class="content voffset4">


<div class="clearfix">
    <h3><a href="<?php 
 if($order->has('client')){
    echo $this->Url->build(['controller'=>'orders', 'action'=>'view',$order->id]);  
 }
 ?>" target="_blank">【<?= $order->order_no ?>】      注文内容</a></h3>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('client_name','請負元',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="client_name"><?php echo $order->client->name; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('work_place_name','派遣先',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="work_place_name"><?php echo $order->work_place->name; ?></span>
</div>         
        
        
    </div>
    
     <div class="col-md-6">
         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('date_range','期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $order->start_date . " ~ " . $order->end_date; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('time_range','時間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="time-range"><?php echo $order->start_time->format("H:i") . " ~ " . $order->end_time->format("H:i"); ?></span>
</div>              
         
     </div>   
</div>
<div class="clearfix">
    <div class="col-md-6">
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">業務内容
        <?php if($order->has('work_content')){
           echo $order->work_content->description; 
        } 
         ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
          </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
   
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('capturing_region','撮影部位',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="capturing_region">
        <?php if($order->has('capturing_region')) echo $order->capturing_region->name; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('need_image_reading','読影',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="need_image_reading">
        <?php 
        if($order->need_image_reading == 1){
            echo "あり";
        }else{
            echo "なし";
        }
         ?></span>
</div>  
</div>       
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('film_size','フィルムサイズ',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="film_size">
        <?php if($order->has('capturing_region')) echo $order->film_size->name; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('patient_num','受診者予定者数',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="patient_num"><?php echo $order->patient_num; ?></span>
</div>
</div>

  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->

<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">通番</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">

    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('start_no','開始No',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="start-no"><?php echo $order->works[0]->start_no; ?></span>
</div>  
<div class="form-group clearfix">
    <?php   echo $this->Form->label('end_no','終了No',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="end-no"><?php echo $order->works[0]->end_no; ?></span>
</div>          

    </div>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('absent_nums','欠番',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="absent-nums"><?php echo $order->works[0]->absent_nums; ?></span>
</div>  
        
       
    </div>
  </div><!-- /.box-body -->
  <div class="box-footer">
 
  </div><!-- box-footer -->
</div><!-- /.box -->

</div><div class="col-md-6">
    
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">日数詳細</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-condensed vertical-table table-bordered">
        <tr>
            <th scope="row"><?= __('健診期間') ?></th>
            <td><?= $this->Number->format($num_o_days + $holidayCount) ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('実働日数') ?></th>
            <td id="num_o_days"><?= $this->Number->format($num_o_days) ?></td>
        </tr>       
        <tr>
            <th scope="row"><?= __('休診日数') ?></th>
            <td id="holidayCount"><?= $this->Number->format($holidayCount) ?></td>
        </tr>       
              
</table>


  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box --> 
    
</div>
</div>


<hr />

<div class="clearfix costs  bg-warning">
    <div class="col-md-12">
<h3>費用</h3>
<?php
    $fmt_option = ['after' => ' 円'];
?>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('transportable_equipment_cost','可搬特別費',['class'=>'col-md-4']); ?>
    <span class="col-md-8 formData cost-number" id="transportable-equipment-cost"><?php echo $this->Number->format($order->transportable_equipment_cost,$fmt_option); ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('transportation_cost','出張費',['class'=>'col-md-4']); ?>
    <span class="col-md-8 formData cost-number" id="transportation-cost"><?php echo $this->Number->format($order->transportation_cost,$fmt_option); ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('image_reading_cost','読影費',['class'=>'col-md-4']); ?>
    <span class="col-md-8 formData cost-number" id="image-reading-cost"><?php echo $this->Number->format($order->image_reading_cost,$fmt_option); ?></span>
</div>         
                
    </div>
    
     <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('travel_cost','交通費',['class'=>'col-md-4']); ?>
    <span class="col-md-8 formData cost-number" id="travel-cost"><?php echo $this->Number->format($order->travel_cost,$fmt_option); ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('labor_cost','人件費',['class'=>'col-md-4']); ?>
    <span class="col-md-8 formData cost-number" id="labor-cost"><?php echo $this->Number->format($order->labor_cost,$fmt_option); ?></span>
</div>          

     </div>  
     </div> 
</div>

<hr />

<div class="clearfix">
    <div class="col-md-6">
</div><div class="col-md-6 text-center bg-warning"> 
   <div class="form-group clearfix voffset3">
    <?php   echo $this->Form->label('totalcost','費用合計',['class'=>'col-md-4']); ?>
    <span class="col-md-8 formData cost-number" id="total">
        <?php 
            $totalcost = $order->transportable_equipment_cost + $order->image_reading_cost +
            $order->transportation_cost + $order->travel_cost + $order->labor_cost;        
        echo $this->Number->format($totalcost,$fmt_option); ?></span>
</div> 
            
</div>
</div>

<div class="clearfix  well bg-gray voffset4">
    <div class="text-center">
<?= $this->Html->link(__('編集する'), ['action' => 'edit',$order->id],
    ['class' => 'btn btn-success  glyphicon glyphicon-table']) ?> 
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('作業一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
</div>    
    <?= $this->Form->end() ?>


    <div class="clearfix">
    <a href="<?php 
    echo $this->Url->build(['controller'=>'orders', 'action'=>'view',$order->id]);  
 ?>" 
 class="btn btn-app bg-blue" >    
 
<i class="fa fa-phone"></i>
注文ページへ
</a>
<a href="<?php 
 if($order->has('works')){
    echo $this->Url->build(['controller'=>'works', 'action'=>'view',$order->works[0]->id]);  
 }
 ?>" 
 class="btn btn-app bg-olive" >    
 
<i class="fa fa-briefcase"></i>
作業ページへ
</a>
</div>

</section>




