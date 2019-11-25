<section class="content-header">
<h1>
登録スタッフ情報
<small>登録されているスタッフの情報を表示します</small>
</h1>
</section>
<section class="content voffset4 ">
 <div class="col-md-7">  
    <div class="clearfix">
    <div class="pull-left">
    <?= $this->Html->link('　編集',[
    'action' => 'edit',$staff->id
    ],
    ['class' => 'btn btn-success  glyphicon glyphicon-pencil']);
   ?>&nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('スタッフ一覧に戻る'), ['action' => 'index'],
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
            <td><?= $this->Number->format($staff->id) ?></td>
        </tr>            
        <tr>
            <th scope="row"><?= __('氏名') ?></th>
            <td><?= h($staff->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('フリガナ') ?></th>
            <td><?= h($staff->kana) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('生年月日') ?></th>
            <td><?= h($staff->birth_date) ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('性別') ?></th>
            <td><?php
                if(isset($staff->sex)){
                    if($staff->sex == 1){
                        echo "男";
                        
                    }  elseif($staff->sex == 2){
                        echo "女";
                    }
                }
             ?></td>
        </tr>                 
        <tr>
            <th scope="row"><?= __('電話番号') ?></th>
            <td><?= h($staff->tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('郵便番号') ?></th>
            <td><?= h($staff->postal_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('住所') ?></th>
            <td><?= h($staff->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('番地') ?></th>
            <td><?= h($staff->banchi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('建物名') ?></th>
            <td><?= h($staff->tatemono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('職種１') ?></th>
                <td><?php
           
                echo $staff->has('Occupation1') ? $staff->Occupation1->name : '' ?></td>

        </tr>
        <tr>
            <th scope="row"><?= __('職種２') ?></th>
                <td><?php
                echo $staff->has('Occupation2') ? $staff->Occupation2->name : '' ?></td> 
        </tr>        
        <tr>
            <th scope="row"><?= __('肩書') ?></th>
            <td><?= $staff->has('title') ? $staff->title->name : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('備考') ?></th>
            <td><?= h($staff->notes) ?></td>
        </tr>
           
            
                                         
        </table>
    
   </div>
   
   </div> 
</section>

