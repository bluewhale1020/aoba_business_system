<section class="content-header">
<h1>
ユーザー情報
<small>登録されているユーザー情報を表示します</small>
</h1>
</section>
<!-- Main content -->

<section class="content voffset4 ">
<div class="row">
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
            <td><?= h($user->created->format("Y/m/d")) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('最終更新日') ?></th>
            <td><?= h($user->modified->format("Y/m/d")) ?></td>
        </tr>                                        
        </table>
    
   </div>
   
  </div>
</div>

<div class="row">
    <div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">ログ一覧</h3>
            <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body"> 
        
        <div class="eventlog-table">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="bg-navy disabled">
                    <th ><?= __('id') ?></th>
                    <th ><?= __('作成日時') ?></th>
                    <th ><?= __('イベント') ?></th>
                    <th ><?= __('テーブル名') ?></th>
                    <th ><?= __('レコードID') ?></th>
                    <th ><?= __('IPアドレス') ?></th>
                </tr>         
            </thead>
            <tbody>
                <?php foreach ($eventLogs as $eventLog): ?>
                <tr>
                    <td><?= $this->Number->format($eventLog->id) ?></td>
                    <td><?= h($eventLog->created->format("Y/m/d H:i:s")) ?></td>
                    <td><?= h($eventLog->event) ?></td>
                    <td><?= h($eventLog->table_name) ?></td>
                    <td>
                        <?php 
                        
                        if (in_array($eventLog->action_type,['login','logout'])) {         

                        }else if($eventLog->event != "delete"){
                            echo $this->Html->link($eventLog->record_id,[
                            'controller'=>$eventLog->table_name, 'action' => 'view',$eventLog->record_id
                        ]);                        
                        }else{
                            echo $eventLog->record_id;
                        }
                    ?></td>
                    <td><?= h($eventLog->remote_addr) ?></td>
                </tr>
                <?php endforeach; ?> 
            </tbody>      
            
        </table>      
        <div class="paginator">
            <ul class="pagination">
                <?php
                    $this->Paginator->options(['url'=> ['action'=>'view',$user->id,'usePaging'=>1]]);            
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
