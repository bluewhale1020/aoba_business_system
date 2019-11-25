<?php $this->layout = 'AdminLTE.login'; ?>
<?=$this->Form->create(null, ['url' => ['controller' => 'users', 'action' => 'login'], 'type' => 'post'])?>

<!-- <form action="<?php //echo $this->Url->build(['controller' => 'users', 'action' => 'login']); ?>" method="post"> -->
  <div class="form-group has-feedback">
    <input type="text" class="form-control" placeholder="ユーザー名" name="username">
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="パスワード" name="password">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>
  <div class="row">
    <!-- <div class="col-xs-8">
      <div class="checkbox icheck">
        <label>
          <input type="checkbox"> Remember Me
        </label>
      </div>
    </div> -->
    <!-- /.col -->
    <div class="col-xs-4 pull-right">
      <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
    </div>
    <!-- /.col -->
  </div>
<!-- </form> -->

<?=$this->Form->end()?>