<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
    'jquery-ui',
    //'jquery-ui.structure',
    'jquery-ui.theme',
    'ui.jqgrid'
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  'jquery-ui',
  'grid.locale-ja',
  'jquery.jqGrid.min'  
],
['block' => 'script']);
?>


<script type="text/javascript">
var savedRow = null; 
var savedCol = null; 
var lastSel = null;
var CONSUMPTIONTAX_RATE = 0.1;


$(document).ready(function(){  


    jQuery("#list").jqGrid({
         url:"/aoba_business_system/bills/ajaxloadbilldetails/" + "<?=$bill->id ?>",
         loadBeforeSend: function(jqXHR) {
            jqXHR.setRequestHeader('X-CSRF-Token', <?= json_encode($this->request->getParam('_csrfToken')); ?>);
        },
         datatype: "json",
          mtype: 'POST',
          colNames:['id','order_id','受注No','摘要','保証料金','保証人数','追加人数','追加料金単価','その他料金','小計'],
          colModel :[ 
            {name:'id', index:'id', width:1,editable:false,sortable:false}, 
            {name:'order_id', index:'order_id', width:1,editable:false,sortable:false}, 
            {name:'order_no', index:'order_no', width:60,editable:false,sortable:false,align:'center'}, 
           {name:'description', index:'description',  width:230,editable:true,sortable:false, align:'left'},//,sorttype:"text"},
            {name:'guaranty_charge', index:'guaranty_charge',  width:60,editable:true,sortable:false, align:'right'},//,sorttype:"text"},
            {name:'guaranty_count', index:'guaranty_count', width:60, align:'right',sortable:false,editable:true  },   
             {name:'additional_count', index:'additional_count', width:60, align:'right',editable:true,sortable:false},                             
            {name:'additional_unit_price', index:'additional_unit_price',  width:75,editable:true,sortable:false, align:'right'},//,sorttype:"text"},
            {name:'other_charge', index:'other_charge', width:70,editable:true,sortable:false, align:'right'}, 
            {name:'sub_total', index:'sub_total', width:80,editable:false,sortable:false, align:'right'}, 
           
            ],
        beforeEditCell: function (rowid, cellname, value, iRow, iCol) { 
        // クリックされたセルを記録 
            savedRow = iRow; savedCol = iCol;


         },

         afterEditCell: function (rowid, cellname, value, iRow, iCol){

         },
         afterSaveCell:function(rowid,cellname,value,iRow,iCol){
         }
         ,
         loadComplete: function (data) { 
                if(data.userdata !=undefined){
                  
                    $("#total-charge").val(data.userdata.sub_total);
                        $("#tax-inclusion").trigger('change');
                }
     
             },
        onSelectRow:function(rowid){
          if(rowid && rowid!==lastSel){ // 別の行選択時
             //$(this).restoreRow(lastSel); // 前の編集行をキャンセル
             $(this).saveRow(lastSel); // 前の編集行を確定
             lastSel = rowid;
          } 
          
            $(this).jqGrid('editRow',rowid, 
            { 
                keys : true, 
                aftersavefunc: function() {
                    var rowData = $("#list").getRowData(rowid);
                    sub_total = null_to_zero(rowData.guaranty_charge) + null_to_zero(rowData.additional_count) *
                    null_to_zero(rowData.additional_unit_price) + null_to_zero(rowData.other_charge);
                    
                    jQuery("#list").setCell(rowid, 'sub_total', sub_total) ;
                    recalc_footer_data();
                }
            });       
          
         //$(this).editRow(id, true,,,);            
        },
            
    //              width:1000,
                    height:400,
//                  sortname:'カテゴリ',
    //              sortorder: "ASC",
                  //loadonce: true,
                    cellEdit:false,
                    editurl:"clientArray",
                    cellsubmit: 'clientArray', 
                     viewrecords: true,
                     scroll:true,
                    multiselect: true,
                   // caption: '請求明細',
                    footerrow : true, 
                    userDataOnFooter : true, 
                    //altRows : true,
                    rowNum:400
                    ,pager:"#pager"
                

                }).navGrid("#pager",{refresh: false,edit:false,add:false,del:false,search:false})
                .navButtonAdd('#pager',{
                  caption:"", buttonimg:"", onClickButton: function(){delrow();}, position:"last",title:"レコード削除"
                 })
                .hideCol(['id','order_id'])
                 ;  
        $("td[title='レコード追加'] span").removeClass("ui-icon-newwin");  
        $("td[title='レコード追加'] span").addClass("ui-icon-plus");

        $("td[title='レコード削除'] span").removeClass("ui-icon-newwin");  
        $("td[title='レコード削除'] span").addClass("ui-icon-trash");




////////////////jqgrid

   // ロケールを設定
    moment.locale('ja');

    $options = {
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
       }};
    
    $('#bill-sent-date').daterangepicker($options, 
    function(start, end, label) {
        //start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#bill-sent-date').val(start.format('YYYY/MM/DD'));

    });

    $('#due-date').daterangepicker($options,
    function(start, end, label) {
        //start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#due-date').val(start.format('YYYY/MM/DD'));

    });



  

});

