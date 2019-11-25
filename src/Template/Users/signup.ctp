<?php $this->layout = 'AdminLTE.register'; ?>
<?php echo $this->Form->create(); ?>
  <div class="form-group has-feedback">
    <input type="text" class="form-control" placeholder="氏名">
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="username" class="form-control" placeholder="ログイン名">
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="パスワード">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="もう一度パスワード入力">
    <span class="glyphicon glyphicon-repeat form-control-feedback"></span>
  </div>
  <div class="row">
    <div class="col-xs-8">
    <?= $this->Html->link( __('ユーザー登録済みの方'), ['controller' => 'users', 'action' => 'login']) ?>        

      <!-- <div class="checkbox icheck">
        <label>
          <input type="checkbox"> I agree to the <a href="#">terms</a>
        </label>
      </div> -->
    </div>
    <!-- /.col -->
    <div class="col-xs-4 pull-right">
      <button type="submit" class="btn btn-primary btn-block btn-flat">新規登録</button>
    </div>
    <!-- /.col -->
  </div>
<?php echo $this->Form->end(); ?>