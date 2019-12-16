<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker'
],
['block' => 'script']);
?>
<script type="text/javascript">
var work_places = new Object();

<?php
    $jsonOptions = json_encode($sortedOptions);
?>    
    var work_places = <?php echo $jsonOptions; ?>;
$(document).ready(function(){  

   // ロケールを設定
    moment.locale('ja');
    
    $('#date-range').daterangepicker({
        format:'YYYY/MM/DD',
        //singleDatePicker: true,
        autoUpdateInput:false,        
        showDropdowns: true,
               locale: {
         applyLabel: 'これで決定',
         cancelLabel: 'キャンセル',
         fromLabel: '期間開始',
         toLabel: '期間終了',
         weekLabel: 'W',
         
         customRangeLabel: '自分で指定',
         daysOfWeek: moment.weekdaysMin(),
         monthNames: moment.monthsShort(),
         firstDay: moment.localeData()._week.dow
       },
    }, 
    function(start, end, label) {
      $('#date-range').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
//start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    $("#start-date").val(start.format('YYYY/MM/DD'));
    $("#end-date").val(end.format('YYYY/MM/DD'));

});





    
    //請負元変更時処理
    
    $("[name=請負元]").change(function(){
        
        //  $("[name=派遣先]").prop('disabled',false);
         
          var client_id =$(this).children(':selected').val();
          
          $("[name=派遣先]").children('option').remove();
          var placeOptions = create_options(work_places[client_id]);
          $("[name=派遣先]").append(placeOptions);
   
      });     

});

function create_options(dataArray){
    if(dataArray == undefined || dataArray.length == 0){
            var options = '<option value="">選択可能な派遣先がありません！</option>';

        
    }else{
            var options = '<option value="">--</option>';
      $.each(dataArray,
        function(index, val) {
          options += '<option value="'+val.id+'">' + val.name + '</option>';
        }
      );  
    }   

    return options;
    
}


 

</script>
<section class="content-header">
<h1>
費用データ一覧
<small>受注業務の費用を管理します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">費用情報一覧表&nbsp;&nbsp;&nbsp;&nbsp;
        
    </h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
  
  <div class=" pull-right">   
 <div class="box box-solid text-right bg-gray">
  <div class="box-body">
 <div >
 <?php
    echo $this->Form->create(null,[
    'url'=>['action' => 'index']
    ,'class' => 'form'
  ]); ?>
  
  <fieldset>
    <div class="row">
      <div class="col-md-5">
<?php
  
  echo $this->Form->input('受注No');
  ?>
  </div>
  <div class="col-md-5">
  <?php
  

     echo $this->Form->input('start_date',[
     'type' => 'hidden']);       
     echo $this->Form->input('end_date',[
     'type' => 'hidden']);             
    echo $this->Form->input('date_range',[
    'label' => '業務開始日',
     'append'=>'<i class="fa fa-calendar"></i>']);

  

  ?>
    </div>

  <div class="col-md-2"> 
    </div>
  </div>
  <div class="row voffset2">
  <div class="col-md-5">
  <?php
  echo $this->Form->input('請負元',["type" => "select",
    'options'=> $clients, 'empty' => '--', 'class' => 'form-control form-control--extend'
  ]);
?>
</div>
 <div class="col-md-5">
<?php
  if(!empty($this->request->data['派遣先'])){
    $objArray = $sortedOptions[$this->request->data['請負元']];
    foreach ($objArray as $key => $values) {
      $options[$values->id] = $values->name;
    }

  }else{
    $options = null;
  }

  echo $this->Form->input('派遣先',["type" => "select",
    'options'=> $options, 'empty' => '請負元を選択'
  ]);
  ?>
  </div>
  <div class="col-md-2 text-center"> 
  <?php
  echo $this->Form->button('検索',['class' => 'btn-primary']);
  ?>
  </div>
  </div>
  </fieldset>


  <?php echo $this->Form->end(); ?> 
 
</div> 
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div> 
   
  <div class="equipment-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-yellow">
                <th ><?= __('受注No') ?></th>
                <th ><?= __('実施期間') ?></th>
                <th ><?= __('請負元') ?></th>
                <th ><?= __('派遣先') ?></th>
                <th ><?= __('業務内容') ?></th>
                <th ><?= __('可搬特別費') ?></th>
                <th ><?= __('出張費') ?></th>
                <th ><?= __('読影費') ?></th>
                <th ><?= __('交通費') ?></th>
                <th ><?= __('人件費') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php 
             $fmt_option = ['after' => ' 円'];
             foreach ($orders as $order): ?>
            <tr>
                <td><?= h($order->order_no) ?></td>
                <td><?= h($order->start_date->format("Y/m/d") . " ~ " . $order->end_date->format("Y-m-d")) ?></td>
                <td><?php
                if(!empty($order->client)){
                    echo $order->client->name;
                }
                 ?></td>
                <td><?php
                if(!empty($order->work_place)){
                    echo $order->work_place->name;
                }
                 ?></td>
                <td><?php
                if(!empty($order->work_content_id)){
                    echo $workContents[$order->work_content_id];
                }
                 ?></td> 
                <td><?= $this->Number->format($order->transportable_equipment_cost,$fmt_option);   ?> </td>
                 <td><?= $this->Number->format($order->transportation_cost,$fmt_option);   ?> </td>
                <td><?= $this->Number->format($order->image_reading_cost,$fmt_option);   ?> </td>
                <td><?= $this->Number->format($order->travel_cost,$fmt_option);   ?> </td>
                <td><?= $this->Number->format($order->labor_cost,$fmt_option);   ?> </td>

                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $order->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $order->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>         
          
      </tbody>      
      
  </table>
  <div class="paginator">
    <ul class="pagination">
      <?php
        $this->Paginator->options(['url'=> ['action'=>'index','usePaging'=>1]]);            
      ?>     
        <?= $this->Paginator->first('<< ' . __('最初')) ?>
        <?= $this->Paginator->prev('< ' . __('前')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('次') . ' >') ?>
        <?= $this->Paginator->last(__('最後') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
  </div>        
      
  </div>
    
    
    
  </div><!-- /.box-body -->
  <div class="box-footer">
    
  </div><!-- box-footer -->
</div><!-- /.box -->            
            
            
            
        </div>       
        
    </div>

</section>

