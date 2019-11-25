<?php $this->layout = 'tutorial'; ?>
<section class="content-header" id="introduction">
    <div id="alert_div"></div>
    <h1>ユーザー認証・アクセス制限
    
    <small>システムへのログイン方法と役柄によるアクセスの制限について</small>
    </h1>
</section>

<section class="content voffset4">
<div class="row">
<div class="col-md-12">

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">ユーザー認証</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【ログイン画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/login.png') ?>" data-lightbox="login" data-title="ログイン画面">
            <?php
                echo $this->Html->image("manual/login.png");
            ?>    
        </a>
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
        <legend>ログイン方法</legend>
            <ol>
                <li>ログイン画面で、「ユーザー名」と「パスワード」欄に入力して「ログイン」ボタンを押す。</li>
                <li>入力情報が正しければ認証されて、システムのトップ画面（ダッシュボード）に移動する。</li>
            </ol>    
            <div class="box box-default voffset4">
            <div class="box-header with-border">
              <h3 class="box-title">登録済みアカウント</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt><strong>ユーザー名</strong></dt>
                    <dd>user</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt><strong>パスワード</strong></dt>
                    <dd>password</dd>
                </dl>
            </div>
            <!-- /.box-body -->
          </div>
            <div class="callout callout-warning voffset3">
                <h4>注意!</h4>
                <p>ログイン後、一定時間作業をしない場合、セッションの有効期限が切れて、再度ログインする必要があります。</p>
            </div>


        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">アクセス制限</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

    <div class="col-md-12 text-large">
        <div>
        <p>アカウントの役柄によりアクセスが制限されます。</p>
        <dl class="dl-horizontal">
            <dt><strong>user</strong></dt>
            <dd>一般ユーザー用。業務処理に必要なページにアクセス可能。</dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><strong>admin</strong></dt>
            <dd>管理者用。ユーザー権限の他、管理用のページにアクセス可能。</dd>
        </dl>
        
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

</div>
</div>
</section>