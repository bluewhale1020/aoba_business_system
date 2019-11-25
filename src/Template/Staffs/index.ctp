<section class="content-header">
<h1>
スタッフ一覧
<small>登録されているスタッフを管理します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">スタッフ一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 新規スタッフ',[
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
  echo $this->Form->input('職種',[
    'options'=> $occupations, 'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('肩書',[
    'options'=> $titles, 'empty' => '--'
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
   
  <div class="equipment-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-navy disabled">
                <th ><?= __('id') ?></th>
                <th ><?= __('氏名') ?></th>
                <th ><?= __('フリガナ') ?></th>
                <th ><?= __('性別') ?></th>
                <th ><?= __('電話番号') ?></th>
                <th ><?= __('職種１') ?></th>
                <th ><?= __('職種２') ?></th>
                <th ><?= __('肩書') ?></th>
                <th ><?= __('備考') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php foreach ($staffs as $staff): ?>
            <tr>
                <td><?= $this->Number->format($staff->id) ?></td>
                <td><?= h($staff->name) ?></td>
                <td><?= h($staff->kana) ?></td>
            <td><?php
                if(isset($staff->sex)){
                    if($staff->sex == 1){
                        echo "男";
                        
                    }  elseif($staff->sex == 2){
                        echo "女";
                    }
                }
             ?></td>                
                <td><?= h($staff->tel) ?></td>
                <td><?php
                 echo $staff->has('Occupation1') ? $staff->Occupation1->name : '' ?></td>
                <td><?php
                echo $staff->has('Occupation2') ? $staff->Occupation2->name : '' ?></td>                
                <td><?= $staff->has('title') ? $staff->title->name : '' ?></td>
                <td><?= h($staff->notes) ?></td>
                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $staff->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $staff->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $staff->id],
                     ['confirm' => __('本当に # {0}のスタッフを削除して宜しいでしょうか?', $staff->id),
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
