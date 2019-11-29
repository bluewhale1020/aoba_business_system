<?php
$this->Html->css([
    'jquery-ui',
    //'jquery-ui.structure',
    'jquery-ui.theme',
    'ui.jqgrid'    
],
['block' => 'css']);

$this->Html->script([
    'jquery-ui',
    'grid.locale-ja',
    'jquery.jqGrid.min',
    'datepicker-ja'
],
['block' => 'script']);
?>
<script type="text/javascript">
var savedRow = null; 
var savedCol = null; 
var dateColumn = ['生年月日','開始日','終了日'];


$(document).ready(function(){
	<?php if(isset($upload_file)):  ?>
	
	$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );

    // カラム名データ
    var columnNameData = ['処理結果','id'];
    // カラム設定データ
    var columnParamData = [
                {name:'処理結果', index:'処理結果', width:150,editable:false,sortable:false},
                {name:'id', index:'id', width:1,editable:false,sortable:false}
    ];

    <?php  

        $strParamData = array();
        $ParamData = array();
        
        foreach ($colNames as $key => $colname) {
            $num_col = 1;
            
            //colModel
            $modelName = $colname;

            $editable = 'true';

            $strParamData[] = "{name:'${modelName}', index:'${modelName}', width:100, align:'center', editable:${editable},sortable:false}"; 

            //colName
            $strNames[] = $colname;  

        }
        
        echo "var addedParamData = [" . implode(",", $strParamData) . "];"; 
        echo "var addedCol = ['" . implode("','", $strNames) . "'];";  
        
        $url = "/aoba_business_system/DataImports/ajaxloadfiledata/";

            
    ?>

    columnParamData = columnParamData.concat(addedParamData); 

    columnNameData = columnNameData.concat(addedCol);

    jQuery("#list").jqGrid({
        url: '<?php echo $url . $upload_file; ?>' ,
        loadBeforeSend: function(jqXHR) {
            jqXHR.setRequestHeader('X-CSRF-Token', <?= json_encode($this->request->getParam('_csrfToken')); ?>);
        },      
        datatype: 'json',
        mtype: 'POST',
        colNames:columnNameData,		  
		  // ['処理結果','id','フリガナ','生年月日'...],  
        colModel :columnParamData,
		  // [ 
			// {name:'処理結果', index:'処理結果', width:150,editable:false,sortable:false},
			// {name:'id', index:'id', width:1,editable:false,sortable:false},		  
		    // {name:'フリガナ', index:'フリガナ', width:100,editable:true,sortable:false}, 
		    // {name:'生年月日', index:'生年月日', width:80,editable:true,sortable:false},  	    
            // ...	],
         		    		    
		    		    
		beforeEditCell: function (rowid, cellname, value, iRow, iCol) { 
            // クリックされたセルを記録 
            savedRow = iRow; savedCol = iCol;

        },
        afterEditCell: function (rowid, cellname, value, iRow, iCol){
            if(dateColumn.includes(cellname)){
                $("#" + iRow + "_" + cellname, "#list").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat:'yy-mm-dd',
                    onSelect: function(dateText, inst){
                        jQuery("#list").jqGrid('saveCell', savedRow, savedCol);
                    }                    
                });
            }

        },        		 
        loadComplete: function (data) {
            if (data.rows.length > 0) {
                    // Select header checkbox (no jqGrid API for this, unfortunately)
                jQuery("#cb_list").click();                 
            }
            if(data.userdata !=undefined){
                  
                $("#category").val(data.userdata.category);
              }            
        },
        // width:$("#list").closest(".ui-jqgrid").parent().width(),
        height:650,
        //		sortname:'通番',
        //		sortorder: "ASC",
        loadonce: true,
        cellEdit:true,
        cellsubmit: 'clientArray', 
        viewrecords: true,
        multiselect: true,
        caption: 'Excelデータグリッド',
        shrinkToFit :false,
        rowNum:400
        ,pager:"#pager"	

    }).hideCol(['id']);///////＜－jqgridの終わり

    jQuery("#list").jqGrid('navGrid','#pager',{edit:false,add:false,del:false,refresh: false,search:true},
        {},{},{},{overlay: false,sopt:['eq','ne','lt','gt','bw','cn','in','ew']});

    //幅の調整　window widthに合わせる
    $(window).on("resize", function () {
        setJqgridWidth();
    });

    setJqgridWidth();
    <?php endif; ?>
    

	//結果ダイアローグ
	$( '#jquery-ui-dialog' ) . dialog( {
        autoOpen: false,
        width: 500,
        show: 'explode',
        //		        hide: 'explode',
        modal: false,
        //position: [ 0, 100 ],
        draggable: true,
        dialogClass: "ui-state-info",
        open:function(event, ui){ $(".ui-dialog-titlebar-close").show();}					        
            ,buttons: {
            '閉じる': function() {
                $( this ) . dialog( 'close' );
                return false;
            }
        }
    } );	
	

});

