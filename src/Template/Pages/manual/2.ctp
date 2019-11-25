<?php $this->layout = 'tutorial'; ?>
<section class="content-header" id="introduction">
    <div id="alert_div"></div>
    <h1>
    サービスの受注から請求処理まで
    <small>業務処理の一連の流れ</small>
    </h1>
</section>

<section class="content voffset4">
<div class="row">
<div class="col-md-12">
<section>
    <h4 >フローチャート</h4>

    <div class="text-center">
        <div class="thumbnail">
            <a href="<?= $this->Url->image('manual/1_steps.png') ?>" data-lightbox="1_steps" data-title="フローチャート">
                <?php
                    echo $this->Html->image("manual/1_steps.png");
                ?>    
            </a>            
        </div>
    </div>
</section>
<hr>
<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">新規受注</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【新規受注画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/order.png') ?>" data-lightbox="order" data-title="新規受注画面">
            <?php
                echo $this->Html->image("manual/order.png");
            ?>    
        </a>
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <ol>
                <li>新規受注ページを開く（サイドメニューの「新規受注」をクリック）</li>
                <li>注文情報の入力</li>
                <ul>
                <li>請負元・派遣先</li>
                <li>実施期間（年月日期間と時間帯）</li>
                <li>業務内容の詳細</li>
                <li>会計・料金設定</li>
                </ul>
                <li>「新規登録」で注文情報の登録</li>
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
        <h3 class="box-title">作業データの管理</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【作業編集画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/work.png') ?>" data-lightbox="work" data-title="作業編集画面">
            <?php
                echo $this->Html->image("manual/work.png");
            ?>    
        </a>  
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <ol>
                <li>作業内容編集ページを開く（左メインメニューの作業データ一覧　→　該当レコードの「編集」ボタンクリック）</li>
                <li>作業内容を入力</li>
                <ul>
                    <li>通番の入力</li>
                    <li>使用する装置の登録</li>
                    <li>放射線技師とその他スタッフの登録</li>
                </ul>
                <li>「これで更新する」をクリックして入力情報を保存</li>
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
        <h3 class="box-title">費用データの入力</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【費用編集画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/costs.png') ?>" data-lightbox="costs" data-title="費用編集画面">
            <?php
                echo $this->Html->image("manual/costs.png");
            ?>    
        </a>  
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <ol>
                <li>費用編集画面を開く（左サイドメニューの費用データ一覧　→　該当レコードの「編集」ボタンクリック）</li>
                <li>費用情報の入力</li>
                <ul>
                <li>作業全般でかかった各費用項目を入力</li>
                </ul>
                <li>「これで更新する」をクリックして入力情報を保存</li>
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
        <h3 class="box-title">請求書の作成</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <div class="row">
            <div class="col-md-4 vcenter">
                <h4>【売掛金データ一覧画面】</h4>
                <div class="thumbnail text-center">
                    <a href="<?= $this->Url->image('manual/receivables.png') ?>" data-lightbox="receivables" data-title="売掛金データ一覧画面">
                        <?php
                            echo $this->Html->image("manual/receivables.png");
                        ?>    
                    </a>                       
                </div>
            
            </div>
            <div class="col-md-8 vcenter text-large">
                <h4>請求対象の注文情報を選択</h4>
                <div>
                    <ol>
                        <li>売掛金データ一覧画面を開く（左サイドメニューの売掛金データ一覧クリック）</li>
                        <li>対象月を選択して検索</li>
                        <li>対象の請求先レコードの「請求書処理」ボタンをクリック</li>
                        <li>対象請求先の請求書管理ページで、「請求書新規作成」ボタンをクリック</li>
                        <li>「請求対象リスト選択」ダイアローグが開くので、請求に含めたい注文情報を選択して
                        「これで請求書作成」ボタンをクリックして、請求書新規作成ページを開く</li>
                    </ol>    
                
                </div>
            </div>
        </div>
        <hr>
        <div class="row voffset3">
            <div class="col-md-4 vcenter">
                <h4>【請求書新規作成画面】</h4>
                <div class="thumbnail text-center">
                    <a href="<?= $this->Url->image('manual/billing.png') ?>" data-lightbox="billing" data-title="請求書新規作成画面">
                        <?php
                            echo $this->Html->image("manual/billing.png");
                        ?>    
                    </a>                       
                </div>
            
            </div>
            <div class="col-md-8 vcenter text-large">
                <h4>請求書データを作成</h4>
                <div>
                    <ol>
                        <li>画面右の明細パネルで人数・単価情報を確認、必要に応じて修正する</li>
                        <li>画面左のフォームに必要事項を入力</li>
                        <ul>
                            <li>請求書No</li>
                            <li>支払期限</li>
                            <li>備考</li>
                        </ul>
                        <li>「登録」ボタンをクリックして、請求情報を登録する</li>
                    </ol>    
                
                </div>
            </div>
        </div>
        <hr>
        <div class="row voffset3">
            <div class="col-md-4 vcenter">
                <h4>【請求書閲覧画面】</h4>
                <div class="thumbnail text-center">
                    <a href="<?= $this->Url->image('manual/bill.png') ?>" data-lightbox="bill" data-title="請求書閲覧画面">
                        <?php
                            echo $this->Html->image("manual/bill.png");
                        ?>    
                    </a>
                </div>
            
            </div>
            <div class="col-md-8 vcenter text-large">
            <h4>請求書の出力</h4>
                <div>
                    <ol>
                        <li>請求書閲覧画面を開く（左サイドメニューの請求書一覧　→　該当レコードの「閲覧」ボタンクリック）</li>
                        <li>請求書の内容を確認。修正したい場合は「請求情報編集」ボタンをクリック</li>
                        <li>パネル右上の「請求書出力」「納品書出力」ボタンをクリックして、請求帳票を出力</li>
                    </ol>                
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