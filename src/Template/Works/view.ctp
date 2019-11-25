<section class="content-header">
<h1>
作業内容の閲覧
<small>作業内容の詳細を表示します</small>
</h1>
</section>
<section class="content voffset4">


<div class="clearfix">
    <h3><a href="<?php 
 if($work->order->has('client')){
    echo $this->Url->build(['controller'=>'orders', 'action'=>'view',$work->order->id]);  
 }
 ?>" target="_blank">【<?= $work->order->order_no ?>】      注文内容</a></h3>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('client_name','請負元',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="client_name"><?php echo $work->order->client->name; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('work_place_name','派遣先',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="work_place_name"><?php echo $work->order->work_place->name; ?></span>
</div>         
        
        
    </div>
    
     <div class="col-md-6">
         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('date_range','期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $work->order->start_date . " ~ " . $work->order->end_date; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('time_range','時間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="time-range"><?php
    if(!empty($work->order->start_time) and !empty($work->order->end_time)){
     echo $work->order->start_time->format("H:i") . " ~ " . $work->order->end_time->format("H:i");}
     ?></span>
</div>              
         
     </div>   
</div>
<div class="clearfix">
    <div class="col-md-6">
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">業務内容
        <?php if($work->order->has('work_content')){
           echo $work->order->work_content->description; 
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
        <?php if($work->order->has('capturing_region')) echo $work->order->capturing_region->name; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('need_image_reading','読影',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="need_image_reading">
        <?php 
        if($work->order->need_image_reading == 1){
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
        <?php if($work->order->has('capturing_region')) echo $work->order->film_size->name; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('patient_num','受診者予定者数',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="patient_num"><?php echo $work->order->patient_num; ?></span>
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
    <span class="formData" class="col-md-8" id="start-no"><?php echo $work->start_no; ?></span>
</div>  
<div class="form-group clearfix">
    <?php   echo $this->Form->label('end_no','終了No',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="end-no"><?php echo $work->end_no; ?></span>
</div>          

    </div>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('absent_nums','欠番',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="absent-nums"><?php echo $work->absent_nums; ?></span>
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
 
<div class="info-box">
  <!-- Apply any bg-* class to to the icon to color it -->
  <span class="info-box-icon bg-red"><i class="fa fa-cogs"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">装置稼働台数</span>
    <span class="info-box-number"><?= $work->operation_number; ?>台</span>
  </div><!-- /.info-box-content -->
</div><!-- /.info-box --> 
 
    
</div>
</div>


<hr />

<div class="clearfix">
    <h3> <a href="<?php 

    echo $this->Url->build(['controller'=>'Equipments', 'action'=>'index']);  

 ?>" target="_blank">装置種類</a>
 </h3>
    <div class="col-md-6">
        
   
    <div class="col-md-6">        
<div class="form-group clearfix">
    <?php   echo $this->Form->label('equipmentA_id','装置A',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="equipmentA-id">
        <?php if($work->has('equipment1')) echo $work->equipment1->equipment_type->name . " " . $work->equipment1->equipment_no . "号車"; ?></span>
</div>
</div>    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('A_date_range','使用期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $work->A_start_date . " ~ " . $work->A_end_date; ?></span>
</div>  </div> 

    <div class="col-md-6">        
<div class="form-group clearfix">
    <?php   echo $this->Form->label('equipmentB_id','装置B',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="equipmentB-id">
        <?php if($work->has('equipment2')) echo $work->equipment2->equipment_type->name . " " . $work->equipment2->equipment_no . "号車"; ?></span>
</div>
</div>    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('B_date_range','使用期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $work->B_start_date . " ~ " . $work->B_end_date; ?></span>
</div>  </div> 


    <div class="col-md-6">        
<div class="form-group clearfix">
    <?php   echo $this->Form->label('equipmentC_id','装置C',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="equipmentC-id">
        <?php if($work->has('equipment3')) echo $work->equipment3->equipment_type->name . " " . $work->equipment3->equipment_no . "号車"; ?></span>
</div>
</div>    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('C_date_range','使用期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $work->C_start_date . " ~ " . $work->C_end_date; ?></span>
</div>  </div> 


        
    </div>
    
     <div class="col-md-6">
         

    <div class="col-md-6">        
<div class="form-group clearfix">
    <?php   echo $this->Form->label('equipmentD_id','装置D',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="equipmentD-id">
        <?php if($work->has('equipment4')) echo $work->equipment4->equipment_type->name . " " . $work->equipment4->equipment_no . "号車"; ?></span>
</div>
</div>    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('D_date_range','使用期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $work->D_start_date . " ~ " . $work->D_end_date; ?></span>
</div>  </div> 

    <div class="col-md-6">        
<div class="form-group clearfix">
    <?php   echo $this->Form->label('equipmentE_id','装置E',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="equipmentE-id">
        <?php if($work->has('equipment5')) echo $work->equipment5->equipment_type->name . " " . $work->equipment5->equipment_no . "号車"; ?></span>
</div>
</div>    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('E_date_range','使用期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $work->E_start_date . " ~ " . $work->E_end_date; ?></span>
</div>  </div>          
         
       

     </div>   
</div>
<hr />
<div class="clearfix">
<h3><a href="<?php 

    echo $this->Url->build(['controller'=>'Staffs', 'action'=>'index']);  

 ?>" target="_blank">放射線技師</a></h3>
 
 <p>
  <?php
    $technicians = [];
    for ($i=1; $i < 11; $i++) {
        $techniciani =  'technician'.$i;
        if($work->has($techniciani)){
            
            $technicians[] = $work->$techniciani->name;
            
        }
    }
  echo implode(" , ", $technicians);
  ?>   
     
 </p>
 
    
</div>
<hr />


<div class="clearfix">
<h3><a href="<?php 

    echo $this->Url->build(['controller'=>'Staffs', 'action'=>'index']);  

 ?>" target="_blank">スタッフ</a></h3>
 
 
  <p>
  <?php
    $staffs = [];
    for ($i=1; $i < 11; $i++) {
        $staffi =  'staff'.$i;
        if($work->has($staffi)){
            
            $staffs[] = $work->$staffi->name;
            
        }
    }
  echo implode(" , ", $staffs);
  ?>   
     
 </p>
 
 
        
</div>
<hr />



<div class="clearfix">
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('done','作業状況',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="done"><?php 
    if($work->done == 1){
        echo "完了";     
    }else{
        echo "未完了";
    }
    ?></span>
</div>  
</div><div class="col-md-6">        
        
</div>
</div>
<div class="clearfix  well bg-gray voffset4">
    <div class="text-center">
<?= $this->Html->link(__('編集する'), ['action' => 'edit',$work->id],
    ['class' => 'btn btn-success  glyphicon glyphicon-table']) ?> 
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('作業一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
</div>    
    <?= $this->Form->end() ?>


    <div class="clearfix">
<a href="<?php 
    echo $this->Url->build(['controller'=>'orders', 'action'=>'view',$work->order_id]);  
 ?>" 
 class="btn btn-app bg-blue" >    
 
<i class="fa fa-phone"></i>
注文ページへ
</a>
<a href="<?php 
    echo $this->Url->build(['controller'=>'cost-managements', 'action'=>'view',$work->order_id]);  
 ?>" 
 class="btn btn-app bg-yellow" >    
 
<i class="fa fa-jpy"></i>
費用ページへ
</a>
</div>
</section>