function setJqgridWidth(){
    var $grid = $("#list"),
    newWidth = $grid.closest(".ui-jqgrid").parent().width();
    $grid.jqGrid("setGridWidth", newWidth, false);
}

function  importFileData() {


	 
    if (savedRow && savedCol) { 
        jQuery("#list").jqGrid('saveCell', savedRow, savedCol); 
    }
    // グリッド内の選択されているデータを配列に取り込む 
    var rowIds = $("#list").getGridParam('selarrrow'); 
    if (rowIds.length == 0) { alert("データを選択してください。"); return false; }


    ret = confirm("結果データをシステムに登録します。よろしいですか？"); 
    if (ret == false) { return false; } 

    var values = new Array(); 

    var dataArray = {};
    var lastMessage = "";
    var idx = 0;
    var flg = false;


    while(idx < rowIds.length){

        for (var i = idx; i < rowIds.length; i++) {
            var row = $('#list').getRowData(rowIds[i]);      

            values.push(row);
                // values[i] = new Array(row.id,row.item1,row.item2,row.item3...	); 		 	

            if(i == idx +  9 || i == rowIds.length -1){
                idx = i + 1;
                break;
            }

        }//for 
        

        dataArray['num'] = values.length;
        dataArray['dat'] = values;

        //受診基本／詳細データをサーバーへポストする 
        var Url = "/aoba_business_system/DataImports/ajaxdataimport/" + $("#category").find('option:selected').val();

            //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
            
        $.ajax({ 
        type: "POST", 
        url: Url,
        async: false, 
        data: dataArray, 
        headers: { 'X-CSRF-Token': <?= json_encode($this->request->getParam('_csrfToken')); ?> },
        success: function(res, textStatus, xhr) { 
            // カンマ区切りテキストを解析して一致したデータを表示
            var parseData = eval("("+res+")");	
            //         alert(res);				
            
            for(var cnt = 0;cnt < parseData.data.length;cnt++){
                
                var id = parseData.data[cnt].id;
                
                if(parseData.data[cnt].result == 0){
                    //個別データ保存失敗
                    var messageText = '✕' + "(" + parseData.data[cnt].message + ")"
                    $('#'+id).css('color','red');					
                
                }else{
                    //個別データ保存成功
                    var messageText = '✔' + "(" + parseData.data[cnt].message + ")"
            
                    $('#'+id).css('color','green').css('font','bolder');						
                        
                }
                jQuery("#list").setCell(id, '処理結果', messageText) ;				
                
            }
            

            //alert(parseData.overall.message);
                lastMessage += parseData.overall.message + "\n\n";
        
        }, 
        error: function(res, textStatus, xhr) { 
            alert("サーバーとの通信に失敗しました。" + textStatus); 
        }
    //		 ,dataType: "json" 
        }); 

        values = [];
        
    }//while                    

    $( '#jquery-ui-dialog .message' ).html(''); 
    $( '#jquery-ui-dialog .message' ).html(lastMessage); 

    $('#jquery-ui-dialog') . dialog('open');

    //処理したレコードをuncheck
    
    jQuery("#list").jqGrid("resetSelection");	

} 

