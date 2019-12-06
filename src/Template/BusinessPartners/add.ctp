<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker'
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
],
['block' => 'script']);
?>
<script type="text/javascript">

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
    $('.specific_holiday').each(function(i,elem){
        $(elem).daterangepicker(picker_option, (start, end, label)=> {
            $(elem).val(start.format('YYYY/MM/DD')).trigger('change');
        });
    });


    $('#postal-code').blur(function(){
        
        // $('#検索btn').trigger('click');
        
    }); 
    
    $('.weekday').on('click',function(){
        put_weekdayval_to_hiddenfield(".weekday");
    });
    $('.specific_holiday').on('change',function(){
        update_specific_holidays(".specific_holiday");
    });
    

});    

//曜日番号をhiddenフォームに設定
function put_weekdayval_to_hiddenfield(selector){
    optionid_arr =new Array();
    var idx = 0;
 $(selector).each(function(i) {
        if($(this).prop('checked')){
            optionid_arr[idx] = parseInt( $(this).val());       
            idx = idx + 1;  
        }
        

  }); 
    $("#holiday-numbers").val(optionid_arr.join(","));
    
    
}  

//特定休日をhiddenフォームに設定
function update_specific_holidays(selector){
    dateArray =new Array();
    var idx = 0;
    $(selector).each(function(i) {
        if($(this).val() != ''){
            dateArray[idx] =  $(this).val();       
            idx = idx + 1;  
        }
  }); 
    $("#specific-holidays").val(dateArray.join(","));   
}  
    

