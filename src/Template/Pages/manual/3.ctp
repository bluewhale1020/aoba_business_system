<?php $this->layout = 'tutorial'; ?>
<section class="content-header" id="introduction">
    <div id="alert_div"></div>
    <h1>マスターデータの管理
    
    <small>業務取引先・スタッフ・装置等、業務上利用する基本情報の管理を行います</small>
    </h1>
</section>

<section class="content voffset4">
<div class="row">
<div class="col-md-12">
<section>
<h3>対象カテゴリ</h3>

<ul class="text-large">
<li>業務取引先</li>
<li>X線照射装置</li>
<li>スタッフ</li>
</ul>

</section>
<hr>
<h3>各カテゴリでの管理方法</h3>
<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">レコード一覧</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【一覧画面　業務取引先】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/record_index.png') ?>" data-lightbox="record_index" data-title="一覧画面　業務取引先">
            <?php
                echo $this->Html->image("manual/record_index.png");
            ?>    
        </a>
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <p>一覧画面の表示（左サイドメニューの該当カテゴリ一覧をクリック）</p>
            <p>レコードの操作</p>
            <ul>
                <li>レコード新規登録</li>
                <li>レコード閲覧</li>
                <li>レコード編集</li>
                <li>レコード削除</li>
            </ul>    
        
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">レコード新規登録</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【新規登録画面　業務取引先】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/record_add.png') ?>" data-lightbox="record_add" data-title="新規登録画面　業務取引先">
            <?php
                echo $this->Html->image("manual/record_add.png");
            ?>    
        </a>        
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <ol>
                <li>一覧画面で「新規登録」ボタンをクリック</li> 
                <li>入力フォームに必要情報を入力</li>   
                <li>「新規登録」ボタンをクリックして入力情報を登録</li> 
            </ol>    
        
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">レコード編集</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【編集画面　業務取引先】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/record_edit.png') ?>" data-lightbox="record_edit" data-title="編集画面　業務取引先">
            <?php
                echo $this->Html->image("manual/record_edit.png");
            ?>    
        </a>           
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <ol>
                <li>一覧画面で該当レコードの「編集」ボタンをクリック</li> 
                <li>編集フォームに更新情報を入力</li>   
                <li>「これで編集する」ボタンをクリックして更新情報を保存</li> 
            </ol>    
        
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">レコード削除</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【削除ダイアローグ　業務取引先】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/record_delete.png') ?>" data-lightbox="record_delete" data-title="削除ダイアローグ　業務取引先">
            <?php
                echo $this->Html->image("manual/record_delete.png");
            ?>    
        </a>           
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <ol>
                <li>一覧画面で該当レコードの「削除」ボタンをクリック</li>
                <li>確認ダイアログで「OK」をクリック</li>
                <li>選択レコードが削除される</li>
            </ol>    
        
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>

</div>
</div>
</section>