function null_to_zero(strNumber){
    
    integerNum = parseInt(strNumber);
    
    if(isNaN(integerNum)){
        return 0;
    }else{
        return integerNum;
    }
    
    
}

function recalc_footer_data(){
    
    var val_ary = $("#list").jqGrid('getCol', 'sub_total', false, '');
    var total = 0;
    for(var i = 0; i < val_ary.length; i++){
        total += parseInt( val_ary[i] ); 
    }

    // var val_ary = $("#list").jqGrid('getCol', '数量', false, '');
    // var volume = 0;
    // for(var i = 0; i < val_ary.length; i++){
        // volume += parseInt( val_ary[i] );
    // }
    $("#list").footerData('set',{sub_total: total});   
    
    $("#total-charge").val(total);    
    $("#tax-inclusion").trigger('change');
}


function calcConsumptionTax(){
    var tax_inclusion = $("#tax-inclusion").val();
    var total_value = $("#total-charge").val();
    
    if(total_value == ""){ return false;}
        
    var ret = $("#list").footerData('get'); 
    var origin_val = ret['sub_total']; 
        
    if(tax_inclusion == 1){
        
        $("#total-charge").val(origin_val);
        
        var cns_tax = Math.floor(origin_val * CONSUMPTIONTAX_RATE/(1 + CONSUMPTIONTAX_RATE));       
        
    }else{
        var cns_tax = Math.floor(total_value * CONSUMPTIONTAX_RATE);
            $("#total-charge").val(parseInt(total_value) + parseInt(cns_tax));        
    }
    
    $("#consumption-tax").val(cns_tax);

    
}


function updateBillData(){

if (savedRow && savedCol) { 
jQuery("#list").jqGrid('saveCell', savedRow, savedCol); }
    
 //請求明細データを取得
    var rowNum = $("#list").getGridParam("records");
    var values = new Array(); 

    var rowIds = $("#list").getDataIDs();
    if (rowIds.length == 0) { alert("請求明細データが作成されていません。"); return false; } 

    for (var i = 0; i < rowIds.length; i++) {
         var row = $('#list').getRowData(rowIds[i]); 
         //'項目','オプション','単価','数量','金額'
         values[i] = new Array(row.order_id,row.order_no,row.description,row.guaranty_charge, row.guaranty_count,row.additional_count,
             row.additional_unit_price,row.other_charge); 
         } 

 var data = {};
 //['id','項目','オプション','単価','数量','金額','receivable_id'],
    for (var i=0; i < values.length; i++) {
        if(values[i][4].toString() != ''){
            data['data[Orders]['+ i + '][order_id]'] = values[i][0].toString();
            data['data[Orders]['+ i + '][order_no]'] = values[i][1].toString();  
            data['data[Orders]['+ i + '][description]'] = values[i][2].toString();                       
            data['data[Orders]['+ i + '][guaranty_charge]'] = values[i][3].toString();
            data['data[Orders]['+ i + '][guaranty_count]'] = values[i][4].toString();
            data['data[Orders]['+ i + '][additional_count]'] = values[i][5].toString();
            data['data[Orders]['+ i + '][additional_unit_price]'] = values[i][6].toString();         
            data['data[Orders]['+ i + '][other_charge]'] = values[i][7].toString();            

        }

    };

execPostfromBillAddForm(data);
    
    return false;
}

/**
 * データをPOSTする
 * @param String アクション
 * @param Object POSTデータ連想配列
 */
