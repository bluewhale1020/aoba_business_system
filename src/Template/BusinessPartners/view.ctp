<style type="text/css" media="screen">
	.contract_rate{
	    max-height:550px;
	    overflow-y: scroll;
	}
	.contract_rate td{
	    text-align:right;
	}
</style>
<section class="content-header">
<h1>
登録取引先情報
<small>登録されている取引先の情報を表示します</small>
</h1>
</section>
<section class="content voffset4 ">
<div class="clearfix">  
 <div class="col-md-6"> 
      <h3>取引先詳細</h3>
    <div class="clearfix">
    <div class="pull-left">
    <?= $this->Html->link('　編集',[
    'action' => 'edit',$businessPartner->id
    ],
    ['class' => 'btn btn-success  glyphicon glyphicon-pencil']);
   ?>&nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('取引先一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?>       
   </div></div> 
   <div class="view table voffset4">
      <table class="table vertical-table table-bordered">
            <tr class="bg-navy disabled">
            <th scope="row">項目名</th>
            <td>データ</td>
            </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($businessPartner->id) ?></td>
        </tr>            
        <tr>
            <th scope="row"><?= __('名称') ?></th>
            <td><?= h($businessPartner->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('フリガナ') ?></th>
            <td><?= h($businessPartner->kana) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('電話番号') ?></th>
            <td><?= h($businessPartner->tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fax') ?></th>
            <td><?= h($businessPartner->fax) ?></td>
        </tr>        
        <tr>
            <th scope="row"><?= __('郵便番号') ?></th>
            <td><?= h($businessPartner->postal_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('住所') ?></th>
            <td><?= h($businessPartner->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('番地') ?></th>
            <td><?= h($businessPartner->banchi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('建物名') ?></th>
            <td><?= h($businessPartner->tatemono) ?></td>
        </tr>
        

        <tr>
            <th scope="row"><?= __('部署名') ?></th>
            <td><?= h($businessPartner->department) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('担当者') ?></th>
            <td><?= h($businessPartner->staff . "　　　" . $businessPartner->staff2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('担当者 連絡先') ?></th>
            <td><?= h($businessPartner->staff_tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DR') ?></th>
            <td><?= h($businessPartner->dr) ?></td>
        </tr>
<?php
  if($businessPartner->is_client): ?>
      
        <tr>
            <th scope="row"><?= __('請負元') ?></th>
<td>✔</td>
        </tr>
<?php endif; ?>
<?php
  if($businessPartner->is_work_place): ?>
      
        <tr>
            <th scope="row"><?= __('派遣先') ?></th>
<td>✔</td>
        </tr>
<?php endif; ?>
<?php
  if($businessPartner->is_supplier): ?>
      
        <tr>
            <th scope="row"><?= __('仕入先') ?></th>
<td>✔</td>
        </tr>
<?php endif; ?>
          <tr>
            <th scope="row"><?= __('定休日（曜日）') ?></th>
            <td><?php
            if(!empty($businessPartner->holiday_numbers) or  $businessPartner->holiday_numbers === '0'){
                 $week_nums = explode(",", $businessPartner->holiday_numbers ) ;  
                $weekArray = ['0'=>"日",'1'=>"月",'2'=>"火",'3'=>"水",'4'=>"木",
                '5'=>"金",'6'=>"土"];
       
                  foreach ($week_nums as $key => $value) {
                    $week_nums[$key] = $weekArray[$value];
                }  
                  echo implode("　　", $week_nums);               
            }
        
             ?></td>
        </tr>
         <tr>
            <th scope="row"><?= __('定休日（特定日）') ?></th>
            <td>
            <?php
            if(!empty($businessPartner->specific_holidays)){
                $given_holidays = explode(",", $businessPartner->specific_holidays);
                echo implode(" ・ ",$given_holidays);
            }
             ?>            
            </td>
        </tr>               
         <tr>
            <th scope="row"><?= __('備考') ?></th>
            <td><?= h($businessPartner->notes) ?></td>
        </tr>
           
            
                                         
        </table>
    
   </div>
   
   </div><!-- col-md-6 -->
 
  <div class="col-md-6">  
    <h3>業務契約料金表</h3>
    
      <div class="clearfix">
    <div class="pull-left">
    <?= $this->Html->link('　設定する',[
    'controller' => 'contract_rates','action' => 'manage',$businessPartner->id
    ],
    ['class' => 'btn btn-success  glyphicon glyphicon-pencil']);
   ?>&nbsp;&nbsp;&nbsp;    
    <?php
    if(!empty($businessPartner->contract_rates)){
     echo $this->Form->postLink(__('　クリア'), ['controller' => 'contract_rates','action' => 'delete', $businessPartner->id],
     ['confirm' => __('本当に契約料金の設定をクリアして宜しいでしょうか?'),
    'class' => 'btn btn-danger glyphicon glyphicon-remove']);       
    }
 ?>      
   </div></div> 
  <div class="contract_rate table voffset4">
    

        <?php if(!empty($businessPartner->contract_rates)): ?>
        
        <?php $contractRate = $businessPartner->contract_rates[0]; ?>
        
            <table class="table vertical-table table-bordered">
            <tr class="bg-orange">
                <th scope="row">部位</th><th scope="row">装置種類</th><th scope="row">撮影方法</th>
            <th scope="row">項目名</th>
            <td>数量</td>
            </tr>
        <tr><th scope="row" rowspan="16" class="bg-success"><?= __('胸部') ?></th><th scope="row" rowspan="10" class="bg-success"><?= __('可搬') ?></th>
            <th scope="row" rowspan="5" class="bg-info"><?= __('間接') ?></th>
            <th scope="row" class="bg-info"><?= __('保証料金') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->guaranty_charge_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('保証人数') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->guaranty_count_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('追加料金単価') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->additional_unit_price_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('可搬費') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('当日') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->appointed_day_cost_chest_i_por) ?></td>
        </tr>
        <tr>
            <th scope="row" rowspan="5"><?= __('デジタル') ?></th>
          <th scope="row"><?= __('保証料金') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('保証人数') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('追加料金単価') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('可搬費') ?></th>
            <td><?= $this->Number->format($contractRate->transportable_equipment_cost_chest_dg_por) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('当日') ?></th>
            <td><?= $this->Number->format($contractRate->appointed_day_cost_chest_dg_por) ?></td>
        </tr>

        <tr>
            <th scope="row" rowspan="6" class="bg-success"><?= __('レントゲン車') ?></th><th scope="row" rowspan="3" class="bg-info"><?= __('デジタル') ?></th>
            <th scope="row" class="bg-info"><?= __('保証料金') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->guaranty_charge_chest_dg_car) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('保証人数') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->guaranty_count_chest_dg_car) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('追加料金単価') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->additional_unit_price_chest_dg_car) ?></td>
        </tr>
        <tr>
            <th scope="row" rowspan="3"><?= __('直接') ?></th>
            <th scope="row"><?= __('保証料金') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_chest_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('保証人数') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_chest_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('追加料金単価') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_chest_dr_car) ?></td>
        </tr>
        <tr><th scope="row" rowspan="6" class="bg-danger"><?= __('胃部') ?></th><th scope="row" rowspan="6" class="bg-danger"><?= __('レントゲン車') ?></th>
            <th scope="row" rowspan="3" class="bg-info"><?= __('間接（８枚）') ?></th>
            <th scope="row" class="bg-info"><?= __('保証料金') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->guaranty_charge_stom_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('保証人数') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->guaranty_count_stom_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row" class="bg-info"><?= __('追加料金単価') ?></th>
            <td class="bg-info"><?= $this->Number->format($contractRate->additional_unit_price_stom_i_car) ?></td>
        </tr>
        <tr>
            <th scope="row" rowspan="3"><?= __('直接') ?></th>
            <th scope="row"><?= __('保証料金') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_charge_stom_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('保証人数') ?></th>
            <td><?= $this->Number->format($contractRate->guaranty_count_stom_dr_car) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('追加料金単価') ?></th>
            <td><?= $this->Number->format($contractRate->additional_unit_price_stom_dr_car) ?></td>
        </tr>
        <tr class="bg-info"><th scope="row"  colspan="3"><?= __('その他') ?></th>
            <th scope="row"><?= __('稼働費') ?></th>
            <td><?= $this->Number->format($contractRate->operating_cost) ?></td>
        </tr>    </table> 
     <?php else: ?>
<div class="callout callout-warning">
<h4><i class="icon fa fa-warning"></i>　通知</h4>
<p>業務契約料金の設定データがありません。</p>
</div>         
        
     <?php endif; ?>   
        
  
   
       
       
   </div>
   
   </div>
 
 </div>  
 
   
    
   
 <div class="col-md-12 ">

<?php if(!empty($businessPartner->child_business_partners)): ?>     
 <div class="box box-info ">
  <div class="box-header with-border">
    <h3 class="box-title">派遣先事業所一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 派遣先事業所新規登録',[
    'action' => 'add',$businessPartner->id
],
[
    'class' => 'btn btn-success glyphicon glyphicon-plus']

);
?>
        
    </h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->    
  </div><!-- /.box-header -->
  <div class="box-body">
  
  
  <div class="business_partner-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-navy">
                <th ><?= __('id') ?></th>
                <th ><?= __('名称') ?></th>
                <th ><?= __('部署名') ?></th>
                <th ><?= __('電話番号') ?></th>
                 <th ><?= __('住所') ?></th>
                <th ><?= __('備考') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php 
                foreach ($businessPartner->child_business_partners as $childPartner): ?>
            <tr>
                <td><?= $this->Number->format($childPartner->id) ?></td>
                <td><?= h($childPartner->name) ?></td>
                 <td><?= h($childPartner->department) ?></td>     
                <td><?= h($childPartner->tel) ?></td>
                <td><?php
                    $address = $childPartner->address . $childPartner->banchi . $childPartner->tatemono;
                    echo $address;
                
                 ?></td>                
                <td><?= h($childPartner->notes) ?></td>
                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $childPartner->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $childPartner->id,$businessPartner->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $childPartner->id],
                     ['confirm' => __('本当に # {0}の取引先を削除して宜しいでしょうか?', $childPartner->id),
                    'class' => 'btn btn-danger glyphicon glyphicon-remove']) ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>         
          
      </tbody>      
      
  </table>
      
      
  </div>
    
    
    
  </div><!-- /.box-body -->
  <div class="box-footer">
    
  </div><!-- box-footer -->
