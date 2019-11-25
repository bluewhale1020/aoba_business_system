<?= $this->Form->create($user) ?>
<div class="form-group has-feedback">
    <?= $this->Form->input('username', [
        'label' => false,
        'class' => 'form-control',
        'placeholder' => __('ログイン名入力')
    ]) ?>
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<?= $this->Form->input('role',['type'=>'hidden','value'=>'user']) ?>
<div class="form-group has-feedback">
    <?= $this->Form->input('formal_name', [
        'label' => false,
        'class' => 'form-control',
        'placeholder' => __('ユーザーの氏名を入力')
    ]) ?>
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
    <?= $this->Form->input('password', [
        'label' => false,
        'class' => 'form-control',
        'placeholder' => __('パスワード入力')
    ]) ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
    <?= $this->Form->input('confirm_password', [
        'label' => false,
        'class' => 'form-control',
        'type' => 'password',
        'placeholder' => __('もう一度パスワード入力')
    ]) ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">
    <div class="col-xs-7">
<?= $this->Html->link( __('ユーザー登録済みの方'), ['controller' => 'users', 'action' => 'login', '_full' => true]) ?>        

    </div><!-- /.col -->
    <div class="col-xs-5">
        <?= $this->Form->button( __('サインアップ'), [ 'class' => 'btn btn-primary btn-block btn-flat' ]) ?>
    </div><!-- /.col -->
</div>
<?= $this->Form->end() ?>
