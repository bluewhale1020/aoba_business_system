<?php
$this->Html->css([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  'fullcalendar',
  'calendar_style'
],
['block' => 'css']);

$this->Html->script([
  'fullcalendar.min',
  'ja',
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',  
  'Chart.min.js',  
  // 'AdminLTE./bower_components/chart.js/Chart.js',  
  'custom_chart.js',
  'todo.js'
],
['block' => 'script']);
?>
<script type="text/javascript">

const currency_fmt =　new Intl.NumberFormat('ja', {
  style: 'currency',
  currency: 'JPY',
  currencyDisplay: 'name',// code   symbol
});
const per_fmt = new Intl.NumberFormat('ja', {
  style: 'percent',
  minimumFractionDigits: 0,
  maximumFractionDigits: 0,
});

var event_url = "/aoba_business_system/Works/view/";

const csrf = <?= json_encode($this->request->getParam('_csrfToken')); ?>;

$(document).ready(function(){

   // ロケールを設定
   moment.locale('ja');

   var picker_option = {
        format:'YYYY/MM/DD',
        singleDatePicker: true,
        autoUpdateInput:false,
        showDropdowns: true,
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
$('#due-date').daterangepicker(picker_option, (start, end, label)=> {
  $("#due-date").val(start.format('YYYY/MM/DD')).trigger('change');
});


  $("#sales_stat_btn").on('click',function () {
    loadsalesdata();
  });

  loadsalesdata();
  loadList();

  $('#calendar').fullCalendar({
    // ヘッダーのタイトルとボタン
    header: {
      left: 'today prev,next',
      center: 'title',
      right: 'month,timelineDay,listWeek'      
        // prevYear, nextYear
        // left: 'prev,next today',
        // center: 'title',
        // right: 'timelineDay,timelineThreeDays,agendaWeek,month,listWeek' //agendaDay
    },    
    height:700,
    // aspectRatio: 1.0,
    // timeFormat: 'HH:mm',
    displayEventTime:false,
    timezone: 'Asia/Tokyo', 
    events: function(start, end, timezone, callback) {
           // ***** ここでカレンダーデータ取得JSを呼ぶ *****
           setCalendarList(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), callback);
        },
    eventClick: function(calEvent, jsEvent, view) {
        // カレンダーに設定したイベントクリック時のイベント
        open( '<?php echo $this->Url->build(['controller'=>'Works', 'action'=>'view']); ?>/' + calEvent.id, "_blank" ) ;
        // open( event_url + calEvent.id, "_blank" ) ;

    },    
});


});

