<section class="content-header">
<h1>
ユーザー情報
<small>登録されているユーザー情報を表示します</small>
</h1>
</section>
<!-- Main content -->

<section class="content voffset4 ">
 <div class="col-md-7">  


    <div class="clearfix">
    <div class="pull-left">
    <?= $this->Html->link('　編集',[
    'action' => 'edit',$user->id
    ],
    ['class' => 'btn btn-success  glyphicon glyphicon-pencil']);
   ?>&nbsp;&nbsp;&nbsp;    
     <?php if($Auth->user('role') === 'admin'): ?>
    <?= $this->Html->link(__('ユーザー一覧に戻る'), ['action' => 'index'],
    ['class' => 'btn btn-default  glyphicon glyphicon-table']) ?>  
      <?php endif; ?>     
   </div></div>

   
   <div class="view table voffset4">
      <table class="table vertical-table table-bordered">
            <tr class="bg-gray">
            <th scope="row">項目名</th>
            <td>データ</td>
            </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>            
        <tr>
            <th scope="row"><?= __('ログイン名') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('氏名') ?></th>
            <td><?= h($user->formal_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('権限') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('作成日') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('最終更新日') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>                                        
        </table>
    
   </div>
   
   </div> 
</section>