function postActionLink(action,filename){
        
        //受診基本／詳細データをサーバーへポストする 
    var Url = "/aoba_business_system/DataImports/" + action;
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    jqueryPost(Url, "Post", {'filename':filename});
    
}

</script>
<style>
</style>

<section class="content-header">
<div id="alert_div"></div>
<h1>
データインポート
<small>エクセルファイルのデータをシステムにインポート</small>
</h1>
</section>
<section class="content voffset4">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">インポートファイル</h3>

            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-8"> 

                <?php
                    echo $this->Form->create(null,[
                    'url'=>['action' => 'index'],
                    'enctype' => 'multipart/form-data'
                    ,'class' => 'form-inline'
                ]); ?>
                
                <fieldset>
                <?php
                    echo $this->Form->control('file_name',["type"=>"file","label"=>"ファイルを選択"]);
                ?>&nbsp;&nbsp;&nbsp;&nbsp;    
                <?php
                    echo $this->Form->button('データの読込',['class' => 'btn btn-primary']);
                ?>
                </fieldset>


                <?php echo $this->Form->end(); ?>
                </div>
                <div class="col-md-4 pull-right">
                    <div class="dropdown pull-right">
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                            インポートファイル雛形
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation">
                            <?=$this->Form->postLink(' スタッフ', ['action' => 'download'], 
                            ['class' => 'glyphicon glyphicon-download','data'=>['filename' => 'staffs']]) ?></li>
                            <li role="presentation">
                            <?=$this->Form->postLink(' 業務取引先', ['action' => 'download'], 
                            ['class' => 'glyphicon glyphicon-download','data'=>['filename' => 'business_partners']]) ?></li>
                            <li role="presentation">
                            <?=$this->Form->postLink(' 注文', ['action' => 'download'], 
                            ['class' => 'glyphicon glyphicon-download','data'=>['filename' => 'orders']]) ?></li>
                        </ul>
                    </div>                        
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">ファイルデータ一覧</h3>

            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">   
                    <div class="box box-solid text-center box-primary">
                        <div class="box-body bg-info">
                            <div >
                            <?php
                                echo $this->Form->create(null,[
                                'url'=>['action' => 'index']
                                ,'class' => 'form-inline'
                            ]); ?>
                            
                            <fieldset>
                            <?php
                            echo $this->Form->input('category',[
                                'label'=>'種別　　',
                                'options'=> [
                                    'staffs'=>'スタッフ',
                                    'business_partners'=>'業務取引先',
                                    'orders'=>'注文データ',
                                ]
                            ]);
                            ?>&nbsp;&nbsp;&nbsp;&nbsp;    
                            <?php
                            echo $this->Form->button('　データをアップロード',
                            [
                                'class' => 'btn btn-primary glyphicon glyphicon-upload',
                                'type' => 'button',
                                'id' => 'dataimportBtn',
                                'onclick' =>"Javascript:importFileData();return false;"
                            ]);
                            ?>
                            </fieldset>

                            <?php echo $this->Form->end(); ?>  
                            
                            </div> 
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div> 
            </div>
            <div class="row voffset3">
                <div class="col-md-12"> 
                    <?php if(isset($upload_file)):  ?>			
                        <table id="list" class="scroll"></table> 
                        <div id="pager" class="scroll" style="text-align:center;"></div> 
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</section>

<!-- モーダルウィンドウ -->
<div id="jquery-ui-dialog" title="インポート結果">
<p>以下の通りEXCELデータをインポートしました：</p>


  <p class="message ">

  </p>


</div>