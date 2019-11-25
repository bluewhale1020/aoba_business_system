<?php $this->layout = 'tutorial'; ?>
<section class="content-header" id="introduction">
    <div id="alert_div"></div>
    <h1>お知らせ機能
    
    <small>優先的に処理すべき処理待ち情報をリストアップします</small>
    </h1>
</section>

<section class="content voffset4">
<div class="row">
<div class="col-md-12">

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">お知らせリスト</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【お知らせリスト画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/notice.png') ?>" data-lightbox="notice" data-title="お知らせリスト画面">
            <?php
                echo $this->Html->image("manual/notice.png");
            ?>    
        </a>
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <p>トップナビ右端のベルのアイコンをクリックすると、お知らせリストが表示されます。<br>ここには次のカテゴリ情報がリストアップされます。</p>
            <dl><dt>間近の未確定注文</dt>
            <dd>
            まだ正式登録されていない注文のうち、作業開始日が間近に迫っているもの
            </dd></dl>
            <dl><dt>期間終了未完了作業</dt>
            <dd>
            作業期間が終了している受注業務のうち、まだ作業完了の登録がされていないもの
            </dd></dl>
            <dl><dt>完了未請求注文</dt>
            <dd>
            作業完了している受注業務のうち、まだ請求処理が行われていないもの
            </dd></dl>
            <dl><dt>締切後未回収請求</dt>
            <dd>
            作成された請求書のうち、支払い締切日を過ぎてもまだ債権が未回収のもの
            </dd></dl>

            <p>各リストをクリックすると、関連するページに移動します。</p>

            <div class="callout callout-warning voffset5">
                <h4>注意!</h4>
                <p>リストに表示されている情報は比較的に緊急性の強いものなので、他に優先して処理してください。</p>
            </div>
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

</div>
</div>
</section>