<section class="content-header">
<h1>
新規受注
<small>注文データを新規登録します</small>
</h1>
</section>
<section class="content voffset4">

    <?= $this->Form->create($order,[
    'class' => 'form-horizontal'
    ]) ?>

<div class="clearfix">
    <h3>基本情報</h3>
    <div class="col-md-6">
        <?php
             echo $this->Form->input('order_no',[
             'label' => '受注No']);       
        
            echo $this->Form->input('client_id',[
            'label' => '請負元',
            'empty' => '--',
            'options'=>$clients
            ]);
             echo $this->Form->input('work_place_id',[
             'label' => '派遣先',
             'empty' => '請負元を選択',
             'option' =>$workPlaces
            ]);   
        ?>
        
    </div>
    
     <div class="col-md-6">
        <?php
            echo $this->Form->input('temporary_registration',[
                'options' =>['0' => '正式登録','1' => '仮登録'],
                'empty' => '--',
                'label' => 'ステータス'
            ]);
             echo $this->Form->input('recipient',[
             'label' => '届け先',
             'empty' => '--',
            'options'=>[
            '依頼元'=>'依頼元','事業所'=>'事業所']
            ]); 
             echo $this->Form->input('payment',[
             'label' => '請求先',
             'empty' => '--',
            'options'=>[
            '依頼元'=>'依頼元','事業所'=>'事業所']
            ]);                         
            echo $this->Form->input('notes',[
            'label' => '備考']);
            
            
        ?>         
         
     </div>   
</div>
<hr />

<div class="clearfix">
    <h3>実施期間</h3>
    <div class="col-md-6">
        <?php
             echo $this->Form->input('start_date',[
             'type' => 'hidden']);       
             echo $this->Form->input('end_date',[
             'type' => 'hidden']);             
            echo $this->Form->input('date_range',[
            'label' => '年月日期間',
             'append'=>'<i class="fa fa-calendar"></i>']);

        ?>
        
    </div>
    
     <div class="col-md-6">
         <div class="col-md-5">
        <?php
             echo $this->Form->input('start_time',[
             'type' => 'text',
             'label' => '時間帯',
             'append'=>'<i class="fa fa-clock-o"></i>']);       
         
        ?>               
         </div><div class="col-md-2 text-center">
             ～
         </div>    
             
         <div class="col-md-5">
        <?php
   
             echo $this->Form->input('end_time',[
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
        
             echo $this->Form->input('work_content_id',[
             'options' => $workContents,
             'empty' => '--',
             'label' => '業務内容'
             ]);       
        
            echo $this->Form->input('capturing_region_id',[
            'options'=>$capturingRegions,
            'empty' => '--',
            'label' => '撮影部位'
            ]);
            
            
             echo $this->Form->input('need_image_reading',[
             'label' => '読影',
             'empty' => '--',
            'options'=>['0' => 'なし','1' => 'あり']
            ]);
               
        ?>

        
    </div>
    
     <div class="col-md-6">
        <?php
            echo $this->Form->input('film_size_id',[
            'options'=>$filmSizes,
            'empty' => '--',
            'label' => 'フィルムサイズ'
            ]);
            echo $this->Form->input('patient_num',[
            'label' => '受診者数'
            ]);            
        ?>         
         
     </div>   
</div>
<hr />

<div class="clearfix accounts">
<h3>会計</h3>
    <div class="col-md-6">
        <?php
        
             echo $this->Form->input('guaranty_charge',[
             'label' => '保証料金'
             ]);       
        
             echo $this->Form->input('guaranty_count',[
             'label' => '保証人数'
             ]); 
               
        ?>

        
    </div>
    
     <div class="col-md-6">
        <?php
        
             echo $this->Form->input('additional_count',[
             'label' => '追加人数'
             ]);       
        
             echo $this->Form->input('additional_unit_price',[
             'label' => '追加料金単価'
             ]);           
        ?>         
         
     </div>   
</div>

<hr />

<div class="clearfix">
    <div class="col-md-6">
</div><div class="col-md-6">        
        <?php
             echo $this->Form->input('total',[
             'label' => '受注額合計',
             'readonly' => true
             ]);           
        ?>             
</div>
</div>
<div class="clearfix  well bg-gray voffset4">
    <div class="text-center">
    <?= $this->Form->button(__('新規登録'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('注文一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?> 
    </div>
</div>    
    <?= $this->Form->end() ?>

</section>




<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Works'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="works form large-9 medium-8 columns content">
    <?= $this->Form->create($work) ?>
    <fieldset>
        <legend><?= __('Add Work') ?></legend>
        <?php
            echo $this->Form->input('order_id', ['options' => $orders]);
            echo $this->Form->input('equipmentA_id');
            echo $this->Form->input('equipmentB_id');
            echo $this->Form->input('equipmentC_id');
            echo $this->Form->input('equipmentD_id');
            echo $this->Form->input('equipmentE_id');
            echo $this->Form->input('start_no');
            echo $this->Form->input('end_no');
            echo $this->Form->input('absent_nums');
            echo $this->Form->input('staff1_id');
            echo $this->Form->input('staff2_id');
            echo $this->Form->input('staff3_id');
            echo $this->Form->input('staff4_id');
            echo $this->Form->input('staff5_id');
            echo $this->Form->input('staff6_id');
            echo $this->Form->input('staff7_id');
            echo $this->Form->input('staff8_id');
            echo $this->Form->input('staff9_id');
            echo $this->Form->input('staff10_id');
            echo $this->Form->input('technician1_id');
            echo $this->Form->input('technician2_id');
            echo $this->Form->input('technician3_id');
            echo $this->Form->input('technician4_id');
            echo $this->Form->input('technician5_id');
            echo $this->Form->input('technician6_id');
            echo $this->Form->input('technician7_id');
            echo $this->Form->input('technician8_id');
            echo $this->Form->input('technician9_id');
            echo $this->Form->input('technician10_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
