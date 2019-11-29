<?php
$this->Html->css(
    [
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
    'jquery-clockpicker.min',
    'jquery-ui',
    'theme'
  ],
    ['block' => 'css']
);

$this->Html->script(
    [
  'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
  'jquery-clockpicker.min',
  'jquery-ui'
],
    ['block' => 'script']
);
?>

<script type="text/javascript">
  <?php
    $jsonOptions = json_encode($sortedOptions);
?>
  var work_places = <?php echo $jsonOptions; ?> ;



  $(document).ready(function() {

    // ロケールを設定
    moment.locale('ja');

    $('#date-range').daterangepicker({
        format: 'YYYY/MM/DD',
        //singleDatePicker: true,
        autoUpdateInput: false,
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
        $('#date-range').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
        //start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $("#start-date").val(start.format('YYYY/MM/DD'));
        $("#end-date").val(end.format('YYYY/MM/DD'));

      });


    $('#start-time, #end-time').clockpicker({
      autoclose: true
    });



    $('.accounts input').blur(function() {
      var total = getNum($("#guaranty-charge").val()) +
        getNum($("#additional-count").val()) * getNum($("#additional-unit-price").val());

      $("#total").val(total);
    });

    $(".sub_item_name").on("change", function() {
      var description = new Array();
      $(".sub_item_name").each(function() {
        description.push($(this).find('option:selected').text());
      });
      $("#description").val(description.join(" "));
    });


    //請負元変更時処理

    $("#client-id").change(function() {
      $("#work-place-id").prop('disabled', false);

      var client_id = $(this).children(':selected').val();

      $("#work-place-id").children('option').remove();
      var placeOptions = create_options(work_places[client_id]);
      $("#work-place-id").append(placeOptions);
      
      setContractRate(client_id);
    });

      $( "#sampleModal" ).dialog({ 
        autoOpen: false, 
        modal:false, //モーダル表示
        width:600, //ダイアログの横幅(px)
			  height:800, //ダイアログの縦幅(px)        
        title:"業務契約料金", //タイトル
        buttons: { //ボタン
        "確認": function() {
            $(this).dialog("close");
          }
        }        
        });
      $( "#modalOpener" ).click(function() {
        $( "#sampleModal" ).dialog( "open" );
      });


  });

  function create_options(dataArray) {
    if (dataArray == undefined || dataArray.length == 0) {
      var options = '<option value="">選択可能な派遣先がありません！</option>';


    } else {
      var options = '<option value="">--</option>';
      $.each(dataArray,
        function(index, val) {
          options += '<option value="' + val.id + '">' + val.name + '</option>';
        }
      );
    }





    return options;

  }


  function getNum(val) {
    if (isNaN(val) || val === undefined || val == '') {
      return 0;
    }
    return parseInt(val);
  }

  function clearDialogData(){

    $(".contactrate_table td").each(function(i,elem){
      $(elem).text("");
    });



  }

  function setContractRate(client_id){

    clearDialogData();

    $("#contactrate_warning").hide();
    var data = {client_id:client_id};
    
    var Url = "/aoba_business_system/ContractRates/ajaxloadcontractrates";
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
        if(data == "null"){
          $("#contactrate_warning").show();
          return;
        }

        Object.keys(parseData).forEach(function (key) {
          if($(key) != null){
            $("#" + key).text(parseData[key]);
          }
        });
          
        
        },
        error:function(XHR, status, errorThrown){
            if(XHR.responseJSON.message != null){
                // alert(XHR.responseJSON.message);
            }else{
                alert(status)
            }
            }
        
        });


  }

</script>
<style>
  .hr-orange {
    border-color: orange;
  }
  .modeless{
    top:10%;
    left:50%;
    bottom:auto;
    right:auto;
    margin-left:-300px;
}
.modal {
    background: none !important ;
}
.ui-front {
    z-index: 1000;
}
</style>
<section class="content-header">
  <h1>
    新規受注
    <small>注文データをを新規登録します</small>
  </h1>
