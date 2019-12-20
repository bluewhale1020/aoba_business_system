<?php
$this->Html->script([
  'Chart.min.js',  
  'custom_chart.js',
  // 'chartjs-plugin-labels.min.js',
],
['block' => 'script']);
?>
<script type="text/javascript">
const currency_fmt =　new Intl.NumberFormat('ja', {
  style: 'currency',
  currency: 'JPY',
  currencyDisplay: 'name',// code   symbol
});


$(document).ready(function(){

  $("#sales_stat_btn").on('click',function () {
    loadsalesanalysis();
  });

  loadsalesanalysis();


});

function loadsalesanalysis()
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
  
  var Url = "/aoba_business_system/Statistics/ajaxgetsalesanalysis";
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
        // "[{"year":2019, "month":"10","rowdata":[0,0]}]"
        // ['sales_profit'=>$sales_profit,
        //   'order_count'=>$order_count,
        //   'order_count_filmsizes'=>$order_count_filmsizes,
        //   'sales_profit_partners'=>$sales_profit_partners,
        //   'sales_profit_workcontents'=>$sales_profit_workcontents,]
        drawSalesProfitChart(parseData.sales_profit);
        drawOrderCountChart(parseData.order_count);
        drawOrderCountFilmsizesChart(parseData.order_count_filmsizes);
        drawSalesProfitPartnersChart(parseData.sales_profit_partners);
        drawSalesProfitWorkcontentsChart(parseData.sales_profit_workcontents);

        createStatTables(parseData.sales_profit_partners,"sales-profit-partners-table");
        createStatTables(parseData.sales_profit_workcontents,"sales-profit-workcontents-table");
      
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

function createStatTables(data, elem){
  tbody_html = '';
　
  if(data == null){
    return;
  }

  for(const row of data){
    row_html = '<tr>';
    //{name: "company", rowdata: [2, 0]}
    //行名
    row_html += '<th scope="row" class="warning">'+ row.name +'</th>';
    //売上高データ
    row_html += '<td>' + currency_fmt.format(row.rowdata[0]) + '</td>';
    //粗利率データ
    row_html += '<td>' + row.rowdata[1] + '%</td>';


    row_html += '</tr>';
    
    tbody_html += row_html;
  }


  $("#" + elem + " tbody").html(tbody_html);
}


function printSalesAnalysisData(){
  
  //検索条件取得
  const params = jQuery.param({
    start_year: $('[name="startdate\[year\]"]').val(),
    start_mon: $('[name="startdate\[month\]"]').val(),
    end_year: $('[name="enddate\[year\]"]').val(),
    end_mon: $('[name="enddate\[month\]"]').val()
  });
  

   var Url = "/aoba_business_system/printers/print_sales_analysis_data?" + params;
   //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
  
  
   location.href= Url;
  
}


</script>
<style>
</style>
<section class="content-header">
<div id="alert_div"></div>
<h1>
売上分析
<small>売上・粗利率・受注数等の統計データを集計します</small>
</h1>
</section>
<section class="content voffset4">
<div class="row">
  <div class="col-md-12">
  <div class="col-md-5">
  <div class="box box-solid text-center box-primary">
        <div class="box-body bg-info">

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
          echo $this->Form->button('検索',['id'=>'sales_stat_btn','class' => 'btn-primary','onclick'=>'Javascript:return false;']);
          ?>
          </fieldset>


          <?php echo $this->Form->end(); ?>  

        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>

    <div class="pull-right">
      <?php 

      echo $this->Form->button(' 統計データ出力', array(
      'type' => 'button',
      'div' => false,
      'class' => 'btn btn-warning',
      'onclick' =>"Javascript:printSalesAnalysisData();return false;"
      ));     ?>
    </div>


  </div>
</div>



<div class="row">
    <!-- 売上・粗利率グラフ -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">月別売上・粗利率</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
           </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">

            <div class="row voffset5">
              <div class="col col-md-12">            
                <div class="chart">
                  <!-- opNum Chart Canvas -->
                  <canvas id="sales-profit-chart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
                </div>
                <!-- /.chart-responsive -->
              </div>
            </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </div>
        <!-- ./box-body -->
        <div class="box-footer">


        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <!-- 月別受注数グラフ -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">月別受注数</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="order-count-chart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <!-- フィルムサイズ別受注数グラフ -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">フィルムサイズ別受注数</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="order-count-filmsizes-chart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <!-- 顧客別売上・粗利率グラフ -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">顧客別売上・粗利率 （ 上位5社 ）</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col col-md-12">
              <div class="data-table"> 
                <table id="sales-profit-partners-table" class="table table-bordered text-center">
                  <thead >
                  <tr class="warning">
                    <th>顧客名称</th>
                      <th>売上高</th>
                      <th>粗利率</th>
                  </tr>                 
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>      
          <div class="row voffset3">
            <div class="col col-md-12">

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="sales-profit-partners-chart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>

    <!-- 業務別売上・粗利率グラフ -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">業務別売上・粗利率</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col col-md-12">
              <div class="data-table"> 
                <table id="sales-profit-workcontents-table" class="table table-bordered text-center">
                  <thead >
                  <tr class="warning">
                      <th>業務内容</th>
                      <th>売上高</th>
                      <th>粗利率</th>
                  </tr>                 
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>      
          <div class="row voffset3">
            <div class="col col-md-12">

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="sales-profit-workcontents-chart" style="height: 400px; width: 791px;" width="791" height="400"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>

</div>
</section>
