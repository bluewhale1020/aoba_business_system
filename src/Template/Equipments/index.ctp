<section class="content-header">
<h1>
装置一覧
<small>業務で使用する装置を管理します</small>
</h1>
</section>
<section class="content voffset4">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">装置一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 新規装置',[
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
  
  <div class="col-md-6 pull-right">   
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
  echo $this->Form->input('装置種類',[
    'options'=> $equipmentTypes, 'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('撮影種類',[
    'options'=> $xrayTypes, 'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('状態',[
    'options'=> $statuses, 'empty' => '--'
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
                <!-- <th ><?//= __('id') ?></th> -->
                <th ><?= __('装置番号') ?></th>
                <th ><?= __('装置名称') ?></th>
                <th ><?= __('装置種類') ?></th>
                <th ><?= __('撮影種類') ?></th>
                <th ><?= __('可搬性') ?></th>
                <th ><?= __('使用頻度') ?></th>
                <th ><?= __('状態') ?></th>
                <th ><?= __('備考') ?></th>
                <th  class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
             <?php foreach ($equipments as $equipment): ?>
            <tr>
                <!-- <td><?//= $this->Number->format($equipment->id) ?></td> -->
                <td><?= $this->Number->format($equipment->equipment_no) ?></td>
                <td><?= h($equipment->name) ?></td>
                <td><?= $equipment->has('equipment_type') ? $equipment->equipment_type->name : '' ?></td>
                <td><?php
                if(isset($equipment->xray_type)){
                    echo $equipment->xray_type->name;
                  //   if($equipment->xray_type == 1){
                  //       echo "直接";
                        
                  //   }  elseif($equipment->xray_type == 2){
                  //       echo "間接";
                  //   }  elseif($equipment->xray_type == 3){
                  //     echo "デジタル";
                  // }
                } ?></td>
                <td><?php 
                if(isset($equipment->transportable)){
                    if($equipment->transportable == 1){
                        echo "あり";
                        
                    }  else{
                        echo "無し";
                    }
                }
                 ?></td>
                <td><?= $this->Number->format($equipment->number_of_times) ?></td>
                <td><?= $equipment->has('status') ? $equipment->status->name : '' ?></td>
                <td><?= h($equipment->notes) ?></td>
                <td class="actions text-center">
                    <div class="btn-group">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $equipment->id],
                    ['class' => 'btn btn-info glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $equipment->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $equipment->id],
                     ['confirm' => __('本当に # {0}の装置を削除して宜しいでしょうか?', $equipment->id),
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
            
            
            
        </div>       
        
    </div>

</section>

