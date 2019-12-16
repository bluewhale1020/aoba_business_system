<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker'
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker'
],
['block' => 'script']);
?>

<script type="text/javascript">

var equipment_types = [
<?php 
    $original_desc = $order->description;
    foreach ($equipment_types as $key => $value) {
        $equip_array[] = "'".$value."'";
       $original_desc = preg_replace("/[\s　]*". $value ."/", "", $original_desc);
    }

    echo implode(",", $equip_array);

?>
];

var original_desc = '<?= $original_desc;  ?>';

$(document).ready(function(){  

  // ロケールを設定
    moment.locale('ja');

    var picker_option = {
        format:'YYYY/MM/DD',
        //singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput:false,        
    <?php 
    if(!empty($order->start_date)){
        echo '"minDate":';
        echo '"' . $order->start_date->format("Y/m/d") . '"';
        echo ',';
    }?>
    <?php 
    if(!empty($order->end_date)){
        echo '"maxDate":';
        echo '"' . $order->end_date->format("Y/m/d") . '"';
        echo ',';
    }
    ?>        
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
    $('.date_range').each(function(i,elem){
        $(elem).daterangepicker(picker_option, 
        (start, end, label) => {
            let prefix =  $(elem).attr('id').slice( 0, 1 ) ;
            $(elem).val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
            $("#" + prefix + "-start-date").val(start.format('YYYY/MM/DD'));
            $("#" + prefix + "-end-date").val(end.format('YYYY/MM/DD'));
        });
    });
    
$('.date_range').on('change',function(){
    if($(this).val() == ''){
        let prefix =  $(this).attr('id').slice( 0, 1 ) ;
            $("#" + prefix + "-start-date").val('');
            $("#" + prefix + "-end-date").val('');        
    }
});


 $('[data-toggle="popover"]').popover();
    

$('.equipment').on('change',function(){
    put_operation_num_to_hiddenfield();
});


    $(".sub_item_name").on("change",function(){
       var description = new Array();
       $(".sub_item_name").each(function(){
           sel_text = $(this).find('option:selected').text();
           $.each(equipment_types,function(index, elem){
               if(sel_text.indexOf(elem) != -1){
                  description.push(elem) ; 
                   return false;
               }
           });
           
       }) ;
       
       var str_desc = original_desc + " " + description.join(" ");
       
        $("#order-description").val(str_desc);
    }); 



});


//装置台数をhiddenフォームに設定
function put_operation_num_to_hiddenfield(){
    var num = 0;
    var idx = 0;
 $(".equipment").each(function(i) {
        if($(this).val() != ''){
            num++;  
        }
        

  }); 
    $("#operation-number").val(num);
    
    
} 
  

</script>

<section class="content-header">
<h1>
作業内容の編集
<small>作業内容を編集します</small>
</h1>
</section>
<section class="content voffset4">

    <?= $this->Form->create($work,[
    'class' => 'form-horizontal'
    ]) ?>

<div class="clearfix">
    <h3><a href="<?php 
 if($order->has('client')){
    echo $this->Url->build(['controller'=>'orders', 'action'=>'view',$order->id]);  
 }
 ?>">【<?= $work->order->order_no ?>】      注文内容</a></h3>
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
    <span class="formData" class="col-md-8" id="date-range"><?php echo $order->start_date->format("Y/m/d") . " ~ " . $order->end_date->format("Y/m/d"); ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('time_range','時間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="time-range"><?php 
    if(!empty($order->start_time) and !empty($order->end_time)){
            echo $order->start_time->format("H:i") . " ~ " . $order->end_time->format("H:i");
            
    } ?></span>
     </div>              
         
     </div>   
</div>
<div class="clearfix">
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
    <span class="formData" class="col-md-8" id="capturing_region"><?php echo $order->capturing_region->name; ?></span>
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
    <span class="formData" class="col-md-8" id="film_size"><?php echo $order->film_size->name; ?></span>
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
        <?php
             echo $this->Form->input('start_no',[
             'label' => '開始No']);
             echo $this->Form->input('end_no',[
             'label' => '終了No']);                    


        ?>
        
    </div>
    <div class="col-md-6">
        <?php
             echo $this->Form->input('absent_nums',[
             'label' => '欠番',
             'data-toggle'=>"popover" ,'title'=>"欠番入力形式" , 'data-content'=>"例： 12,34,55",
              'data-placement'=>"bottom"]);

        ?>
        
    </div>
  </div><!-- /.box-body -->
  <div class="box-footer">
 
  </div><!-- box-footer -->
</div><!-- /.box -->



</div>





<hr />



<div class="clearfix">
    <h3> <a href="<?php 

    echo $this->Url->build(['controller'=>'Equipments', 'action'=>'index']);  

 ?>">装置種類</a></h3>

 
    <div class="col-md-6">
     <?php
         echo $this->Form->input('operation_number',[
         'type' => 'hidden']); 
     ?>       
        
 <div class="clearfix">
    <div class="col-md-6">
    <?php
         echo $this->Form->input('equipmentA_id',[
         'label' => '装置A', 'empty' => '--',
         'options' => $equipments,'class' => 'form-control equipment sub_item_name']); 
     ?>
    </div><div class="col-md-6 p_o_use">
    <?php
         echo $this->Form->input('A_date_range',[
         'label' => '使用期間',
         'class' =>'form-control date_range']); 
             echo $this->Form->input('A_start_date',[
             'type' => 'hidden',
         'class' =>'start']);       
             echo $this->Form->input('A_end_date',[
             'type' => 'hidden',
         'class' =>'end']);         
     ?>            
            
            
    </div>     
     
 </div> 
 
  <div class="clearfix">
    <div class="col-md-6">
    <?php
         echo $this->Form->input('equipmentB_id',[
         'label' => '装置B', 'empty' => '--',
         'options' => $equipments,'class' => 'equipment form-control']); 
     ?>
    </div><div class="col-md-6 p_o_use">
    <?php
         echo $this->Form->input('B_date_range',[
         'label' => '使用期間',
         'class' =>'form-control date_range']); 
             echo $this->Form->input('B_start_date',[
             'type' => 'hidden',
         'class' =>'start']);       
             echo $this->Form->input('B_end_date',[
             'type' => 'hidden',
         'class' =>'end']);         
     ?>            
            
            
    </div>     
     
 </div>
 
  <div class="clearfix">
    <div class="col-md-6">
    <?php
         echo $this->Form->input('equipmentC_id',[
         'label' => '装置C', 'empty' => '--',
         'options' => $equipments,'class' => 'equipment form-control']); 
     ?>
    </div><div class="col-md-6 p_o_use">
    <?php
         echo $this->Form->input('C_date_range',[
         'label' => '使用期間',
         'class' =>'form-control date_range']); 
             echo $this->Form->input('C_start_date',[
             'type' => 'hidden',
         'class' =>'start']);       
             echo $this->Form->input('C_end_date',[
             'type' => 'hidden',
         'class' =>'end']);         
     ?>            
            
            
    </div>     
     
 </div>       
       
        
    </div>    
     <div class="col-md-6">


  <div class="clearfix">
    <div class="col-md-6">
    <?php
         echo $this->Form->input('equipmentD_id',[
         'label' => '装置D', 'empty' => '--',
      
         'options' => $equipments,'class' => 'equipment form-control']); 
     ?>
    </div><div class="col-md-6 p_o_use">
    <?php
         echo $this->Form->input('D_date_range',[
         'label' => '使用期間',
         'class' =>'form-control date_range']); 
             echo $this->Form->input('D_start_date',[
             'type' => 'hidden',
         'class' =>'start']);       
             echo $this->Form->input('D_end_date',[
             'type' => 'hidden',
         'class' =>'end']);         
     ?>            
            
            
    </div>     
     
 </div> 

  <div class="clearfix">
    <div class="col-md-6">
    <?php
         echo $this->Form->input('equipmentE_id',[
         'label' => '装置E', 'empty' => '--',
         'options' => $equipments,'class' => 'equipment form-control']); 
     ?>
    </div><div class="col-md-6 p_o_use">
    <?php
         echo $this->Form->input('E_date_range',[
         'label' => '使用期間',
         'class' =>'form-control date_range']); 
             echo $this->Form->input('E_start_date',[
             'type' => 'hidden',
         'class' =>'start']);       
             echo $this->Form->input('E_end_date',[
             'type' => 'hidden',
         'class' =>'end']);         
     ?>            
            
<?php

     echo $this->Form->input('order.id',[
         'type' => 'hidden']);
    echo $this->Form->input('order.description',[
    'type' => 'hidden'
    ])
?>            
    </div>     
     
 </div> 

     </div>   
</div>
<hr />
<div class="clearfix">
<h3><a href="<?php 

    echo $this->Url->build(['controller'=>'Staffs', 'action'=>'index']);  

 ?>">放射線技師</a></h3>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('technician1_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('technician5_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('technician2_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('technician6_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('technician3_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('technician7_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('technician4_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('technician8_id',[
             'options' => $technicians,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>          
</div>
<hr />


<div class="clearfix">
<h3><a href="<?php 

    echo $this->Url->build(['controller'=>'Staffs', 'action'=>'index']);  

 ?>">スタッフ</a></h3>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('staff1_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('staff5_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('staff2_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('staff6_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('staff3_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('staff7_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>
    <div class="col-md-3">
        <?php
        
             echo $this->Form->input('staff4_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]);       
        
             echo $this->Form->input('staff8_id',[
             'options' => $staffs,
             'empty' => '--',
             'label' => false
             ]); 
              
        ?>
    </div>          
</div>
<hr />



<div class="clearfix">
    <div class="col-md-6">

</div><div class="col-md-6">        
        <?php
        
             echo $this->Form->input('done',[
             'label' => '作業状況',
             'options'=>['0'=>'未完了','1' => '完了']
             ]);           
        ?>            
</div>
</div>
<div class="clearfix  well bg-gray voffset4">
    <div class="text-center">
    <?= $this->Form->button(__('これで更新する'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('キャンセル'), ['action' => 'view',$work->id],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
</div>    
    <?= $this->Form->end() ?>

</section>