function loadsalesdata()
{
  start_year = $('[name="startdate\[year\]"]').val();
  start_mon = $('[name="startdate\[month\]"]').val();
  end_year = $('[name="enddate\[year\]"]').val();
  end_mon = $('[name="enddate\[month\]"]').val();

    var data = {
      start_year:start_year,
      start_mon:start_mon,
      end_year:end_year,
      end_mon:end_mon   
    };
    
    var Url = "/aoba_business_system/Dashboards/ajaxloadsalesdata";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:data,
        type:"POST",
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },
        success:function(data){
        // カンマ区切りテキストを解析して一致したデータを表示
        var parseData = eval("("+data+")");  
        //         alert(parseData); 
          // "[{"year":2019, "month":"10","sales":2500000}]"
          // ['chartdata'=>$data,'order_count'=>$order_count,'total_sales'=>$total_sales]
          drawSalesChart(parseData.chartdata);
          $("#sales_number").text( currency_fmt.format(parseData.total_sales.sales));
          $("#cost_number").text(currency_fmt.format(parseData.total_sales.cost));
          $("#gross_profit").text(currency_fmt.format(parseData.total_sales.sales - parseData.total_sales.cost));
          if(parseData.order_count.total != 0){
            $("#charted_rate").text(per_fmt.format(parseData.order_count.charged /parseData.order_count.total));
          }else{
            $("#charted_rate").text(per_fmt.format(0));
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


/**
 * 対象日付スケジュールデータセット処理
 * @param {type} startDate
 * @param {type} endDate
 * @param {type} callback
 * @returns {undefined}
 */
function setCalendarList(startDate, endDate, callback) {

  var Url = "/aoba_business_system/Dashboards/ajaxgetcalendarevents";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字  

  let postData = {startDate:startDate,endDate:endDate};

  $.ajax({
        url:Url,
        data:postData,
        type:"POST",
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },       
        success:function(data){
          // カンマ区切りテキストを解析して一致したデータを表示
          var parseData = eval("("+data+")");  
          //         alert(parseData); 
          var events = [];
          $.each(parseData, function(index, value) {
          events.push({
            // イベント情報をセット
            id: value['id'],
            title: value['title'],
            // description: value['description'],
            start: value['start'],
            end: value['end'],
            color: value['color'],
            // textColor: value['textColor']
          });  
        });
        
          // コールバック設定
          callback(events);
        },
        error:function(XHR, status, errorThrown){
            if(XHR.responseJSON.message != null){
                alert(XHR.responseJSON.message);
            }else{
                alert(status)
            }
            }
        
        });
 return;
}

</script>
<style>
	.todo-list{
	    max-height:550px;
	    overflow-y: scroll;
	}


</style>
<section class="content-header">
<div id="alert_div"></div>


<h1>
Dashboard
<small>システム上の各種データの集計・管理を行います</small>
</h1>
</section>
<section class="content voffset4">
  <!-- インフォボックス -->
  <div class="row">
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?=$stat['order_count']  ?></h3>

          <p>今月受注数</p>
        </div>
        <div class="icon">
        <i class="fa fa-shopping-cart"></i>
        </div>
        <a href="<?php echo $this->Url->build(['controller'=>'orders', 'action'=>'index']); ?>" class="small-box-footer" target="_blank">
        注文ページへ　<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$stat['ongoing_count']  ?></h3>

          <p>作業実施中</p>
        </div>
        <div class="icon">
          <i class="ion ion-briefcase"></i>
        </div>
        <a href="<?php echo $this->Url->build(['controller'=>'works', 'action'=>'index']); ?>" class="small-box-footer" target="_blank">
        作業ページへ　<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?=$stat['not_charged_count']  ?></h3>

          <p>作業完了未請求</p>
        </div>
        <div class="icon">
          <i class="ion ion-card"></i>
        </div>
        <a href="<?php echo $this->Url->build(['controller'=>'AccountReceivables', 'action'=>'index']); ?>" class="small-box-footer" target="_blank">
        売掛金管理ページへ　<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>

    <!-- 受注業務一覧 -->
  <div class="row">
    <div class="col-md-12">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">受注業務一覧表</h3>
          <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">

        
        <div class="order-table">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                  <tr class="bg-primary">
                      <th ><?= __('受注No') ?></th>
                      <th ><?= __('状況') ?></th>
                      <th ><?= __('実施期間') ?></th>
                      <th ><?= __('請負元') ?></th>
                      <th ><?= __('派遣先') ?></th>
                      <th ><?= __('業務内容') ?></th>
                      <th ><?= __('合計金額') ?></th>
                      <th  class="actions"><?= __('操作') ?></th>
                  </tr>         
            </thead>
            <tbody>
                  <?php foreach ($orders as $order): ?>
                  <tr>
                      <td><?= h($order->order_no) ?></td>
                      <td><?php
                      if($order->temporary_registration){
                          echo '<span class="label label-primary">仮登録</span>';
                      }elseif(empty($order->works[0]->done)){
                          echo '<span class="label label-success">作業待ち</span>';
                      }elseif(empty($order->is_charged)){
                          echo '<span class="label label-danger">請求待ち</span>';
                      }
                      ?></td>
                      <td><?= h($order->start_date . " ~ " . $order->end_date) ?></td>
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
                      <td><?php
                      $total = $order->guaranty_charge +
                      $order->additional_count * $order->additional_unit_price;                
                      echo $total; ?> </td>
                      <td class="actions text-center">

                        <?php
                          if($order->temporary_registration){
                              echo $this->Html->link(__('受注'), ['controller'=>'orders','action' => 'view', $order->id],
                              ['class' => 'btn btn-primary','target'=>'_blank']);
                          }elseif(empty($order->works[0]->done)){
                              echo $this->Html->link(__('作業'), ['controller'=>'works','action' => 'view', $order->works[0]->id],
                              ['class' => 'btn btn-success','target'=>'_blank']);
                              echo '&nbsp;';
                              echo $this->Html->link(__('費用'), ['controller'=>'cost_managements','action' => 'view', $order->id],
                              ['class' => 'btn btn-warning','target'=>'_blank']);
                          }

                        ?>

                          <?php 
                              if($order->works[0]->done){
                                if($order->payment == '依頼元'){
                                  $payer_id = $order->client_id;
                                }else{
                                  $payer_id = $order->work_place_id;
                                }
                                
                                $targetDate =new \DateTime($order->end_date->format("Y-m-d"));
                                $year = $targetDate->format('Y');
                                $month = $targetDate->format('m');
                                echo $this->Form->create(null,['url' => ['controller' => 'account_receivables', 'action' => 'index'],
                                'target'=>'_blank']);

                                echo $this->Html->link(__('費用'), ['controller'=>'cost_managements','action' => 'view', $order->id],
                                ['class' => 'btn btn-warning','target'=>'_blank']);  
                                echo '&nbsp;';                              
                                  echo $this->Form->hidden('請求先', ['value' => $payer_id]);
                                  echo $this->Form->hidden('date.year', ['value' => $year]);
                                  echo $this->Form->hidden('date.month', ['value' => $month]);
                                  echo $this->Form->button('請求',['type'=>'submit','class' => 'btn btn-danger']);
                                  echo $this->Form->end();                        

                              }
                            ?>

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

  <div class="row">
        <!-- 作業カレンダー -->
        <div class="col-md-12">
            <div class="box box-success">
            <div class="box-header">
            <i class="ion ion-calendar"></i>
            <h3 class="box-title">作業スケジュール</h3>
            <div class="box-tools pull-right">
              <!-- Buttons, labels, and many other things can be placed here! -->
              <!-- Here is a label for example -->
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            </div><!-- /.box-tools -->             
            </div>
            <!-- /.box-header -->

                <div class="box-body">

              <!-- THE CALENDAR -->
                    <div id="calendar">        
                <!-- fullcalendar app -->
                    </div>
                </div>
            </div>
        </div>
  </div>

  <div class="row">
    <!-- todo list -->
    <div class="col-md-4">

      <div class="box box-warning">
        <div class="box-header ui-sortable-handle">
          <i class="ion ion-clipboard"></i>

          <h3 class="box-title">To Do List</h3>

          <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

          </div><!-- /.box-tools -->  
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
          <ul class="todo-list">


          </ul>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <button class="btn btn-default pull-right" data-toggle="modal" data-target="#myModalNorm"
          onclick="Javascript:resetForm('add');fillForm(null);" >
          <i class="fa fa-plus"></i>新規追加
          </button>

        </div>
      </div>
    </div>    
    <!-- 売上グラフ -->
    <div class="col-md-8">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">月別売上(税抜)データ</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <!-- <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </div> -->
            <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
            <?php
            echo $this->Form->create(null,[
            'url'=>['action' => 'index']
            ,'class' => 'form-inline'
            ]); ?>
          
            <fieldset>

            <?php
            //debug($this->request->data);
              // 日本語対応(YYYY年MM月DD日 HH時mm分)
            $this->Form->templates([
            'dateWidget' => '<ul class="list-inline"><li class="year">{{year}} 年</li>
            <li class="month"> {{month}} 月 </li></ul>']);

            echo $this->Form->input('startdate', array(
            'type' => 'date',
            'label' => false,
            'monthNames' => false,
            //'dateFormat' => 'YMD',
            // 'monthNames' => ['1月','2月','3月','4月','5月','6月',
            // '7月','8月','9月','10月','11月','12月'],
            //separator' => '/',
            'minYear' => date('Y')-10,
            'maxYear' => date('Y'),
             'default' => $year."-1-1",
            'year' => [
              // 'start' => 1960,
              // 'end' => 1998,
              // 'order' => 'desc',
              'class' => "form-control",
                ],
                'month' => ['class' => "form-control"],    
              ));  
        
          
          

            ?>&nbsp;&nbsp;～&nbsp;&nbsp;
            <?php
            echo $this->Form->input('enddate', array(
            'type' => 'date',
            'label' => false,
            'monthNames' => false,
            //'dateFormat' => 'YMD',
            // 'monthNames' => ['1月','2月','3月','4月','5月','6月',
            // '7月','8月','9月','10月','11月','12月'],
            //separator' => '/',
            'minYear' => date('Y')-10,
            'maxYear' => date('Y'),
            'default' => (new DateTime())->format("Y-m-d"),
            'year' => [
            // 'start' => 1960,
            // 'end' => 1998,
            // 'order' => 'desc',
            'class' => "form-control",
            ],
            'month' => ['class' => "form-control"],    
            ));  
            ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            echo $this->Form->button('検索',['id'=>'sales_stat_btn','class' => 'btn-primary','onclick'=>'Javascript:return false;']);
            ?>
            </fieldset>


              <?php echo $this->Form->end(); ?>  

              <p class="text-center">
                <strong></strong>
              </p>

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="sales-chart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <h5 class="description-header" id="sales_number"></h5>
                <span class="description-text">売上高</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <h5 class="description-header" id="cost_number"></h5>
                <span class="description-text">費用</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <h5 class="description-header" id="gross_profit"></h5>
                <span class="description-text">粗利</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block">
                <h5 class="description-header" id="charted_rate"></h5>
                <span class="description-text">請求済み</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>

</section>

<!-- Modal  Todo List Form -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
      <?= $this->Form->create(null,[
      'class' => 'form-horizontal'
      ]) ?>
          <!-- Modal Header -->
          <div class="modal-header">
              <button type="button" class="close" 
                  data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                      <span class="sr-only">Close</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">
                  ToDo リストフォーム
              </h4>
          </div>
          
          <!-- Modal Body -->
          <div class="modal-body">
            <!-- // id bigint(20) AI PK 
            // description 
            // due_date 
            // priority
            // done                 -->

              <?php
              echo $this->Form->input('id',[
              'type'=>"hidden"
              ]);

              echo $this->Form->input('description',[
                'label'=>"内容"
                ]);   
                echo $this->Form->input('due_date',[
                  'type' => 'text',
                  'label'=>"締め切り",
                  'append'=>'<i class="fa fa-calendar"></i>'
                  
                  ]);
                echo $this->Form->input('priority',[
                  'label'=>"優先度",
                  'empty' => '中',
                  'options' =>[
                  '2' => '低',
                  '5' => '中',
                  '8' => '高',
                  '10' => '緊急',
                  ]
                  ]);
                echo $this->Form->input('done',[
                  'label'=>"状況",
                  // 'empty' => '--',
                  'options' =>[
                  0 => '未完了',
                  1 => '完了'
                  ]
                  ]);   
                
                
              ?>                          
              
          </div>
          
          <!-- Modal Footer -->
          <div class="modal-footer voffset3">
              <button type="button" class="btn btn-default"
                      data-dismiss="modal">
                          キャンセル
              </button>
              <button type="button" class="btn btn-primary" onclick="Javascript:submitForm();">保存</button>                

          </div>
          <?= $this->Form->end() ?>          
      </div>
  </div>
</div>

<!-- item save result dialog -->
<div class="modal fade" id="modal-alert"  tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="modal-title"></h4>
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
