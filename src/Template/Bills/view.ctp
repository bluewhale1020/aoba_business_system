<script type="text/javascript" charset="utf-8">


function print_bill(){
 
 
 // if(exportedDate != ''){
//     
    // var ret = confirm('この請求書は' + exportedDate + 'に出力されていますが、再度出力しますか？');    
//     
 // }else{
    // var ret = true;
 // }
 
 // if(ret == true){
     var id = $("#bill-id").val();
     
     // today=new Date();
    // y=today.getFullYear();
    // m=today.getMonth()+1;
    // d=today.getDate();
//      
     // exportedDate = y + "-" + m + "-" + d;
     
     var Url = "/aoba_business_system/printers/print_bill/"  + id ;
     //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    
    
     location.href= Url;    
 //}
}
function print_delivery_slip(){
 

     var id = $("#bill-id").val();
     
     
     var Url = "/aoba_business_system/printers/print_delivery_slip/"  + id ;
     //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    
    
     location.href= Url;    

    
}
</script>
<style type="text/css" media="screen">
	.meisai_odd{
    background-color:#05491A;
    }
    p{
        font: larger;
    }
    .box-danger th ,.box-danger .active ,.box-danger{
        text-align: center;
        /* color:#006600; */
    }
    .bill-item{
        text-align: center;
        color: black;
        background-color: #d7eed7;
    }
    </style>
<section class="content-header">
<h1>
請求書内容閲覧 (
 <a href="<?php 

    echo $this->Url->build(['controller'=>'BusinessPartners', 'action'=>'view', $bill->business_partner->id]);  

 ?>" target="_blank"><?=$bill->business_partner->name ?></a>    
    )
<small>選択した請求書を閲覧します</small>
</h1>
</section>
<section class="content voffset4">

    <div class="row">
<div class="col-md-12">
<?php
echo $this->Form->input('bill_id',['id' => 'bill-id','type' => 'hidden','value' => $bill->id]);
?>    

<div class="box box-default collapsed-box ">
  <div class="box-header with-border">
    <h3 class="box-title">請求対象の注文情報</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">


  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-primary">
                <th ><?= __('受注No') ?></th>
                <th ><?= __('実施期間') ?></th>
                <th ><?= __('請負元') ?></th>
                <th ><?= __('派遣先') ?></th>
                <th ><?= __('業務内容') ?></th>
                <th ><?= __('金額(税抜)') ?></th>
                <th ><?= __('請求済') ?></th>
                <th ><?= __('備考') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php foreach ($bill->orders as $order): ?>
            <tr>
                <td><?= h($order->order_no) ?></td>
                <td><?= h($order->start_date . " ~ " . $order->end_date) ?></td>
                <td><?php
                if($order->has('client')){
                    echo $order->client->name;
                }
                 ?></td>
                <td><?php
                if($order->has('work_place')){
                    echo $order->work_place->name;
                }
                 ?></td>
                <td><?php
                if($order->has('work_content')){
                    echo $order->work_content->description;
                }
                 ?></td> 
                <td><?php
                $total = $order->guaranty_charge +
                $order->additional_count * $order->additional_unit_price;                
                 echo $total; ?> </td>
                <td><?php
                    if(!empty($order->bill_id)){
                        echo '<span class="text-success">✔</span>';
                    }else{
                        echo '<span class="text-danger">×</span>';
                    } 

                 ?></td>                

                <td><?= h($order->notes) ?></td>
                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　詳細'), ['controller'=>'orders','action' => 'view', $order->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign','target'=>'_blank']) ?>
                    </div>
                </td>
            </tr>
<?php endforeach; ?>                     
          
      </tbody>      
      
  </table>

  </div><!-- /.box-body -->
</div><!-- /.box -->    
    
   
</div>


        <div class="col-md-12">

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">請求書の内容
    
    </h3>

  </div><!-- /.box-header -->
    <div class="box-tools pull-right">
        <div class="col-md-12 voffset1">
            <div class="btn-group">
            <?php 
                echo $this->Form->button(' 請求書出力', array(
                'type' => 'button',
                'div' => false,
                'class' => 'btn btn-warning glyphicon glyphicon-print',
                'onclick' =>"Javascript:print_bill(". $bill->id .");return false;"
            ));     ?>
            <?php 
                echo $this->Form->button(' 納品書出力', array(
                'type' => 'button',
                'div' => false,
                'class' => 'btn btn-warning glyphicon glyphicon-print',
                'onclick' =>"Javascript:print_delivery_slip(". $bill->id .");return false;"
            ));     ?>        
            </div>
         </div>
    </div><!-- /.box-tools -->  
 
  
  <div class="box-body">
      <div class="row">
      <div class="col-md-7">
