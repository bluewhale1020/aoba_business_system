<script type="text/javascript" charset="utf-8">

$(document).ready(function(){ 
    
    
    $('.weekday').on('click',function(){
        put_weekdayval_to_hiddenfield(".weekday");
        calc_num_o_days();
    }); 
    $('.holiday').on('change',function(){
        calc_num_o_days();
    });     
       

});    

//曜日番号をhiddenフォームに設定
function put_weekdayval_to_hiddenfield(selector){
    optionid_arr =new Array();
    var idx = 0;
 $(selector).each(function(i) {
        if($(this).prop('checked')){
            optionid_arr[idx] = parseInt( $(this).val());       
            idx = idx + 1;  
        }
        

  }); 
    $("#holiday-numbers").val(optionid_arr.join(","));
    
    
} 
function calc_num_o_days()
{
    var holiday_numbers = $("#holiday-numbers").val();
    var holiday1 = $("#holiday1").val();
    var holiday2 = $("#holiday2").val();
    var holiday3 = $("#holiday3").val();    
    var order_id = $("#id").val();
    var partner_id = $("#work-place-id").val();
    var data = {order_id:order_id,holiday_numbers:holiday_numbers,holiday1:holiday1,
        holiday2:holiday2,holiday3:holiday3,partner_id:partner_id};
    
    var Url = "/aoba_business_system/orders/ajaxcalcnumodays";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:data,
        type:"POST",
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },
        success:function(zipData){
        // カンマ区切りテキストを解析して一致したデータを表示
        var parseData = eval("("+zipData+")");  
        //         alert(parseData);                
        
        if(parseData != false){
            
         $("#num_o_days").text(parseData.num_o_days);    
        $("#holidayCount").text(parseData.holidayCount);           
            
        }
        
    
        
        },
        error:function(XHR, status, errorThrown){
            if(XHR.responseJSON.message != null){
                alert(XHR.responseJSON.message);
            }else{
                alert(status)
            }
            }
        
        });




    
}


function print_order_confirmation(){
  

 var Url = "/aoba_business_system/printers/print_order_confirmation/" + $("#id").val() ;
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字


 location.href= Url;

}

</script>



<style type="text/css" media="screen">
	.content{
	    font-size:larger;
	}
</style>
<section class="content-header">
<h1>
注文データ詳細
<small>注文データの詳細を表示します</small>

</h1>
</section>
<section class="content voffset4">
<div class="pull-right">
    <?php 

     echo $this->Form->button(' 注文請書出力', array(
    'type' => 'button',
    'div' => false,
    'class' => 'btn btn-warning glyphicon glyphicon-print',
    'onclick' =>"Javascript:print_order_confirmation();return false;"
));     ?>

<div class="btn-group">
  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp; その他帳票出力 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><?= $this->Html->link(__('作業伝票'), ['controller' => 'printers','action' => 'print_work_sheet',$order->id],
    ['class' => '']) ?> </li>
    <li><?= $this->Html->link(__('照射録'), ['controller' => 'printers','action' => 'print_irradiation_record',$order->id],
    ['class' => '']) ?></li>
    <li><?= $this->Html->link(__('ラベル'), ['controller' => 'printers','action' => 'print_label_sheet',$order->id],
    ['class' => '']) ?></li>
  </ul>
</div>
   


</div>
<?= $this->Form->input('id',['type' => 'hidden','value' => $order->id]) ?>

