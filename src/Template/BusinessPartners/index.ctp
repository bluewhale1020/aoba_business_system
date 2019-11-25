<section class="content-header">
<h1>
取引先一覧
<small>登録されている取引先一覧を管理します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">取引先一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 取引先新規登録',[
    'action' => 'add'
],
[
    'class' => 'btn btn-success glyphicon glyphicon-plus']

);
?>
        
    </h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
  
  <div class="col-md-5 pull-right">   
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
  echo $this->Form->input('名称');
  ?>&nbsp;&nbsp;&nbsp;&nbsp;

  <?php
  echo $this->Form->input('取引先種別',[
    'options'=> ['is_client'=>'請負元','is_work_place'=>'派遣先','is_supplier'=>'仕入先'], 'empty' => '--'
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
   
  <div class="business_partner-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-navy disabled">
                <th ><?= __('id') ?></th>
                <th ><?= __('名称') ?></th>
                <th ><?= __('部署名') ?></th>
                <th ><?= __('電話番号') ?></th>
                <th ><?= __('請負元') ?></th>
                <th ><?= __('派遣先') ?></th>
                <th ><?= __('仕入先') ?></th>
                <th ><?= __('備考') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php foreach ($businessPartners as $businessPartner): ?>
            <tr>
                <td><?= $this->Number->format($businessPartner->id) ?></td>
                <td><?= h($businessPartner->name) ?></td>
                 <td><?= h($businessPartner->department) ?></td>     
                <td><?= h($businessPartner->tel) ?></td>
       
<td><?php
  if($businessPartner->is_client){
      echo "✔";
  }
?></td>
<td><?php
  if($businessPartner->is_work_place){
      echo "✔";
  }
?></td>
<td><?php
  if($businessPartner->is_supplier){
      echo "✔";
  }
?></td>
                <td><?= h($businessPartner->notes) ?></td>
                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $businessPartner->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $businessPartner->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $businessPartner->id],
                     ['confirm' => __('本当に # {0}の取引先を削除して宜しいでしょうか?', $businessPartner->id),
                    'class' => 'btn btn-danger glyphicon glyphicon-remove']) ?>
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