</div><!-- /.box -->
<?php endif; ?>
   
<?php if(!empty($businessPartner->parent_business_partner)): ?>
 <div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">元請け企業・団体一覧表&nbsp;&nbsp;&nbsp;&nbsp;
        
    </h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  
  
  <div class="business_partner-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-purple">
                <th ><?= __('id') ?></th>
                <th ><?= __('名称') ?></th>
                <th ><?= __('部署名') ?></th>
                <th ><?= __('電話番号') ?></th>
                <th ><?= __('住所') ?></th>
                 <th ><?= __('備考') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php 
                $parent_partner = $businessPartner->parent_business_partner; ?>
            <tr>
                <td><?= $this->Number->format($parent_partner->id) ?></td>
                <td><?= h($parent_partner->name) ?></td>
                 <td><?= h($parent_partner->department) ?></td>     
                <td><?= h($parent_partner->tel) ?></td>
                <td><?php
                    $address = $parent_partner->address . $parent_partner->banchi . $parent_partner->tatemono;
                    echo $address;
                
                 ?></td>
                
                <td><?= h($parent_partner->notes) ?></td>
                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $parent_partner->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $parent_partner->id,$businessPartner->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $parent_partner->id],
                     ['confirm' => __('本当に # {0}の取引先を削除して宜しいでしょうか?', $parent_partner->id),
                    'class' => 'btn btn-danger glyphicon glyphicon-remove']) ?>
                    </div>
                </td>
            </tr>
         
      </tbody>      
      
  </table>
      
      
  </div>
    
    
    
  </div><!-- /.box-body -->
  <div class="box-footer">
    
  </div><!-- box-footer -->
</div><!-- /.box --> 
<?php endif; ?>

 
</div>

  
</section>

