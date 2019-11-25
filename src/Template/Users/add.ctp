<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
ユーザーの新規作成
<small>ユーザーを新規に作成します</small>
</h1>
</section>

<section class="content voffset4">

    <?= $this->Form->create($user,[
    'class' => 'form-horizontal'
    ]) ?>
<div class="col-md-10">
    <fieldset>
        <legend><?= __('ユーザー新規作成フォーム') ?></legend>
        <?php
          echo $this->Form->input('formal_name', [
            'type' => 'text',
            'label' => '氏名']);
          echo $this->Form->input('username', [
            'type' => 'text',
            'label' => 'ログイン名']);
          echo $this->Form->input('password', [
            'type' => 'password',
            'label' => 'パスワード']);
            // if($Auth->user('role') === 'admin'){
              echo $this->Form->input('role', [
                'label' => '権限',
                'options' => ['user' =>'user','admin' =>'admin']]);          

            // }
       
        ?>
    </fieldset>
    <hr />

    <div class="pull-right">
    <?= $this->Form->button(__('これで新規作成'),[
        'class' => 'btn btn-success'
    ]  ) ?>
    &nbsp;&nbsp;&nbsp;    
<?= $this->Html->link(__('キャンセル'), ['action' => 'index'],
    ['class' => 'btn btn-default ']) ?> 
    </div>
    <?= $this->Form->end() ?>
</div>
</section>
