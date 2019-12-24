$(function () {

    'use strict';

  $("#change-type").on('change',function(){
    changeChartType($(this).val());
  });
    
});

var defaultChartOptions = {
  responsive: true,                  //グラフ自動設定
  legend: {                          //凡例設定
      display: false                 //表示設定
 },
  title: {                           //タイトル設定
      display: true,                 //表示設定
      fontSize: 18,                  //フォントサイズ
      text: 'グラフ'                //ラベル
  },
  scales: {                          //軸設定
      yAxes: [{                      //y軸設定
          display: true,             //表示設定
          scaleLabel: {              //軸ラベル設定
             display: true,          //表示設定
             labelString: 'YLabel',  //ラベル
             fontSize: 18               //フォントサイズ
          },
        //   ticks: {                      //最大値最小値設定              
        //     min: 0,                   //最小値
        //     beginAtZero: true,   // minimum value will be 0.
        //     scaleBeginAtZero: true,            
        //     // max: 5000000,                  //最大値
        //     fontSize: 15,             //フォントサイズ
        //     // stepSize: 1000000              //軸間隔
        // },
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
  },
     
};


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

function createChart(chart_type,canvas,chart_data,chart_options){
  return new Chart(canvas, {
    type: chart_type,
    data: chart_data,
    options: chart_options
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
      
        // Get context with jQuery - using jQuery's .get() method.
        var canvas = $('#opNumChart').get(0).getContext('2d');

      
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

      options = {
        legend: {                          //凡例設定
            display: true,                 //表示設定
            position: 'right',
            reverse: true
       },
        title: {                           //タイトル設定
            text: '月別稼働数グラフ'                //ラベル
        },
        scales: {                          //軸設定
            yAxes: [{                      //y軸設定
                stacked: true,                  
                scaleLabel: {              //軸ラベル設定
                   labelString: '稼働数',  //ラベル
                },
                ticks: {                      //ticks設定
                  beginAtZero: true,
                  callback: function(value) {if (value % 1 === 0) {return value;}},               
                },
            }],
            xAxes: [{                         //x軸設定
                stacked: true,                  
                categoryPercentage: 1,      //棒グラフ幅
            }],
        },    
      };

      window.opNumChartOptions = Object.assign({}, defaultChartOptions,options);


      // Create the chart
      window.opnumChart = createChart('line',canvas,opNumChartData,window.opNumChartOptions);

    }
    
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
  
    // Get context with jQuery - using jQuery's .get() method.
    var canvas = $('#sales-chart').get(0).getContext('2d');

  
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

      var options = {
        title: {                           //タイトル設定
            text: '月別売上高グラフ'                //ラベル
        },
        scales: {                          //軸設定
            yAxes: [{                      //y軸設定
                scaleLabel: {              //軸ラベル設定
                   labelString: '売上高',  //ラベル
                },
                ticks: {                      //最大値最小値設定
                    userCallback: function(item) {
                      return parseInt(item / 10000) + '万';
                    },                
                },
            }],
            xAxes: [{                         //x軸設定
                scaleLabel: {                 //軸ラベル設定
                   labelString: '期間',  //ラベル
                },
            }],
        },    
      };      

      options = Object.assign({}, defaultChartOptions,options);





      // Create the Bar chart
      window.salesChart = createChart('bar',canvas,salesChartData,options);

    }

}

//売上・粗利率グラフ
function drawSalesProfitChart(_sales_data){
  // "[{"month":"10","rowdata":[0,0]}]"
    labels = [];
    data = [];line_data = [];
  //labelsと値の取り出し
  for(const item of _sales_data){
    labels.push(item.month + '月');
    data.push(item.rowdata[0]);
    line_data.push(roundAtBase(item.rowdata[1], 100) );
  
  }
    
      // Get context with jQuery - using jQuery's .get() method.
      var canvas = $('#sales-profit-chart').get(0).getContext('2d');
  
    
      var salesProfitChartData = {
        labels: labels,
        datasets: [{
            type: 'bar',  
            label: '月売上高',
            data: data,
            backgroundColor:'rgb(253, 191, 111, 0.5)',
            borderColor:'rgb(255, 127, 0, 1)',
            borderWidth: 1,
            yAxisID: "y-axis-1",            
        },
        {
          type: 'line',   
          label: '粗利率',
          data: line_data,
          borderColor : "rgba(254,97,132,0.8)",
          pointBackgroundColor : "rgba(254,97,132,0.8)", 
          fill: false,        
          yAxisID: "y-axis-2",          
      },      
      ]
      };

    //clear data
    if(typeof window.salesProfitChart != 'undefined'){
      removeData(window.salesProfitChart);
      window.salesProfitChart.data = salesProfitChartData;
      window.salesProfitChart.update();
    }else{      
        var options = {
          title: {                           //タイトル設定
              text: '月別売上高・粗利率グラフ'                //ラベル
          },
          legend: {                          //凡例設定
            display: true,                 //表示設定
            position: 'top',
          },          
          scales: {                          //軸設定
              yAxes: [
                {                      //y軸設定
                  id: "y-axis-1",  
                  position: "left", 
                  type: "linear",                                                  
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
                      min: 0,                                      
                  },
                },
                {
                  id: "y-axis-2",                
                  type: "linear", 
                  position: "right",
                  scaleLabel: {              //軸ラベル設定
                    display: true,          //表示設定
                    labelString: '粗利率',  //ラベル
                    fontSize: 18               //フォントサイズ
                 },                  
                  ticks: {
                    userCallback: function(item) {
                      return parseInt(item) + '%';
                    },                      
                      max: 100,
                      min: 0,
                      stepSize: 15
                  },
                  gridLines: { // このオプションを追加
                    drawOnChartArea: false, 
                  },                  
              }                
              ],
          },   
        };      
  
        options = Object.assign({}, defaultChartOptions,options);  
  
        // Create the Bar chart
        window.salesProfitChart = createChart('bar',canvas,salesProfitChartData,options);    
  
      }
  
  }

  // 受注数グラフ
  function drawOrderCountChart(_order_data){
    // "[{"month":"10","rowdata":0}]"
    labels = [];
    data = [];
    //labelsと値の取り出し
    for(const item of _order_data){
      labels.push(item.month + '月');
      data.push(item.rowdata);
  
    }
    
      // Get context with jQuery - using jQuery's .get() method.
      var canvas = $('#order-count-chart').get(0).getContext('2d');
  
    
      var OrderCountChartData = {
        labels: labels,
        datasets: [{
            label: '月別受注数',
            data: data,
            backgroundColor:'rgba(54, 162, 235, 0.5)',// 'rgb(253, 191, 111, 0.5)',
            borderColor:'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
      };

      //clear data
      if(typeof window.OrderCountChart != 'undefined'){
        removeData(window.OrderCountChart);
        window.OrderCountChart.data = OrderCountChartData;
        window.OrderCountChart.update();
      }else{
  
        var options = {
          title: {                           //タイトル設定
              text: '月別受注数グラフ'                //ラベル
          },
          scales: {                          //軸設定
              yAxes: [{                      //y軸設定
                  scaleLabel: {              //軸ラベル設定
                    display:true,
                    labelString: '受注数',  //ラベル
                  }, 
                  ticks:{
                    min: 0,                     
                  }              
              }],
              xAxes: [{                         //x軸設定
                  scaleLabel: {                 //軸ラベル設定
                     labelString: '期間',  //ラベル
                  },
              }],
          },    
        };      
  
        options = Object.assign({}, defaultChartOptions,options);
  
        // Create the Bar chart
        window.OrderCountChart = createChart('bar',canvas,OrderCountChartData,options);
  
      }
  
  }  

  // フィルムサイズ別受注数
  function drawOrderCountFilmsizesChart(_order_data){
    // "[{"count":10,"name":"大角"}]"
    labels = [];
    data = [];
    //labelsと値の取り出し
    for(const item of _order_data){
      labels.push(item.name);
      data.push(item.rowdata);
  
    }
    
      // Get context with jQuery - using jQuery's .get() method.
      var canvas = $('#order-count-filmsizes-chart').get(0).getContext('2d');
  
    
      var OrderCountChartFilmsizesData = {
        labels: labels,
        datasets: [{
            label: 'フィルムサイズ別受注数',
            data: data,
            backgroundColor:[
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
          ],
          //   borderColor:[
          //     'rgba(255, 99, 132, 1)',
          //     'rgba(54, 162, 235, 1)',
          //     'rgba(255, 206, 86, 1)',
          //     'rgba(75, 192, 192, 1)',
          //     'rgba(153, 102, 255, 1)',
          //     'rgba(255, 159, 64, 1)'
          // ],
            borderWidth: 1
        }]
      };

      //clear data
      if(typeof window.OrderCountChartFilmsizesChart != 'undefined'){
        removeData(window.OrderCountChartFilmsizesChart);
        window.OrderCountChartFilmsizesChart.data = OrderCountChartFilmsizesData;
        window.OrderCountChartFilmsizesChart.update();
      }else{
  
        var options = {
          title: {                           //タイトル設定
              text: 'フィルムサイズ別受注数グラフ'                //ラベル
          },
          legend: {                          //凡例設定
            display: true,                 //表示設定
            position: 'top',
          },          
          scales: {                          //軸設定
              yAxes: [{                      //y軸設定
                display: false,             //表示設定                                 
              }],
              xAxes: [{                         //x軸設定
                display: false,             //表示設定
              }],
          },             
        };      
  
        options = Object.assign({}, defaultChartOptions,options);
  
        // Create the doughnut chart
        window.OrderCountChartFilmsizesChart = createChart('doughnut',canvas,OrderCountChartFilmsizesData,options);
  
      }
  }
  // 顧客別売上・粗利率
  function drawSalesProfitPartnersChart(_sales_data){
    // "[{"name":"company","rowdata":[0,0]}]"
    labels = [];
    data = [];line_data = [];
    //labelsと値の取り出し
    Object.keys(_sales_data).forEach(function(key){
      let short_name = shortenCorporateName(_sales_data[key].name);
      labels.push(short_name);
      data.push(_sales_data[key].rowdata[0]);
      fmt_number = roundAtBase(_sales_data[key].rowdata[1], 100);
      line_data.push(fmt_number); 
      _sales_data[key].name = short_name;
      _sales_data[key].rowdata[1] = fmt_number;
    });

  
    // Get context with jQuery - using jQuery's .get() method.
    var canvas = $('#sales-profit-partners-chart').get(0).getContext('2d');

  
    var salesProfitPartnersChartData = {
      labels: labels,
      datasets: [{
          // type: 'bar',  
          label: '売上高',
          data: data,
          backgroundColor:'rgb(253, 191, 111, 0.5)',
          borderColor:'rgb(255, 127, 0, 1)',
          borderWidth: 1,
          yAxisID: "y-axis-1",            
      },
      {
        // type: 'line',   
        label: '粗利率',
        data: line_data,
        borderColor : "rgba(254,97,132,1)",
        backgroundColor : "rgba(254,97,132,0.3)", 
        // pointBackgroundColor : "rgba(254,97,132,0.8)", 
        // fill: false,
        borderWidth: 1,                
        yAxisID: "y-axis-2",          
    },      
    ]
    };

  //clear data
  if(typeof window.salesProfitPartnersChart != 'undefined'){
    removeData(window.salesProfitPartnersChart);
    window.salesProfitPartnersChart.data = salesProfitPartnersChartData;
    window.salesProfitPartnersChart.update();
  }else{      
      var options = {
        title: {                           //タイトル設定
            text: '顧客別売上・粗利率グラフ'                //ラベル
        },
        legend: {                          //凡例設定
          display: true,                 //表示設定
          position: 'top',
        },         
        scales: {                          //軸設定
            yAxes: [
              {                      //y軸設定
                id: "y-axis-1",  
                position: "left", 
                type: "linear",                                                  
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
                    min: 0,        
                },
              },
              {
                id: "y-axis-2",                
                type: "linear", 
                position: "right",
                scaleLabel: {              //軸ラベル設定
                  display: true,          //表示設定
                  labelString: '粗利率',  //ラベル
                  fontSize: 18               //フォントサイズ
               },                  
                ticks: {
                  userCallback: function(item) {
                    return parseInt(item) + '%';
                  },                      
                    max: 100,
                    min: 0,
                    stepSize: 15
                },
                gridLines: { // このオプションを追加
                  drawOnChartArea: false, 
                },                  
            }                
            ],
        },   
      };      

      options = Object.assign({}, defaultChartOptions,options);  

      // Create the Bar chart
      window.salesProfitPartnersChart = createChart('bar',canvas,salesProfitPartnersChartData,options);    

    }    
  }  
  // 業務別売上・粗利率
  function drawSalesProfitWorkcontentsChart(_sales_data){
    labels = [];
    data = [];line_data = [];
    //labelsと値の取り出し
    Object.keys(_sales_data).forEach(function(key){
      labels.push(_sales_data[key].name);
      data.push(_sales_data[key].rowdata[0]);
      fmt_number = roundAtBase(_sales_data[key].rowdata[1], 100);
      line_data.push(fmt_number); 
      _sales_data[key].rowdata[1] = fmt_number;
    });
  
    
      // Get context with jQuery - using jQuery's .get() method.
      var canvas = $('#sales-profit-workcontents-chart').get(0).getContext('2d');
  
    
      var salesProfitWorkcontentsChartData = {
        labels: labels,
        datasets: [{
            // type: 'bar',  
            label: '売上高',
            data: data,
            backgroundColor:'rgb(253, 191, 111, 0.5)',
            borderColor:'rgb(255, 127, 0, 1)',
            borderWidth: 1,
            yAxisID: "y-axis-1",            
        },
        {
          // type: 'line',   
          label: '粗利率',
          data: line_data,
          borderColor : "rgba(254,97,132,1)",
          backgroundColor : "rgba(254,97,132,0.3)", 
          // pointBackgroundColor : "rgba(254,97,132,0.8)", 
          // fill: false,
          borderWidth: 1,                
          yAxisID: "y-axis-2",          
      },     
      ]
      };
  
    //clear data
    if(typeof window.salesProfitWorkcontentsChart != 'undefined'){
      removeData(window.salesProfitWorkcontentsChart);
      window.salesProfitWorkcontentsChart.data = salesProfitWorkcontentsChartData;
      window.salesProfitWorkcontentsChart.update();
    }else{      
        var options = {
          title: {                           //タイトル設定
              text: '業務別売上・粗利率グラフ'                //ラベル
          },
          legend: {                          //凡例設定
            display: true,                 //表示設定
            position: 'top',
          },           
          scales: {                          //軸設定
              yAxes: [
                {                      //y軸設定
                  id: "y-axis-1",  
                  position: "left", 
                  type: "linear",                                                  
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
                      min: 0,        
                  },
                },
                {
                  id: "y-axis-2",                
                  type: "linear", 
                  position: "right",
                  scaleLabel: {              //軸ラベル設定
                    display: true,          //表示設定
                    labelString: '粗利率',  //ラベル
                    fontSize: 18               //フォントサイズ
                 },                  
                  ticks: {
                    userCallback: function(item) {
                      return parseInt(item) + '%';
                    },                      
                      max: 100,
                      min: 0,
                      stepSize: 15
                  },
                  gridLines: { // このオプションを追加
                    drawOnChartArea: false, 
                  },                  
              }                
              ],
          },   
        };      
  
        options = Object.assign({}, defaultChartOptions,options);  
  
        // Create the Bar chart
        window.salesProfitWorkcontentsChart = createChart('bar',canvas,salesProfitWorkcontentsChartData,options);    
  
      }    
  }  
  

  
  /**
   * 任意の桁で四捨五入する関数
   * @param {number} value 四捨五入する数値
   * @param {number} base どの桁で四捨五入するか
   * @return {number} 四捨五入した値
   */
  function roundAtBase(value, base) {
    return Math.round(value * base) / base;
  }

  //顧客名ラベルを短くする
  function shortenCorporateName(name){
    if(name.length < 8){
      return name;
    }

    var temp = name.replace("株式会社|有限会社|会社","").trim();
    let pattern =(/ |　/g);
    temp_array = temp.split(pattern);
    var short_name = "";
    temp_array.forEach(element => {
      if(element.indexOf("財団") != -1 || element.indexOf("社団") != -1 || element.indexOf("法人") != -1){
        return;
      }
      short_name += element;
    });
    if(short_name == ""){
      return name;
    }else{
      return short_name;
    }
  }