function execPostfromBillAddForm(data) {
 // フォームの選択
var form = $("#BillEditForm");
// var form = document.createElement("form");
 //form.setAttribute("action", action);
// form.setAttribute("method", "post");
// form.style.display = "none";
// document.body.appendChild(form);
 // パラメタの設定
 if (data !== undefined) {
  for (var paramName in data) {
    
    $('<input type="hidden">').attr({
    value: data[paramName],
    name: paramName
}).appendTo(form);
    
    
   // var input = document.createElement('input');
   // input.setAttribute('type', 'hidden');
   // input.setAttribute('name', paramName);
   // input.setAttribute('value', data[paramName]);
   // form.appendChild(input);
  }
 }
 // submit
 form.submit();
}


/**
 * データをPOSTする
 * @param String アクション
 * @param Object POSTデータ連想配列
 */
function execPost(action, data) {
 // フォームの生成
 var form = document.createElement("form");
 form.setAttribute("action", action);
 form.setAttribute("method", "post");
 form.style.display = "none";
 document.body.appendChild(form);
 // パラメタの設定
 if (data !== undefined) {
  for (var paramName in data) {
   var input = document.createElement('input');
   input.setAttribute('type', 'hidden');
   input.setAttribute('name', paramName);
   input.setAttribute('value', data[paramName]);
   form.appendChild(input);
  }
 }
 // submit
 form.submit();
}



function addrow() { 
// 現在の最大のID番号取得 
var arrrows = $("#list").getRowData(); 
var max = 0; 
for (i = 0; i < arrrows.length; i++) { var cur = parseInt(arrrows[i].id);
 if (max < cur) { max = cur; } } 
 var tmpData = { id: max + 1};
    var  newId = max + 1;


    if(lastSel != null){
         //$(this).restoreRow(lastSel); // 前の編集行をキャンセル
         $("#list").saveRow(lastSel); // 前の編集行を確定
        
    }

          $("#list").jqGrid('addRow',{
            rowID : newId,
            position :"last",
            addRowParams:{
                keys : true, 
                aftersavefunc: function() {
                    var rowData = $("#list").getRowData(newId);
                    sub_total = null_to_zero(rowData.guaranty_charge) + null_to_zero(rowData.additional_count) *
                    null_to_zero(rowData.additional_unit_price) + null_to_zero(rowData.other_charge);
                    
                    jQuery("#list").setCell(newId, 'sub_total', sub_total) ;
                    recalc_footer_data();
                }          
                
            }
            
          });


}
 
function delrow() { 
// 選択されている行ID配列の取得 
var arrrows = $("#list").getGridParam("selarrrow");
 if (arrrows.length == 0) { alert("削除する行を選択してください。"); 
 } else { 
 // 選択行の削除 // グリッドの下の方から削除する。 // 参考URL: http://www.trirand.com/blog/?page_id=393/bugs/delrowdata-bug-on-grid-with-multiselect 
 var len = arrrows.length; 
 for(i = len-1; i >= 0; i--) {
     $("#list").delRowData(arrrows[i]); 
     }
 }
 
 recalc_footer_data();
  
 } 

</script>
<style type="text/css" media="screen">
    div.alert-info {
overflow: scroll;
}
</style>

<section class="content-header">
<h1>
請求書内容編集 (
 <a href="<?php 

    echo $this->Url->build(['controller'=>'BusinessPartners', 'action'=>'view', $payerData->id]);  

 ?>" target="_blank"><?=$payerData->name ?></a>    
    )
<small>選択請求書の内容を編集します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
<div class="col-md-12">
    
    
    
<div class="box box-default">
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
             <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= h($order->order_no) ?></td>
                <td><?= h($order->start_date->format("Y/m/d") . " ~ " . $order->end_date->format("Y-m-d")) ?></td>
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
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign','target'=>"_blank"]) ?>
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

<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">請求書編集フォーム&nbsp;&nbsp;&nbsp;&nbsp;
       
    </h3>

  </div><!-- /.box-header -->
  <div class="box-body">
  

        <legend><?php echo __('請求書内容編集'); ?></legend>   