<div class="clearfix">
    <h3>基本情報</h3>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('order_no','受注No',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="order-no"><?php echo $order->order_no; ?></span>
</div>         
<div class="form-group clearfix">
<?php   echo $this->Form->label('client_name','請負元',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="client-name">
        <?php if($order->has('client')): ?>
            <a href="<?php 
            echo $this->Url->build(['controller'=>'BusinessPartners', 'action'=>'view', $order->client->id]);  
        ?>" target="_blank"> <?php echo $order->client->name; ?></a>
        <?php endif; ?>
    </span>
</div>        
<div class="form-group clearfix">
<?php   echo $this->Form->label('work_place_name','派遣先',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="work-place-name">
        <?php if($order->has('work_place')): ?>
            <a href="<?php 
            echo $this->Url->build(['controller'=>'BusinessPartners', 'action'=>'view', $order->work_place->id]);  
        ?>" target="_blank"> <?php echo $order->work_place->name; ?></a>
        <?php echo $this->Form->input('work_place_id',['type' => 'hidden','value' => $order->work_place->id]);?>        
        <?php endif; ?>
    </span>
</div>         
          
    </div>
    
     <div class="col-md-6">
<div class="form-group">
    <?php   echo $this->Form->label('temporary_registration','ステータス',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="temporary-registration"><?php 
    if($order->temporary_registration == 1){
        echo "仮登録";
    }elseif($order->temporary_registration == 0){
        echo "正式登録";
    }?></span>
</div> 
<div class="form-group">
    <?php   echo $this->Form->label('recipient','届け先',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="recipient"><?php echo $order->recipient; ?></span>
</div> 
<div class="form-group">
    <?php   echo $this->Form->label('payment','請求先',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="payment"><?php echo $order->payment; ?></span>
</div> 
<div class="form-group">
    <?php   echo $this->Form->label('notes','備考',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="notes"><?php echo $order->notes; ?></span>
</div>          
         
     </div>   
</div>
<hr />

<div class="clearfix">
    <h3>実施期間</h3>
<div class="clearfix">
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('date_range','期間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="date-range"><?php echo $order->start_date . " ~ " . $order->end_date; ?></span>
</div>         
<div class="form-group clearfix">
    <?php   echo $this->Form->label('time_range','時間',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="time-range">
        <?php 
        if(!empty($order->start_time) and !empty($order->end_time)){
            echo $order->start_time->format("H:i") . " ~ " . $order->end_time->format("H:i");
        }
         ?></span>
</div>  
    </div>
    
     <div class="col-md-6">
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

    <?= $this->Form->create($order->work_place,[
    'class' => 'form-horizontal'
    ]) ?>
<div class="clearfix">
<legend>派遣先休日設定</legend>    
<div class="col-md-6">
<div class="box collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">定休日(曜日)</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
      <?php
            echo $this->Form->input('holiday_numbers',[
            'type'=>"hidden"
            ]);
    ?>
  
<table class="table table-bordered table-condensed text-center">
    <thead>
        <th>日</th>        
        <th>月</th>        
        <th>火</th>        
        <th>水</th>        
        <th>木</th>        
        <th>金</th>        
        <th>土</th>        
        
    </thead>
    <tbody>
        <tr>
<?php
$week_nums = explode(",", $order->work_place->holiday_numbers ) ;
$checkArray = ['0'=>false,'1'=>false,'2'=>false,'3'=>false,'4'=>false,
'5'=>false,'6'=>false];
foreach ($week_nums as $key => $value) {
    $checkArray[$value] = true;
}

?>

            <td>
<?= $this->Form->checkbox('sunday',['checked' => $checkArray[0],
    'class' => 'weekday','value'=>'0','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('monday',['checked' => $checkArray[1],
    'class' => 'weekday','value'=>'1','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('tuesday',['checked' => $checkArray[2],
    'class' => 'weekday','value'=>'2','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('wednesday',['checked' => $checkArray[3],
    'class' => 'weekday','value'=>'3','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('thursday',['checked' => $checkArray[4],
    'class' => 'weekday','value'=>'4','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('friday',['checked' => $checkArray[5],
    'class' => 'weekday','value'=>'5','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('saturday',['checked' => $checkArray[6],
    'class' => 'weekday','value'=>'6','hiddenField' => false,'name' => false,'disabled'=>true]); ?>               
            </td>
            
        </tr>
        
    </tbody>
</table>


  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->     
    
    
</div><div class="col-md-6">
<div class="box collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">定休日(特定日)</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <table class="table table-condensed vertical-table table-bordered">
<?php
    if(!empty($given_holidays[0])){
    foreach ($given_holidays as $key => $holiday): ?>
        <tr>
        <th scope="row"><?= __("休日" .($key + 1)) ?></th>
        <td><?= $holiday ?></td>
        </tr>
<?php endforeach;}else{
    echo '<tr><th cols="2">該当日なし</th></tr>';
} ?>
     
                
    </table>

  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->     
    
</div>

</div>
<?= $this->Form->end() ?>    
</div>
<hr />
<div class="clearfix">
<h3>業務詳細</h3>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('work_content_id','業務内容',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="work-content-id"><?php
    if($order->has('work_content')) echo $order->work_content->description; ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('capturing_region_id','撮影部位',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="capturing-region-id"><?php
    if($order->has('capturing_region')) echo $order->capturing_region->name; ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('need_image_reading','読影',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="need-image-reading">
        <?php     if($order->need_image_reading == 1){
        echo "あり";
    }elseif($order->need_image_reading == 0){
        echo "なし";
    } ?></span>
</div>         
       
    </div>
    
     <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('film_size_id','フィルムサイズ',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="film-size-id">
        <?php if($order->has('film_size')) echo $order->film_size->name; ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('patient_num','受診者数',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="patient-num"><?php echo $order->patient_num; ?></span>
</div>          
       
         
     </div>   
</div>
<hr />

<div class="clearfix accounts">
<h3>会計</h3>
<?php
    $fmt_option = ['after' => ' 円'];
?>
    <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('guaranty_charge','保証料金',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="guaranty-charge"><?php echo $this->Number->format($order->guaranty_charge,$fmt_option); ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('guaranty_count','保証人数',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="guaranty-count"><?php echo $order->guaranty_count; ?></span>
</div>         
        
    </div>
    
     <div class="col-md-6">
<div class="form-group clearfix">
    <?php   echo $this->Form->label('additional_count','追加人数',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="additional-count"><?php echo $order->additional_count; ?></span>
</div> <div class="form-group clearfix">
    <?php   echo $this->Form->label('additional_unit_price','追加料金単価',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="additional-unit-price"><?php echo $this->Number->format($order->additional_unit_price,$fmt_option); ?></span>
</div>          

     </div>   
</div>

<hr />

<div class="clearfix">
    <div class="col-md-6">
</div><div class="col-md-6"> 
   <div class="form-group clearfix">
    <?php   echo $this->Form->label('total','受注額合計',['class'=>'col-md-4']); ?>
    <span class="formData" class="col-md-8" id="total">
        <?php 
            $total = $order->guaranty_charge +
            $order->additional_count * $order->additional_unit_price;        
            echo $this->Number->format($total,$fmt_option); ?></span>
</div> 
            
</div>
</div>



<div class="clearfix  well bg-gray voffset4">
    <div class="text-center">
<?= $this->Html->link(__('注文情報編集'), ['action' => 'edit',$order->id],
    ['class' => 'btn btn-success']) ?> 
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('注文一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default']) ?> 
    </div>
</div>    


<div class="clearfix">
<a href="<?php 
 if($order->has('works')){
    echo $this->Url->build(['controller'=>'works', 'action'=>'view',$order->works[0]->id]);  
 }
 ?>" 
 class="btn btn-app bg-olive" >    
 
<i class="fa fa-briefcase"></i>
作業ページへ
</a>
<a href="<?php 
    echo $this->Url->build(['controller'=>'cost-managements', 'action'=>'view',$order->id]);  
 ?>" 
 class="btn btn-app bg-yellow" >    
 
<i class="fa fa-jpy"></i>
費用ページへ
</a>
</div>


</section>