</section>
<section class="content voffset4">

  <?= $this->Form->create($order, [
    'class' => 'form-horizontal'
    ]) ?>

  <div class="clearfix">
    <h3>基本情報</h3>
    <div class="col-md-6">
      <?php
             echo $this->Form->input('order_no', [
             'label' => '受注No']);
        
            echo $this->Form->input('client_id', [
            'label' => '請負元',
            'empty' => '--',
            'options'=>$clients
            ]);
             echo $this->Form->input('work_place_id', [
             'label' => '派遣先',
             'empty' => '--請負元を選択して下さい--',
            //  'disabled'=> true,
             'class'=>'form-control sub_item_name',
             'options' =>null
            ]);
        ?>

    </div>

    <div class="col-md-6">
      <?php
            echo $this->Form->input('temporary_registration', [
                'options' =>['0' => '正式登録','1' => '仮登録'],
                // 'empty' => '--',
                'value'=>0,
                'label' => 'ステータス'
            ]);
             echo $this->Form->input('recipient', [
             'label' => '届け先',
             'empty' => '--',
            'options'=>[
            '依頼元'=>'依頼元','事業所'=>'事業所']
            ]);
             echo $this->Form->input('payment', [
             'label' => '請求先',
            //  'empty' => '--',
            'value'=>0,            
            'options'=>[
            '依頼元'=>'依頼元','事業所'=>'事業所']
            ]);
            echo $this->Form->input('notes', [
            'label' => '備考']);
            
            
        ?>

    </div>
  </div>
  <hr />

  <div class="clearfix">
    <h3>実施期間</h3>
    <div class="col-md-6">
      <?php
             echo $this->Form->input('start_date', [
             'type' => 'hidden']);
             echo $this->Form->input('end_date', [
             'type' => 'hidden']);
            echo $this->Form->input('date_range', [
            'label' => '年月日期間',
             'append'=>'<i class="fa fa-calendar"></i>']);

        ?>

    </div>

    <div class="col-md-6">
      <div class="col-md-5">
        <?php
             echo $this->Form->input('start_time', [
             'type' => 'text',
             'label' => '時間帯',
             'append'=>'<i class="fa fa-clock-o"></i>']);
         
        ?>
      </div>
      <div class="col-md-2 text-center">
        ～
      </div>

      <div class="col-md-5">
        <?php
   
             echo $this->Form->input('end_time', [
             'type' => 'text',
             'label' => false,
             'append'=>'<i class="fa fa-clock-o"></i>'
             ]);
           
        ?>
      </div>
    </div>
  </div>
  <hr />
  <div class="clearfix">
    <h3>業務詳細</h3>
    <div class="col-md-6">
      <?php
        
             echo $this->Form->input('work_content_id', [
             'options' => $workContents,
             'empty' => '--',
             'class'=>'form-control sub_item_name',
             'label' => '業務内容'
             ]);
        
            echo $this->Form->input('capturing_region_id', [
            'options'=>$capturingRegions,
            'empty' => '--',
            'class'=>'form-control sub_item_name',
            'label' => '撮影部位'
            ]);
            
            
             echo $this->Form->input('need_image_reading', [
             'label' => '読影',
             'empty' => '--',
            'options'=>['0' => 'なし','1' => 'あり']
            ]);
               
        ?>


    </div>

    <div class="col-md-6">
      <?php
            echo $this->Form->input('film_size_id', [
            'options'=>$filmSizes,
            'empty' => '--',
            'class'=>'form-control sub_item_name',
            'label' => 'フィルムサイズ'
            ]);
            echo $this->Form->input('patient_num', [
            'label' => '受診者数'
            ]);

            echo $this->Form->input('description', [
            'type' => 'hidden'
            ]);
        ?>

    </div>
  </div>
  <hr class="hr-orange">

  <div class="clearfix accounts">
    <h3>会計&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="button" class="btn btn-sm btn-default glyphicon glyphicon-th-list" id="modalOpener">
        業務契約料金
      </button>
    </h3>

    <!-- モーダル・ダイアログ -->
    <div class="" id="sampleModal"  style="display:none;">
      <div class="">
        <div class="content">
          <div class="body">       
              
              <legend>業務契約料金表</legend>
            <div class="callout callout-warning" id="contactrate_warning" style="display:none;">
            <h4><i class="icon fa fa-warning"></i>　通知</h4>
            <p>業務契約料金の設定データがありません。</p>
            </div> 
            <div class="table-responsive">
            <table class="table vertical-table table-bordered contactrate_table">
            <tr class="bg-orange">
                <th scope="row">部位</th><th scope="row">装置種類</th><th scope="row">撮影方法</th>
            <th scope="row">項目名</th>
            <th>数量</th>
            </tr>
        <tr><th scope="row" rowspan="16" class="bg-success"><?= __('胸部') ?></th><th scope="row" rowspan="10" class="bg-success"><?= __('可搬') ?></th>
            <th scope="row" rowspan="5" class="bg-info"><?= __('間接') ?></th>
            <th scope="row" class="bg-info"><?= __('保証料金') ?></th>
            <td class="bg-info" id="guaranty_charge_chest_i_por"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('保証人数') ?></th>
            <td class="bg-info" id="guaranty_count_chest_i_por"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('追加料金単価') ?></th>
            <td class="bg-info" id="additional_unit_price_chest_i_por"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('可搬費') ?></th>
            <td class="bg-info" id="transportable_equipment_cost_chest_i_por"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('当日') ?></th>
            <td class="bg-info" id="appointed_day_cost_chest_i_por"></td>
        </tr>
        <tr>
            <th scope="row" rowspan="5"><?= __('デジタル') ?></th>
          <th scope="row"><?= __('保証料金') ?></th>
            <td id="guaranty_charge_chest_dg_por"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('保証人数') ?></th>
            <td id="guaranty_count_chest_dg_por"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('追加料金単価') ?></th>
            <td id="additional_unit_price_chest_dg_por"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('可搬費') ?></th>
            <td id="transportable_equipment_cost_chest_dg_por"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('当日') ?></th>
            <td id="appointed_day_cost_chest_dg_por"></td>
        </tr>

        <tr>
            <th scope="row" rowspan="6" class="bg-success"><?= __('レントゲン車') ?></th><th scope="row" rowspan="3" class="bg-info"><?= __('デジタル') ?></th>
            <th scope="row" class="bg-info"><?= __('保証料金') ?></th>
            <td class="bg-info" id="guaranty_charge_chest_dg_car"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('保証人数') ?></th>
            <td class="bg-info" id="guaranty_count_chest_dg_car"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('追加料金単価') ?></th>
            <td class="bg-info" id="additional_unit_price_chest_dg_car"></td>
        </tr>
        <tr>
            <th scope="row" rowspan="3"><?= __('直接') ?></th>
            <th scope="row"><?= __('保証料金') ?></th>
            <td id="guaranty_charge_chest_dr_car"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('保証人数') ?></th>
            <td id="guaranty_count_chest_dr_car"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('追加料金単価') ?></th>
            <td id="additional_unit_price_chest_dr_car"></td>
        </tr>
        <tr><th scope="row" rowspan="6" class="bg-danger"><?= __('胃部') ?></th><th scope="row" rowspan="6" class="bg-danger"><?= __('レントゲン車') ?></th>
            <th scope="row" rowspan="3" class="bg-info"><?= __('間接（８枚）') ?></th>
            <th scope="row" class="bg-info"><?= __('保証料金') ?></th>
            <td class="bg-info" id="guaranty_charge_stom_i_car"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('保証人数') ?></th>
            <td class="bg-info" id="guaranty_count_stom_i_car"></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('追加料金単価') ?></th>
            <td class="bg-info" id="additional_unit_price_stom_i_car"></td>
        </tr>
        <tr>
            <th scope="row" rowspan="3"><?= __('直接') ?></th>
            <th scope="row"><?= __('保証料金') ?></th>
            <td id="guaranty_charge_stom_dr_car"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('保証人数') ?></th>
            <td id="guaranty_count_stom_dr_car"></td>
        </tr>
        <tr>
            <th scope="row"><?= __('追加料金単価') ?></th>
            <td id="additional_unit_price_stom_dr_car"></td>
        </tr>
        <tr class="bg-info"><th scope="row"  colspan="3"><?= __('その他') ?></th>
            <th scope="row"><?= __('稼働費') ?></th>
            <td id="operating_cost"></td>
        </tr>    </table> 
        </div>


          </div>

        </div>
      </div>
    </div><!-- モーダル・ダイアログ -->

    <div class="col-md-6">
      <?php
        
             echo $this->Form->input('guaranty_charge', [
             'label' => '保証料金'
             ]);
        
             echo $this->Form->input('guaranty_count', [
             'label' => '保証人数'
             ]);
               
        ?>


    </div>

    <div class="col-md-6">
      <?php
        
             echo $this->Form->input('additional_count', [
             'label' => '追加人数'
             ]);
        
             echo $this->Form->input('additional_unit_price', [
             'label' => '追加料金単価'
             ]);
        ?>

    </div>
  </div>

  <hr class="hr-orange">

  <div class="clearfix">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
      <?php
             echo $this->Form->input('total', [
             'label' => '受注額合計',
             'readonly' => true
             ]);

        ?>
    </div>
  </div>
  <div class="clearfix  well bg-gray voffset4">
    <div class="text-center">
      <?= $this->Form->button(__('新規登録'), [
        'class' => 'btn btn-success'
    ]) ?>
      &nbsp;&nbsp;&nbsp;
      <?= $this->Html->link(
        __('注文一覧に戻る'),
        ['action' => 'index'],
        ['class' => 'btn btn-default  glyphicon glyphicon-table']
    ) ?>
    </div>
  </div>
  <?= $this->Form->end() ?>

</section>