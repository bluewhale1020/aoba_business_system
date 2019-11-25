<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
    'jquery-ui',
    'jquery-ui.structure',
    'jquery-ui.theme'
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  'jquery-ui',
],
['block' => 'script']);
?>

<script type="text/javascript">



$(document).ready(function(){  

   // ロケールを設定
    moment.locale('ja');
    
    $('.received_date').daterangepicker({
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
    }, 
    function(start, end, label) {
        $(this.element).val(start.format('YYYY/MM/DD')).trigger('change');

});


    $('.received_date').on('change',function(){
        
        var bill_id = $(this).attr('id');
        
        bill_id = bill_id.split('-')[1];
        
        ajaxsavereceiveddate(bill_id,$(this).val());
        
    }); 
    



    // $("#check_all").click(function () {


    //     if( $(this).prop('checked') == true){
    //         $("#select_table tbody :checkbox").each(function(index, domEle){
    //             $(domEle).prop("checked",true).change();

                

    //         });

    //     }else{
    //         $("#select_table tbody :checkbox").each(function(index, domEle){
    //             $(domEle).prop("checked",false).change();

    //         });         
            
    //     }

          
    // });

  

});


  function ajaxsavereceiveddate(bill_id,value){
      

    var data = {bill_id:bill_id,value:value};
    
    var Url = "/aoba_business_system/bills/ajaxsavereceiveddate";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:data,
        type:"POST",
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },        
        success:function(data){
        // カンマ区切りテキストを解析して一致したデータを表示
        var parseData = eval("("+data+")");  
                // alert(parseData);                
            if(parseData.result == 1){
                $("#modal-alert").modal('show').removeClass("modal-danger").addClass("modal-success");
                $(".modal-title").text("保存成功");
                $("#modal-message").text(parseData.message);

                if($("#received_value-" + bill_id).val() == ''){
                    $("#description-" + bill_id).html('<span class="text-warning">入金待ち</span>'); 
                }else{
                    $("#description-" + bill_id).html('<span class="text-success">済</span>'); 
                }                

            }else{
                $("#modal-alert").modal('show').removeClass("modal-success").addClass("modal-danger");           
                $(".modal-title").text("保存失敗");
                $("#modal-message").text(parseData.message);
                $("#received_value-" + bill_id).val("").focus();
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



function viewBill(bill_id){
  
    var year = $("[name=date\\[year\\]]").val();
var month = $("[name=date\\[month\\]]").val();   


 var Url = "/aoba_business_system/bills/view/" + bill_id + "/" + year + "/" + month;
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字

// location.href= Url;
open( Url, "_blank" ) ;

}

function editBill(bill_id){
  
    var year = $("[name=date\\[year\\]]").val();
var month = $("[name=date\\[month\\]]").val();   


 var Url = "/aoba_business_system/bills/edit/" + bill_id + "/" + year + "/" + month;
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字

// location.href= Url;
open( Url, "_blank" ) ;

}

function bill_search(){
  
//検索条件取得
var year = $("[name=date\\[year\\]]").val();
var month = $("[name=date\\[month\\]]").val();
var status = $("[name=状況]").val();
var partner_id = $("[name=請求先]").val();
if(partner_id == ''){
  partner_id = 0;
}
 var Url = "/aoba_business_system/bills/indexAll/" + partner_id + "/" + year + "/" + month + "/" + status;
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字


 location.href= Url;

}

 function bill_delete(id){
 
 if(!confirm('本当に # ' + id + 'の請求書情報を削除して宜しいでしょうか?')){
     return false;
 }
 
  
//検索条件取得
var year = $("[name=date\\[year\\]]").val();
var month = $("[name=date\\[month\\]]").val();


 var Url = "/aoba_business_system/bills/delete/indexAll";
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字


 var data = {};
 var data ={'data[year]':year,'data[month]':month,
    'data[id]':id,'data[business_partner_id]':0};
    


 //location.href= Url;
 
execPost(Url, data);
    
}

function setBadDebt(id, mode){
 if(mode == 'bad'){
     $message = 'を貸し倒れに設定';
 }else{
    $message = 'の貸し倒れ設定を削除';
 }
 
 if(!confirm('本当に # ' + id + 'の請求書' + $message + 'しますか?')){
     return false;
 }
 

//検索条件取得
var year = $("[name=date\\[year\\]]").val();
var month = $("[name=date\\[month\\]]").val();
var business_partner_id = $("#business-partner-id").val();

 var Url = "/aoba_business_system/bills/setbaddebt/indexAll";
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字


 var data = {};
 var data ={'data[year]':year,'data[month]':month,'data[mode]':mode,
    'data[id]':id,'data[business_partner_id]':business_partner_id};
    


 //location.href= Url;
 
execPost(Url, data);  
                               
    
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

 function getCheckedIds(){
    
    var idArray = new Array();
    
    $("#select_table tbody input:checked").each(function(index, domEle){
        idArray.push( $(domEle).val() );

    });         
    
   
    return idArray;
}


</script>
<section class="content-header">
<h1>
請求書一括管理 
<small>全請求書を月ごとに管理します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">

        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">請求書一覧</h3>
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
    ,'class' => 'form-inline'
  ]); ?>
  
  <fieldset>

  <?php
//debug($this->request->data);
  // 日本語対応(YYYY年MM月DD日 HH時mm分)
$this->Form->templates([
    'dateWidget' => '<ul class="list-inline"><label>対象月</label><li class="year">{{year}} 年</li>
    <li class="month"> {{month}} 月 </li></ul>']);

echo $this->Form->input('date', array(
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
echo $this->Form->input('状況',[
  'options'=> [
      '回収'=>'回収済み',
      '未回収'=>'未回収'
  ],
   'empty' => '--'
]);  
?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Form->input('請求先',[
  'options'=> $payers, 'empty' => '--'
]);

?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->button('検索',['class' => 'btn-primary',
  'onclick'=>"Javascript:bill_search();return false;"]);
  ?>
  </fieldset>


  <?php echo $this->Form->end(); ?>  
 
</div> 
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div> 
   
  <div class="bills-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>        

             <tr class="bg-red">
                <th ><?= __('請求No') ?></th>
                <th ><?= __('請求先') ?></th>
                <th ><?= __('送付日') ?></th>
                <th ><?= __('摘要') ?></th>
                <th ><?= __('金額') ?></th>
                <th ><?= __('締切日') ?></th>
                <th ><?= __('入金日') ?></th> 
                
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody><?php if(!empty($bills)):  ?>
             <?php foreach ($bills as $bill): ?>
            <tr>
                  <td><?= $bill['bill_no'];   ?></td>
                  <td><?= $bill->business_partner->name;   ?></td>
                <td><?= $bill['bill_sent_date']; ?></td> 
                <td id="description-<?=$bill['id']; ?>"><?php
                    $description = '';
                    if(!empty($bill['uncollectible'])){
                        $description = "貸倒れ";
                        $class = 'text-danger';
                        
                    }elseif(!empty($bill['received_date'])){
                        $description = "済";
                        $class = 'text-success';
                    }else{
                        $description = "入金待ち";
                        $class = 'text-warning';
                    }
                    echo  '<span class="'.$class.'">'.$description .'</span>';
                    
                 ?></td> 
                <td><?php
                $fmt_option = ['after' => ' 円'];
                echo $this->Number->format($bill['total_charge'],$fmt_option); ?> </td>                
                <td><?= $bill['due_date']; ?></td>                                 
                <td ><?php
                if(empty($bill['uncollectible'])){
                    echo $this->Form->input('received_date',[
                    'value' => $bill['received_date'],
                    'label' => false,
                    'type' => 'text',
                    'class' => 'received_date',
                    'id' => 'received_value-'.$bill['id']
                    ]);
                    
                    $label = '貸倒';
                    $mode = 'bad';
                }else{
                    $label = '債権回収';
                    $mode = 'good';
                }
                
                  ?></td>
                
                <td class="actions text-center">
                    <div class="btn-group">
                <?php                   
                        echo $this->Form->button(' 閲覧', array(
                            'type' => 'button',
                            'class' => 'btn btn-info  glyphicon glyphicon-info-sign',
                            'escape' => false,
                            'div' => false,
                            'onclick' => "Javascript:viewBill(${bill['id']});return false;"
                        ));                     
                    ?>                          
                <?php                   
                        echo $this->Form->button(' 編集', array(
                            'type' => 'button',
                            'class' => 'btn btn-success  glyphicon glyphicon-pencil',
                            'escape' => false,
                            'div' => false,
                            'onclick' => "Javascript:editBill(${bill['id']});return false;"
                        ));                     
                    ?>              

                     <?= $this->Form->button(__('　削除'), [
                     'type'=>'button',
                     'onclick'=> "Javascript:bill_delete(${bill['id']});return false;",
                   'class' => 'btn btn-danger glyphicon glyphicon-remove']) ?>
                    <?php                   
                        echo $this->Form->button(' '.$label, array(
                            'type' => 'button',
                            'class' => 'btn bg-black glyphicon glyphicon-fire',
                            'onclick' => "Javascript:setBadDebt(${bill['id']},'${mode}');return false;"
                        ));                     
                    ?> 

                    </div>
                </td>
            </tr>
            <?php endforeach; ?>         
          <?php else: ?>
              <tr>
                  <td colspan="8">請求情報無し</td>
              </tr>
              
              
              <?php endif ?>
      </tbody>      
      
  </table>
  <div class="paginator">
    <ul class="pagination">
      <?php
        $this->Paginator->options(['url'=> ['action'=>'index_all','usePaging'=>1]]);            
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