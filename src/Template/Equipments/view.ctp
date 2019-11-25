<?php
// $this->Html->script([
// ],
// ['block' => 'script']);
?>
<script type="text/javascript">

$(document).ready(function(){  

    // ロケールを設定
    moment.locale('ja');




});
</script>
<section class="content-header">
<h1>
装置情報
<small>装置の情報を表示します</small>
</h1>
</section>
<section class="content voffset4 ">
 <div class="col-md-7">  
    <div class="clearfix">
    <div class="pull-left">
    <?= $this->Html->link('　編集',[
    'action' => 'edit',$equipment->id
    ],
    ['class' => 'btn btn-success  glyphicon glyphicon-pencil']);
   ?>&nbsp;&nbsp;&nbsp;    
    <?= $this->Html->link(__('装置一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?>       
   </div></div> 
   <div class="view table voffset4">
      <table class="table vertical-table table-bordered">
            <tr class="bg-navy disabled">
            <th scope="row">項目名</th>
            <td>データ</td>
            </tr>
            <!-- <tr>
            <th scope="row">id</th>
            <td><?//= h($equipment->id) ?></td>
            </tr> -->
            <tr>
                <th scope="row">装置番号</th>
                <td><?= h($equipment->equipment_no) ?></td>
            </tr>
            <tr>
                <th scope="row">装置名称</th>
                <td><?= h($equipment->name) ?></td>
            </tr>
            <tr>
                <th scope="row">装置種類</th>
                <td><?= $equipment->has('equipment_type') ? $equipment->equipment_type->name : '' ?></td>
            </tr>
            <tr>
                <th scope="row">撮影種類</th>
                <td><?php
                if(isset($equipment->xray_type)){
                    echo $equipment->xray_type->name;
                    // if($equipment->xray_type == 1){
                    //     echo "直接";
                        
                    // }  elseif($equipment->xray_type == 2){
                    //     echo "間接";
                    // }   elseif($equipment->xray_type == 3){
                    //     echo "デジタル";
                    // }
                }
                  ?></td>
                
            </tr>
            <tr>
                <th scope="row">可搬性</th>
                <td><?php 
                if(isset($equipment->transportable)){
                    if($equipment->transportable == 1){
                        echo "あり";
                        
                    }  else{
                        echo "無し";
                    }
                }
                 ?></td>
                
            </tr>
            <tr>
                <th scope="row">使用頻度</th>
                <td><?= h($equipment->number_of_times) ?></td>
                
            </tr>
            <tr>
                <th scope="row">状態</th>
                <td><?= $equipment->has('status') ? $equipment->status->name : "" ?></td>
                
            </tr>   
            <tr>
                <th scope="row">使用開始日</th>
                <td><?php
                if($equipment->has('install_date')){
                    $datetime = (new DateTime($equipment->install_date))->format("Y/m/d");
                    echo $datetime;
                } ?></td>
                
            </tr>              
           <tr>
                <th scope="row">備考</th>
                <td><?= h($equipment->notes) ?></td>
                
            </tr>                                              
        </table>
    
   </div>
   
   </div> <div class="col-md-5">
   <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">装置使用状況</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <table class="table table-condensed vertical-table table-bordered">
    <thead>
    <th>開始日</th><th>終了日</th><th>派遣先</th>
    </thead>
    <tbody>
    
    </tbody>
    <?php
    foreach ($eRentals as $key => $rentalDetail): ?>
        <tr>
            <td><?= (new DateTime($rentalDetail->start_date))->format("Y-m-d")  ?></td> 
            <td><?= (new DateTime($rentalDetail->end_date))->format("Y-m-d")  ?></td>  
            <td><?= $rentalDetail->work->order->work_place->name ?></td>
        </tr> 

            <?php endforeach; ?>
 
</table>


  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->    
   
   </div>
</section>


