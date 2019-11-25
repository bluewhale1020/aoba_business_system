$(function () {

    'use strict';

  $("#change-type").on('change',function(){
    changeChartType($(this).val());
  });
    
});

function removeData(chart) {
  // chart.data.labels.pop();
  chart.data.datasets.forEach((dataset) => {
      dataset.data.pop();
  });
  chart.update();
}

function changeChartType(chart_type){

  if(chart_type == 'bar-stacked'){
    window.opNumChartOptions.scales.yAxes[0].stacked = true;
    window.opNumChartOptions.scales.xAxes[0].stacked = true;
    chart_type = 'bar';
  }else if (chart_type == 'bar'){
    window.opNumChartOptions.scales.yAxes[0].stacked = false;
    window.opNumChartOptions.scales.xAxes[0].stacked = false;
  }else if (chart_type == 'line'){
    window.opNumChartOptions.scales.yAxes[0].stacked = true;
  }


  // Get context with jQuery - using jQuery's .get() method.
  var opNumChartChartCanvas = $('#opNumChart').get(0).getContext('2d'); 

  window.opnumChart.destroy();

  // Create the chart
  window.opnumChart = new Chart(opNumChartChartCanvas, {
    type: chart_type,
    data: window.opNumChartData,
    options: window.opNumChartOptions
  }); 
}

  // _opnum_data : "[{"year":2019, "month":"10","counts":[0,0,0,0,0,0,0,0,0,0]}]"
  function drawOpNumChart(_opnum_data){
    cat_labels = ['可搬 １００㎜','可搬 ＤＲ','可搬 大角','Ｂレ車 １００㎜','Ｂレ車 ＤＲ',
    'Ｂレ車 大角','Ｍレ車 １００㎜','Ｍレ車 ＤＲ','Ｍレ車 四ッ切','Ｐ ＤＲ'];
    color_pattern = [
      '#1F78B4','#A6CEE3','#4575B4','#33A02C','#B2DF8A','#35978F','#FF7F00','#FDBF6F','#A63603','#E78AC3'
    ]
      labels = [];
      categories = [];
      data_for_eachset = [[],[],[],[],[],[],[],[],[],[]];
    //labelsと値の取り出し
    _opnum_data.forEach((item) => {
      labels.push(item.month + '月');
      item.counts.forEach((count,index) => {
        data_for_eachset[index].push(count);
      });

    });
    data_for_eachset.forEach((data,index)=>{
      categories.push({
        label: cat_labels[index],
        data: data,
        backgroundColor:color_pattern[index],
        // backgroundColor:'rgb(253, 191, 111, 0.5)',
        borderColor:color_pattern[index],
        // borderColor:'rgb(255, 127, 0, 1)',
        // borderWidth: 1
      });
    });

    
        // -----------------------
        // - MONTHLY Operation Number CHART -
        // -----------------------
      
        // Get context with jQuery - using jQuery's .get() method.
        var opNumChartChartCanvas = $('#opNumChart').get(0).getContext('2d');

      
        window.opNumChartData = {
          labels: labels,
          datasets: categories
        };
      
      
    //clear data
    if(typeof window.opnumChart != 'undefined'){
      removeData(window.opnumChart);
      window.opnumChart.data = opNumChartData;
      window.opnumChart.update();
    }else{

      window.opNumChartOptions = {
        // plugins: {
        //   colorschemes: {      
        //     scheme: 'tableau.Tableau20'//'brewer.Paired12'      
        //   }      
        // },
        // elements: {
        //   line: {
        //       tension: 0 // disables bezier curves
        //   }
        // },          
        responsive: true,                  //グラフ自動設定
        legend: {                          //凡例設定
            display: true,                 //表示設定
            position: 'right',
            reverse: true
       },
        title: {                           //タイトル設定
            display: true,                 //表示設定
            fontSize: 18,                  //フォントサイズ
            text: '月別稼働数グラフ'                //ラベル
        },
        scales: {                          //軸設定
            yAxes: [{                      //y軸設定
                display: true,             //表示設定
                stacked: true,                  
                scaleLabel: {              //軸ラベル設定
                   display: true,          //表示設定
                   labelString: '稼働数',  //ラベル
                   fontSize: 18               //フォントサイズ
                },
                ticks: {                      //ticks設定
                  beginAtZero: true,
                  callback: function(value) {if (value % 1 === 0) {return value;}},               
                    fontSize: 15,             //フォントサイズ
                    // stepSize: 10              //軸間隔
                },
            }],
            xAxes: [{                         //x軸設定
                display: true,                //表示設定
                stacked: true,                  
                barPercentage: 0.6,           //棒グラフ幅
                categoryPercentage: 1,      //棒グラフ幅
                scaleLabel: {                 //軸ラベル設定
                   display: true,             //表示設定
                   labelString: '期間',  //ラベル
                   fontSize: 18               //フォントサイズ
                },
                ticks: {
                    fontSize: 15             //フォントサイズ
                },
            }],
        },
        layout: {                             //レイアウト
            padding: {                          //余白設定
                left: 20,
                right: 50,
                top: 0,
                bottom: 0
            }
        }    
      };


      // Create the chart
      window.opnumChart = new Chart(opNumChartChartCanvas, {
        type: 'line',
        data: opNumChartData,
        options: opNumChartOptions
      });  

    }

  

      
        // ---------------------------
        // - END MONTHLY Operation Number CHART -
        // ---------------------------
    
    }