//住所検索
function findZipCode()
{
    var n = $("#postal-code").val();

    n = n.replace(/-/g, "");
    n = n.replace(/[―ー]/g, ""); 
if(n.length < 7) {
    $('#skipCheckWarning').html("郵便番号全７桁を入力してから、住所検索ボタンを押してください。").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } },
        dialogClass: "ui-state-error"
        ,modal : true
        ,title: "郵便番号入力不足"

             });    
    return;
}   
var subN = n.substring(0,2); // 先頭の番号2桁を取得
if (subN.length < 2) return; // 1桁の場合は処理しない
loadDataFile(n);
}
function loadDataFile(zipcode)
{
    var data = {zipcode:zipcode};
    
    var Url = "/aoba_business_system/BusinessPartners/ajaxloadaddress";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:data,
        type:"POST",
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },
        success:function(zipData){
        // カンマ区切りテキストを解析して一致したデータを表示
        var parseData = eval("("+zipData+")");  
        //         alert(parseData);                

        var cutPos = parseData.indexOf('（');

        if(cutPos != -1 ){
            parseData = parseData.substring(0,cutPos);
        }
        
        $("#address").val(parseData);    
        $("#banchi").focus();    
        
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
/////////住所検索終わり    

</script>

<section class="content-header">
<h1>
取引先新規登録
<small>業務取引先を新規登録します</small>
</h1>
</section>
<section class="content voffset4 clearfix">

    <?= $this->Form->create($businessPartner,[
    'class' => 'form-horizontal'
    ]) ?>
<div class="clearfix">
            <legend><?= __('新規取引先入力フォーム') ?></legend>    
<div class="col-md-6">
    <fieldset>
        <?php
             echo $this->Form->input('name',[
            'label'=>"取引先名称"
            ]);
            echo $this->Form->input('kana',[
            'label'=>"フリガナ"
            ]);

            echo $this->Form->input('postal_code',[
            'label'=>"郵便番号",
            'append' => '<button id="検索btn" type="button" class="btn btn-primary" onclick="Javascript:findZipCode(); return false;">検索</button>'
            ]);
            echo $this->Form->input('address',[
            'label'=>"住所"
            ]);
            echo $this->Form->input('banchi',[
            'label'=>"番地"
            ]);
            echo $this->Form->input('tatemono',[
            'label'=>"建物名"
            ]);
            echo $this->Form->input('tel',[
            'label'=>"電話番号",
            'size' => 15
            ]);
            echo $this->Form->input('fax',[
            'label'=>"FAX"
            ]);
            echo $this->Form->input('department',[
            'label'=>"部署名"
            ]);
            echo $this->Form->input('staff',[
            'label'=>"担当者名"
            ]);
            echo $this->Form->input('staff2',[
            'label'=>"担当者名2"
            ]);            
            echo $this->Form->input('staff_tel',[
            'label'=>"担当者　連絡先"
            ]);
            echo $this->Form->input('dr',[
            'label'=>"DR"
            ]);            
             ?>
            <div class="form-group">
            <?= $this->Form->label('is_client', '請負元',[
            'class' => 'checkbox-inline'
            ]); ?>
            <div class=" col-md-6">
            <?= $this->Form->checkbox('is_client'); ?>
           </div></div>            
            <div class="form-group">
            <?= $this->Form->label('is_work_place', '派遣先'); ?>
            <div class=" col-md-6">
            <?= $this->Form->checkbox('is_work_place'); ?>
           </div></div>
             <?php          
            echo $this->Form->input('parent_id', [
                'options' => $parentBusinessPartners,
                'empty' => '請負元は自社',
                'label' => '請負元名称'
            ]);           
                ?>       
            <div class="form-group">
            <?= $this->Form->label('is_supplier', '仕入先'); ?>
            <div class=" col-md-6">
            <?= $this->Form->checkbox('is_supplier'); ?>
           </div></div>
            
      <?php   
             echo $this->Form->input('notes',[
            'label'=>"備考"
            ]);                

        ?>
    </fieldset>
    </div><div class="col-md-6">
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">定休日(曜日)</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
      <?php
            echo $this->Form->input('holiday_numbers',[
            'type'=>"hidden"
            ]);
    ?>
  
<table class="table table-bordered table-condensed text-center">
    <thead>
        <th>日</th>        
        <th>月</th>        
        <th>火</th>        
        <th>水</th>        
        <th>木</th>        
        <th>金</th>        
        <th>土</th>        
        
    </thead>
    <tbody>
        <tr>
            <td>
<?= $this->Form->checkbox('sunday',[
    'class' => 'weekday','value'=>'0','hiddenField' => false,'name' => false]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('monday',[
    'class' => 'weekday','value'=>'1','hiddenField' => false,'name' => false]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('tuesday',[
    'class' => 'weekday','value'=>'2','hiddenField' => false,'name' => false]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('wednesday',[
    'class' => 'weekday','value'=>'3','hiddenField' => false,'name' => false]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('thursday',[
    'class' => 'weekday','value'=>'4','hiddenField' => false,'name' => false]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('friday',[
    'class' => 'weekday','value'=>'5','hiddenField' => false,'name' => false]); ?>               
            </td>
            <td>
<?= $this->Form->checkbox('saturday',[
    'class' => 'weekday','value'=>'6','hiddenField' => false,'name' => false]); ?>               
            </td>
            
        </tr>
        
    </tbody>
</table>


  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->  

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">定休日(特定日)</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
  <?php
    echo $this->Form->input('specific_holidays',[
    'type'=>"hidden"
    ]);
    ?>

  <?php
    for ($i=0; $i < 7; $i++) { 
        echo $this->Form->input('holiday' . ($i + 1),[
            'label' => '休日' . ($i + 1),'type' => 'text','class'=>'form-control specific_holiday',
             'append'=>'<i class="fa fa-calendar"></i>']);        
    }
  ?>

  </div><!-- /.box-body -->
  <div class="box-footer">

  </div><!-- box-footer -->
</div><!-- /.box -->
  
</div> 
</div>   
    <hr />

    <div class="pull-right">
    <?= $this->Form->button(__('新規登録'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('取引先一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
    <?= $this->Form->end() ?>

</section>

