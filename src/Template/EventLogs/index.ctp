<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker'
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  'non-ajax-post'
],
['block' => 'script']);
?>
<script type="text/javascript">
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


});

function printLogData (){ 
   var data = get_form_data();

   var Url = "/aoba_business_system/Printers/printLogData";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字

  jqueryPost(Url, "Post", data);

}

function get_form_data()
{
  var form = $("#search_form");
  var data = {};
  form.find('input').each(function(idx,elem){
    if(elem.getAttribute("name") != "_method"){
        data[elem.getAttribute("name")] = elem.getAttribute("value");

    }
  });

  return data;
}


</script>


<section class="content-header">
<h1>
イベントログ
<small>ユーザーのデータ処理を記録したログを一覧で表示します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">ログ一覧</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">

<div class="col-md-12">
<div class="pull-right">
<?php
echo $this->Form->button(' ログを出力',[
  'onclick'=>'Javascript:printLogData();return false;',
    'class' => 'btn btn-warning glyphicon glyphicon-print'
]);

?>
</div>
</div>


  <div class="col-md-8 pull-right voffset2">   
 <div class="box box-solid text-right bg-gray">
  <div class="box-body">
 <div >
   <?php
    echo $this->Form->create(null,[
    'url'=>['action' => 'index']
    ,'class' => 'form-inline','id'=>'search_form'
  ]); ?>
  
  <fieldset>

  <?php
  echo $this->Form->input('アクション',[
    'options'=> [
      'insert'=>'データの新規登録',
      'update'=>'データの更新',
      'delete'=>'データの削除',
      'login'=>'ログイン',
      'logout'=>'ログアウト'
    ],
     'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('ユーザー',[
    'options'=> $users, 'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php 

  echo $this->Form->input('start_date',[
  'type' => 'hidden']);       
  echo $this->Form->input('end_date',[
  'type' => 'hidden']);             
 echo $this->Form->input('date_range',[
 'label' => '期間',
  'append'=>'<i class="fa fa-calendar"></i>']);

?>&nbsp;&nbsp;&nbsp;&nbsp;


  <?php
  echo $this->Form->button('検索',['class' => 'btn-primary']);
  ?>
  </fieldset>


  <?php echo $this->Form->end(); ?>  
 
</div> 
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div> 
   
  <div class="eventlog-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-navy disabled">
                <th ><?= __('id') ?></th>
                <th ><?= __('作成日') ?></th>
                <th ><?= __('イベント') ?></th>
                <th ><?= __('テーブル名') ?></th>
                <th ><?= __('レコードID') ?></th>
                <th ><?= __('ユーザー名') ?></th>
                <th ><?= __('IPアドレス') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php foreach ($eventLogs as $eventLog): ?>
            <tr>
                <td><?= $this->Number->format($eventLog->id) ?></td>
                <td><?= h($eventLog->created) ?></td>
                <td><?= h($eventLog->event) ?></td>
                <td><?= h($eventLog->table_name) ?></td>
                <td>
                    <?php 
                    
                    if (in_array($eventLog->action_type,['login','logout'])) {         

                    }else if($eventLog->event != "delete"){
                        echo $this->Html->link($eventLog->record_id,[
                          'controller'=>$eventLog->table_name, 'action' => 'view',$eventLog->record_id
                      ]);                        
                    }else{
                        echo $eventLog->record_id;
                    }
                ?></td>
                <td>
                    <?php 
                        echo $this->Html->link($eventLog->user->username,[
                          'controller'=>'users', 'action' => 'view',$eventLog->user_id
                      ]);             
                    ?>
                </td>
                <td><?= h($eventLog->remote_addr) ?></td>
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
