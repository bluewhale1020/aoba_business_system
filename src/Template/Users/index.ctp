<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    ユーザー

    <div class="pull-right"><?php echo $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-xs']) ?></div>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo __('ユーザー一覧'); ?></h3>

          <div class="box-tools">
            <?php
              echo $this->Form->create(null,['url'=>['action' => 'index'],'id'=>'search_form']); 
              // テンプレート設定
              $this->Form->templates([
                'formGroup' => '{{input}}',
                'inputContainer' => '{{content}}',
              ]);              
              
              ?>
            <div class="input-group input-group-sm" style="width: 150px;">
            <?php   echo $this->Form->input('table_search',['placeholder'=> __('Search'),
                      'class' => 'form-control pull-right','label'=>false
                    ]);
            ?>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div>
              <?php echo $this->Form->end(); ?> 
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('ユーザー名') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('役柄') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('正式名称') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('作成日') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('最終更新日') ?></th>
                  <th scope="col" class="actions text-center"><?= __('操作') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= $this->Number->format($user->id) ?></td>
                  <td><?= h($user->username) ?></td>
                  <td><?= h($user->role) ?></td>
                  <td><?= h($user->formal_name) ?></td>
                  <td><?= h($user->created->format("Y/m/d")) ?></td>
                  <td><?= h($user->modified->format("Y/m/d")) ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $user->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class'=>'btn btn-danger btn-xs']) ?>
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
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>