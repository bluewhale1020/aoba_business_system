<p class="login-box-msg"><?php echo __('開始するには、ログインしてください') ?></p>
<?= $this->Form->create() ?>
<div class="form-group has-feedback">
    <?= $this->Form->input('username', [
        'label' => false,
        'class' => 'form-control',
        'placeholder' => __('ユーザー名'),
        'required' => true
    ]) ?>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
    <?= $this->Form->input('password', [
        'label' => false,
        'class' => 'form-control',
        'placeholder' => __('パスワード'),
        'required' => true
    ]) ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">
    <div class="col-xs-8">
        <!-- <div class="checkbox icheck">
            <label>
                <?= $this->Form->checkbox('remember', [
                    'label' => false,
                ]) ?>
                <?= __('ログイン情報を記憶') ?>
            </label>
        </div> -->
    </div><!-- /.col -->
    <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat"><?= __('ログイン') ?></button>
    </div><!-- /.col -->
</div>
<?= $this->Form->end() ?>

<?php
/*
<a href="#">I forgot my password</a><br>
<a href="register.html" class="text-center">Register a new membership</a>
*/
?>

<?php
// $this->Html->scriptStart(['block' => true]);
// echo '$(function () {
        // $("input").iCheck({
            // checkboxClass: "icheckbox_square-blue",
        // });
    // });';
// $this->Html->scriptEnd();
?>
