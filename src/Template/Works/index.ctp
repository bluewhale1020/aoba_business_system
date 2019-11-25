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




    $('.done').on('change',function(){
        
        var work_id = $(this).attr('id');
        
        work_id = work_id.split('-')[1];
        
        ajaxsaveworksatus(work_id,$(this).val());
        
    }); 
    
    //請負元変更時処理
    
    $("[name=請負元]").change(function(){
        
        // $("[name=派遣先]").prop('disabled',false);
        
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






  function ajaxsaveworksatus(work_id,value){
      

    var data = {work_id:work_id,value:value};
    
    var Url = "/aoba_business_system/works/ajaxsaveworksatus";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:data,
        type:"POST",
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },
        success:function(zipData){
        // カンマ区切りテキストを解析して一致したデータを表示
        var parseData = eval("("+zipData+")");  
                // alert(parseData);  

          if(parseData.result == 1){
            $("#modal-alert").modal('show').removeClass("modal-danger").addClass("modal-success");
            $(".modal-title").text("保存成功");
            $("#modal-message").text(parseData.message);

          }else{
            $("#modal-alert").modal('show').removeClass("modal-success").addClass("modal-danger");           
            $(".modal-title").text("保存失敗");
            $("#modal-message").text(parseData.message);

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
  
  

</script>
<section class="content-header">
<h1>
作業一覧
<small>登録されている作業データを管理します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">作業一覧表&nbsp;&nbsp;&nbsp;&nbsp;
        
    </h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
  
  <div class="pull-right">   
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
             <tr class="bg-olive">
                <th ><?= __('受注No') ?></th>
                <th ><?= __('実施期間') ?></th>
                <th ><?= __('請負元') ?></th>
                <th ><?= __('派遣先') ?></th>
                <th ><?= __('業務内容') ?></th>
                <th ><?= __('部位　種別') ?></th>
                <th ><?= __('装置') ?></th>  
                <th ><?= __('スタッフ') ?></th> 
                <th ><?= __('技師') ?></th>                                               
                <th ><?= __('作業完了') ?></th>

                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php foreach ($works as $work): ?>
            <tr>
                <td><?= h($work->order->order_no) ?></td>
                <td><?= h($work->order->start_date . " ~ " . $work->order->end_date) ?></td>
                <td><?php
                if(!empty($work->order->client)){
                    echo $work->order->client->name;
                }
                 ?></td>
                <td><?php
                if(!empty($work->order->work_place)){
                    echo $work->order->work_place->name;
                }
                 ?></td>
                <td><?php
                if(!empty($work->order->work_content_id)){
                    echo $workContents[$work->order->work_content_id];
                }
                 ?></td> 
                <td><?= h($work->order->capturing_region->name . " " . $work->order->film_size->name)
                 ?> </td>
                <td><?php
                $equipments = [];
                $index = ['A','B','C','D','E'];
                for ($i=1; $i <= 5; $i++) {
                    $equipmenti =  'equipment'.$i;
                    if($work->has($equipmenti)){
                        $equipments[] = $work->$equipmenti->equipment_type->name . $work->$equipmenti->equipment_no . "号";
                    }                    
                    
                }
            
                //$equipments = [$work->equipmentA->name,$work->equipmentB->name,$work->equipmentC->name,$work->equipmentD->name,$work->equipmentE->name];
                echo h(implode(" , ", $equipments)); ?></td>  
                <td><?php
                $staffs = [];
                for ($i=1; $i < 11; $i++) {
                    $staffi = "staff" .$i; 
                    if($work->has($staffi)){
                        $staffs[] = $work->$staffi->name;
                    }                    
                    
                }
                echo h(implode(" , ", $staffs)); ?></td>    
                <td><?php
                $technician = [];
                for ($i=1; $i < 11; $i++) {
                    $techniciani = "technician" . $i; 
                    if($work->has($techniciani)){
                        $technician[] = $work->$techniciani->name;
                    }
                    
                    
                }
                echo h(implode(" , ", $technician)); ?></td>                                                
                <td><?php
                    echo $this->Form->input('done_' . $work->id,[
                    'options' =>['0' => '未完了','1' => '完了'],
                    //'empty' => '--',
                    'class' => 'done',
                    'label' => false,
                'value' => $work->done
                    ]);
                 ?></td>                


                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $work->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $work->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>         
          
      </tbody>      
      
  </table>
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

    <div class="modal fade" id="modal-alert"  tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <p id="modal-message"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

</section>