<div class="billadd form">              
    <?php echo $this->Form->create($bill ,[
    'class' => 'form-horizontal',
    'id' => 'BillEditForm'
    ]); ?>  

        <div class="clearfix"><div class="row">
        <div class="col-md-5">
            
    <?php echo $this->Form->input('bill_no', array(
        'type' => 'text',
        'label' =>'* 請求書No',

        'placeholder' => '請求書No'
    )); ?>              
        <?php
            /** 送付日 */
            $thisDate = new DateTime();
            
            echo $this->Form->input(
                'bill_sent_date',
                array('class'=>'col-xs-5',
              
                'label' => '* 送付日','type'=>'text',
                'value'=>$bill->bill_sent_date->format("Y-m-d")
                )
            );
        ?>

    <?php echo $this->Form->input('payer_name', array(
        'label' => '請求先名',
        'type'=>'text',
        'placeholder' => '請求先名',
        'disabled' => true,
        'value'=>$payerData->name

    )); ?> 
    <?php echo $this->Form->input('business_partner_id', array(
        'type'=>'hidden',
        //'value' => $payerData['id']
    )); ?> 

    <?php echo $this->Form->input('data.year', array(
        'type'=>'hidden',
        'value'=>$year
    )); ?> 
    <?php echo $this->Form->input('data.month', array(
        'type'=>'hidden',
        'value'=>$month
            )); ?>                 
        <?php
            /** 支払期限 */
           // $thisDate->add(new DateInterval('P1M'));
            
            echo $this->Form->input(
                'due_date',
                array(  
                'label' => '支払期限','type'=>'text',
             //   'value'=> $thisDate->format("Y-m-t")
            ));
        ?>
    <?php 
    $tax_inclusion_val = $bill->tax_inclusion;
    
    if($tax_inclusion_val){
        $options =     '<option value="0">外税</option>
    <option value="1" selected="selected">内税</option>';
    }else{
        $options =     '<option value="0" selected="selected">外税</option>
    <option value="1">内税</option>';
    }
    
    echo $this->Form->input('consumption_tax', array(
        'label' => '* 消費税',
       'type'=>'text',
        'placeholder' => '消費税'
    ,'append'=>'&nbsp;&nbsp;<select id="tax-inclusion" name="tax_inclusion" onchange="Javascript:calcConsumptionTax(); return false;">'.
    $options.
    '</select>'
        
    )); ?>          
    <?php echo $this->Form->input('total_charge', array(
        'label' => '* 請求額合計',
        'type'=>'text',
        'placeholder' => '請求額合計'

    )); ?>  
    <?php echo $this->Form->input('postal_code', array(
        'placeholder' => '郵便番号','label'=>'〒',
        'value'=>$payerData['postal_code'],
        'disabled' => true,
    'after'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" onclick="Javascript:findZipCode(); return false;">検索</button>'
    )); ?>  

    <?php echo $this->Form->input('address', array(
        'label'=>'住所',
        'value'=>$payerData['address'],
        'disabled' => true,        
        'placeholder' => '住所'
    )); ?>          
    <?php echo $this->Form->input('banchi', array(
        'label' => '番地',
        'value'=>$payerData['banchi'],
        'disabled' => true,        
        'placeholder' => '番地',
    )); ?>      
    <?php echo $this->Form->input('tatemono', array(
        'label' => '建物名',
        'value'=>$payerData['tatemono'],
        'disabled' => true,        
        'placeholder' => '建物名'
    )); ?>      
    <?php echo $this->Form->input('notes', array(
        'type' => 'textarea',
        'label' => '備考',
        'placeholder' => '備考'
    )); ?>
    <br>
    <p>
    <span class="text-danger">* がついている項目は必ず入力してください。</span>
    </p>
    <div class="voffset6"></div>


            
        </div>      
        <div class="col-md-7">          

<div class="box box-solid box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">請求明細パネル</h3>

  </div><!-- /.box-header -->
  <div class="box-body" style="overflow: scroll;">
 <table id="list" class="scroll"></table> 
<div id="pager" class="scroll" style="text-align:center;"></div> 
  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->

        
       
         
</div>

   



            
        </div>
        
        </div></div>

<hr />  
    <div class="form-actions">

    <div class="text-center">
    <?php
        echo $this->Form->button('これで更新する', array('class' => 'btn btn-primary',
        'type'=>'button',
        'onclick'=>'Javascript:updateBillData();return false;'
        )   
        );
        echo "&nbsp;&nbsp;&nbsp;";
        echo $this->Html->link(
            __('キャンセル'),
            array('controller' => 'Bills', 'action' => 'index',$payerData['id'],$year,$month),
            array('class' => 'btn')
        );
    ?></div>
    </div>
     <?php
        echo $this->Form->end();
    ?>       
    
  </div><!-- /.box-body -->
  <div class="box-footer">
    
  </div><!-- box-footer -->
</div><!-- /.box -->            
            
            
            
        </div>       
        
    </div>

</section>


