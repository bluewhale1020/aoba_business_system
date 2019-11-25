<?php
$this->Html->css([
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
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
    
    $('#birth-date').daterangepicker({
        format:'YYYY/MM/DD',
        singleDatePicker: true,
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

});

    $('#postal-code').blur(function(){
        
        $('#検索btn').trigger('click');
        
    }); 

});    



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
    
    var Url = "/aoba_business_system/staffs/ajaxloadaddress";
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
新規スタッフ
<small>スタッフを新規登録します</small>
</h1>
</section>
<section class="content voffset4">

    <?= $this->Form->create($staff,[
    'class' => 'form-horizontal'
    ]) ?>
<div class="col-md-10">
    <fieldset>
        <legend><?= __('新規スタッフ入力フォーム') ?></legend>
        <?php
        
            echo $this->Form->input('name',[
            'label'=>"氏名"
            ]);
            echo $this->Form->input('kana',[
            'label'=>"フリガナ"
            ]);
            echo $this->Form->input('birth_date', [
            'type' => 'text',
            'label' => '生年月日']);
            
            echo $this->Form->input('sex', [
            'label' => '性別',
            'options' => ['1' =>'男','2' =>'女'], 'empty' => '--']);
                        
            echo $this->Form->input('tel',[
            'label'=>"電話番号",
            'size' => 15
            ]);
            ?>
            <?php
            echo $this->Form->input('postal_code',[
            'label'=>"郵便番号",
            'append' => '<button id="検索btn" type="button" class="btn btn-primary" onclick="Javascript:findZipCode(); return false;">検索</button>'
            ]);
            ?>
            <?php
            echo $this->Form->input('address',[
            'label'=>"住所"
            ]);
            echo $this->Form->input('banchi',[
            'label'=>"番地"
            ]);
            echo $this->Form->input('tatemono',[
            'label'=>"建物名"
            ]);
            echo $this->Form->input('occupation_id', [
            'label' => '職種１',
            'options' => $occupations, 'empty' => '--']);
            echo $this->Form->input('occupation2_id', [
            'label' => '職種２',
            'options' => $occupations, 'empty' => '--']);
            echo $this->Form->input('title_id', [
            'label' => '肩書',
            'options' => $titles, 'empty' => '--']);
            echo $this->Form->input('notes',[
            'label'=>"備考"
            ]);        
        ?>
    </fieldset>
    <hr />

    <div class="pull-right">
    <?= $this->Form->button(__('新規登録'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('スタッフ一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
    <?= $this->Form->end() ?>
</div>
</section>




