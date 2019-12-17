<?php
$this->Html->script([
  'Chart.min.js',  
  'custom_chart.js',
],
['block' => 'script']);
?>
<script type="text/javascript">


$(document).ready(function(){

  $("#ops_stat_btn").on('click',function () {
    loadoperationdata();
  });

  loadoperationdata();


});

function loadoperationdata()
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
  
  var Url = "/aoba_business_system/Statistics/ajaxloadoperationnumbers";
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
        // "[{"year":2019, "month":"10","counts":[0,0,0,0,0,0,0,0,0,0]}]"
        // ['chartdata'=>$data]
        drawOpNumChart(parseData.chartdata);

        createOpNumTable(parseData.chartdata);
      
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

function createOpNumTable(data){

  tbody_html = '';

  for(const row of data){
    row_html = '<tr>';
    //{year: 2019, month: 10, counts: [2, 0, 2, 0, 0, 2, 0, 0, 1, 0]}
    //年月
    row_html += '<th scope="row" class="warning">'+ row.year + '年 ' + row.month +'月</th>';
    //稼働数データ
    for(const count of row.counts){
      row_html += '<td>' + count + '</td>';
    }

    row_html += '</tr>';
    
    tbody_html += row_html;
  }


  $("#opnum-table tbody").html(tbody_html);

}

function print_opnum_table(){
  
  //検索条件取得
  const params = jQuery.param({
    start_year: $('[name="startdate\[year\]"]').val(),
    start_mon: $('[name="startdate\[month\]"]').val(),
    end_year: $('[name="enddate\[year\]"]').val(),
    end_mon: $('[name="enddate\[month\]"]').val()
  });
  

   var Url = "/aoba_business_system/printers/print_opnum_table?" + params;
   //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
  
  
   location.href= Url;
  
}


</script>
<style>
</style>
<section class="content-header">
<div id="alert_div"></div>
<h1>
統計資料
<small>受注データから必要な統計データを集計します</small>
</h1>
</section>
<section class="content voffset4">
<div class="row">
    <!-- 稼働数グラフ -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">月別装置・フィルムサイズ稼働件数</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
           </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">

              <div class="row">
                <div class="col-md-10">

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
                  'default' => $year.'-1-1',
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
                  echo $this->Form->button('検索',['id'=>'ops_stat_btn','class' => 'btn-primary','onclick'=>'Javascript:return false;']);
                  ?>
                  </fieldset>


                  <?php echo $this->Form->end(); ?>  
                  </div><div class="col-md-2">
                  <div class="pull-right">
                    <?php 

                    echo $this->Form->button(' 稼働件数出力', array(
                    'type' => 'button',
                    'div' => false,
                    'class' => 'btn btn-warning',
                    'onclick' =>"Javascript:print_opnum_table();return false;"
                    ));     ?>
                  </div>

                </div>
              </div>

            <div class="row voffset5">
              <div class="col col-md-12">
                <div class="data-table"> 
                  <table id="opnum-table" class="table table-bordered text-center">
                    <thead >
                    <tr class="warning">
                        <th rowspan="2"></th>
                        <th colspan="3">可搬</th>
                        <th colspan="3">Ｂレ車</th>
                        <th colspan="3">Ｍレ車</th>
                        <th>Ｐ</th>
                    </tr>
                    <tr class="warning">
                        <th>１００㎜</th>
                        <th>ＤＲ</th>
                        <th>大角</th>
                        <th>１００㎜</th>
                        <th>ＤＲ</th>
                        <th>大角</th>
                        <th>１００㎜</th>
                        <th>ＤＲ</th>
                        <th>四ッ切</th>
                        <th>ＤＲ</th>
                    </tr>                 
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row voffset5">
              <div class="col col-md-12">            
                <div class="chart">
                  <!-- opNum Chart Canvas -->
                  <canvas id="opNumChart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
                </div>
                <!-- /.chart-responsive -->
              </div>
            </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col col-md-2 pull-right">
                <div class="form-group">
                  <div class="input select">
                    <select name="change_type" id="change-type" class="form-control">
                      <option value="line">積層ライングラフ</option>
                      <option value="bar-stacked">積層棒グラフ</option>
                      <option value="bar">棒グラフ</option>
                    </select>
                  </div>
              </div>
            </div>
          
          </div>

        </div>
        <!-- ./box-body -->
        <div class="box-footer">


        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</section>