function drawSalesChart(_sales_data){
// "[{"month":"10","sales":2500000}]"
  labels = [];
  data = [];
//labelsと値の取り出し
for(const item of _sales_data){
  labels.push(item.month + '月');
  data.push(item.sales);

}


    // -----------------------
    // - MONTHLY SALES CHART -
    // -----------------------
  
    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#sales-chart').get(0).getContext('2d');

  
    var salesChartData = {
      labels: labels,
      datasets: [{
          label: '月売上高',
          data: data,
          backgroundColor:'rgb(253, 191, 111, 0.5)',
          borderColor:'rgb(255, 127, 0, 1)',
          borderWidth: 1
      }]
    };
  


    //clear data
    if(typeof window.salesChart != 'undefined'){
      removeData(window.salesChart);
      window.salesChart.data = salesChartData;
      window.salesChart.update();
    }else{


      var salesChartOptions = {
        responsive: true,                  //グラフ自動設定
        legend: {                          //凡例設定
            display: false                 //表示設定
       },
        title: {                           //タイトル設定
            display: true,                 //表示設定
            fontSize: 18,                  //フォントサイズ
            text: '月別売上高グラフ'                //ラベル
        },
        scales: {                          //軸設定
            yAxes: [{                      //y軸設定
                display: true,             //表示設定
                scaleLabel: {              //軸ラベル設定
                   display: true,          //表示設定
                   labelString: '売上高',  //ラベル
                   fontSize: 18               //フォントサイズ
                },
                ticks: {                      //最大値最小値設定
                    userCallback: function(item) {
                      return parseInt(item / 10000) + '万';
                    },                
                    min: 0,                   //最小値
                    // max: 5000000,                  //最大値
                    fontSize: 15,             //フォントサイズ
                    // stepSize: 1000000              //軸間隔
                },
            }],
            xAxes: [{                         //x軸設定
                display: true,                //表示設定
                barPercentage: 0.6,           //棒グラフ幅
                categoryPercentage: 1,      //棒グラフ幅
                scaleLabel: {                 //軸ラベル設定
                   display: true,             //表示設定
                   labelString: '期間',  //ラベル
                   fontSize: 18               //フォントサイズ
                },
                ticks: {
                    fontSize: 15             //フォントサイズ
                },
            }],
        },
        layout: {                             //レイアウト
            padding: {                          //余白設定
                left: 20,
                right: 50,
                top: 0,
                bottom: 0
            }
        }    
      };




      // Create the Bar chart
      window.salesChart = new Chart(salesChartCanvas, {
        type: 'bar',
        data: salesChartData,
        options: salesChartOptions
      });    

    }
   

  
    // ---------------------------
    // - END MONTHLY SALES CHART -
    // ---------------------------

}