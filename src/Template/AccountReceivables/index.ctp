<script type="text/javascript">



$(document).ready(function(){  

     

});

function print_account_receivable(){
  
//検索条件取得
var year = $("[name=date\\[year\\]]").val();
var month = $("[name=date\\[month\\]]").val();
var business_partner_id = $("[name=請求先]").val();

 var Url = "/aoba_business_system/printers/print_account_receivable/" + year + "/" + month + "/" + business_partner_id;
 //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字


 location.href= Url;

}
  

</script>
<section class="content-header">
<h1>
売掛金データ一覧
<small>設定した月の請求先ごとの売掛金を管理します</small>
<div class="pull-right">
    <?php 

     echo $this->Form->button(' 売掛金管理表', array(
    'type' => 'button',
    'div' => false,
    'class' => 'btn btn-warning',
    'onclick' =>"Javascript:print_account_receivable();return false;"
));     ?>
</div>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">売掛金管理一覧&nbsp;&nbsp;&nbsp;&nbsp;
        
    </h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
  
  <div class=" pull-right col-md-8">   
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
  
  echo $this->Form->input('請求先',[
    'options'=> $payers, 'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->button('検索',['class' => 'btn-primary']);
  ?>
  </fieldset>


  <?php echo $this->Form->end(); ?>  
 
</div> 
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div> 
   
  <div class="account-receivable-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>        

             <tr class="bg-orange">
                <th ><?= __('請求先名') ?></th>
                <th ><?= __('売上高') ?></th>
                <th ><?= __('請求額') ?></th>
                <th ><?= __('未請求残高') ?></th>
                <th ><?= __('回収高') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>

             <?php 
             $fmt_option = ['after' => ' 円'];
             foreach ($accountReceivables as $payer_id => $accountReceivable): ?>
            <tr>
                  <td><?= $accountReceivable['payer_name']; ?></td>
                <td><?=  $this->Number->format($accountReceivable['sales'],$fmt_option); ?></td> 
                <td><?=  $this->Number->format($accountReceivable['charged'],$fmt_option); ?></td> 
                <td><?php
                $unbilled = $accountReceivable['sales'] -  $accountReceivable['charged']; 
                echo $this->Number->format($unbilled,$fmt_option); ?> </td>                
                <td><?= $this->Number->format($accountReceivable['received'],$fmt_option); ?></td>                                 

                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__(' 　請求処理'), ['controller'=>'Bills','action' => 'index', $payer_id,
                    $this->request->data['date']['year'],$this->request->data['date']['month']],
                    ['class' => 'btn btn-danger fa fa-credit-card']) ?>

                    </div>
                </td>
            </tr>
            <?php endforeach; ?>         
          
      </tbody>      
      
  </table>
  <div class="paginator">
    <ul class="pagination">
    <?php
    $this->Paginator->options(['url'=> ['action'=>'index','usePaging'=>1]]);            
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