<h2>請求書</h2>
<div>
   <h3><u><?= $bill->business_partner->name ?>&nbsp;&nbsp;&nbsp;様</u></h3> 
    
</div>
</div><div class="col-md-5 voffset3">
     <p class="text-right">送付日： <?= $bill->bill_sent_date; ?>&nbsp;&nbsp;No: <?=$bill->bill_no ?></p>
 <div class="text-right box box-solid bg-gray-active">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$mycompany->name; ?></h3>
    </div>
    <div class="box-body">
        <div class="company_info">
            <p><strong><?=$mycompany->address . $mycompany->banchi . $mycompany->tatemono; ?></strong></p>
            <p>電話：　<?=$mycompany->tel; ?></p>
            <p>FAX：　<?=$mycompany->fax; ?></p>     
        </div>
    </div>

 </div>   

</div>
</div><!-- / .row -->

<div class="clearfix">
<p>下記のとおりご請求申し上げます</p> 
    
</div>  
<div class="row primary_info">
<div class="col-md-12">     
<table class="table table-bordered">
<tbody>
<tr>
<td class="bill-item">総額</td><td class='text-right'><?php echo $this->Number->currency($bill->total_charge, "JPY"); ?></td>
<td  class="bill-item">税率</td><td class='text-right'><?php echo $this->Number->format(10,['after'=>'%']); ?></td>
<td  class="bill-item">消費税額</td><td class='text-right'><?php echo $this->Number->currency($bill->consumption_tax, "JPY"); ?></td>
</tr>   
    
</tbody>    
</table>
</div>  
</div>


<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">請求明細</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table table-bordered table-striped">
<thead >
<tr class="bill-item">
<th>品名</th>
<th>数量</th>
<th>単価</th>
<th>金額</th>
</tr>

</thead>
<tbody>

<?php
$total = 0;
$subtotal = 0;
$idx = 0;
foreach ($bill->orders as $order):
    $subtotal = $order->guaranty_charge + 
    $order->additional_count * $order->additional_unit_price + $order->other_charge;    
    $total += $subtotal;
    
if($idx % 2 == 1){$color = 'info';}else{$color = 'default';}
echo "<tr class='$color'><td>".$order->description."</td>";
echo "<td class='text-right'>1</td>"; //".count($order)." error $order not countable
echo "<td class='text-right'>".$this->Number->currency($subtotal, "JPY")."</td>";
echo "<td class='text-right'>".$this->Number->currency($subtotal, "JPY")."</td></tr>";

 
$idx++;
endforeach;
?>  
<tr><td colspan="2" rowspan="3" style="visibility:hidden"></td>
    <td  class="bill-item">小計</td><td class='text-right'><?php echo $this->Number->currency($total, "JPY"); ?></td></tr>
<tr><td  class="active">消費税</td><td class='text-right'><?php echo $this->Number->currency($bill->consumption_tax, "JPY"); ?></td></tr>
<tr><td  class="bill-item">合計</td><td class='text-right'><?php echo $this->Number->currency(($total + $bill->consumption_tax), "JPY"); ?></td></tr>
</tbody>

</table>    

<div class="clearfix  well bg-gray voffset4">
    <div class="text-center"> 
<?= $this->Html->link(__('請求情報編集'), ['action' => 'edit',$bill->id,$year,$month],
    ['class' => 'btn btn-success']) ?> 
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('請求書管理に戻る'), ['action' => 'index',$bill->business_partner_id,$year,$month],
    ['class' => 'btn btn-default']) ?> 
    </div>
</div> 

  </div><!-- /.box-body -->
</div><!-- /.box -->



    
  </div><!-- /.box-body -->
  <div class="box-footer">
    
  </div><!-- box-footer -->
</div><!-- /.box -->



</div><!-- /.col-md-12 -->

</section>


