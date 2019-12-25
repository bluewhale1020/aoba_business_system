<?php $this->layout = 'tutorial'; ?>
<section class="content-header" id="introduction">
    <div id="alert_div"></div>
    <h1>その他
    
    <small>統計資料・ダッシュボード・データインポート・イベントログ</small>
    </h1>
</section>

<section class="content voffset4">
<div class="row">
<div class="col-md-12">

<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">統計資料:月別装置・フィルムサイズ稼働件数</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <h4>【統計資料テーブル画面】</h4>
            <div class="thumbnail text-center">
                <a href="<?= $this->Url->image('manual/stat.png') ?>" data-lightbox="stat" data-title="統計資料テーブル画面">
                    <?php
                        echo $this->Html->image("manual/stat.png");
                    ?>    
                </a> 
            </div>    
        </div>
        <div class="col-md-6">
            <h4>【統計資料グラフ画面】</h4>
            <div class="thumbnail text-center">
                <a href="<?= $this->Url->image('manual/graph.png') ?>" data-lightbox="graph" data-title="統計資料グラフ画面">
                    <?php
                        echo $this->Html->image("manual/graph.png");
                    ?>    
                </a>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10 text-large">
            <div>
            <p>期間を設定して検索すると下部のテーブルとグラフが更新されます。<br>
        グラフに関しては、右下のセレクトボックスでグラフのタイプを変更できます。
        （積層ライングラフ・積層棒グラフ・棒グラフ）<br>
        また、稼働件数データをエクセルファイルで出力できます。</p>
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
        <h3 class="box-title">統計資料:売上分析ページ</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【各種分析グラフ画面】</h4>
    <div class="thumbnail text-center">
    <a href="<?= $this->Url->image('manual/stat1.png') ?>" data-lightbox="stat1" data-title="売上分析グラフ1">
                    <?php
                        echo $this->Html->image("manual/stat1.png");
                    ?>    
                </a> 
    </div>
    <div class="thumbnail text-center">
    <a href="<?= $this->Url->image('manual/stat2.png') ?>" data-lightbox="stat2" data-title="売上分析グラフ2">
                    <?php
                        echo $this->Html->image("manual/stat2.png");
                    ?>    
                </a> 
    </div>     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <p>表示される統計資料は以下の5種類</p>

            <ul>
                <li>売上・粗利率</li>
                <li>受注数</li>
                <li>フィルムサイズ別受注数</li>
                <li>顧客別売上・粗利率</li>
                <li>業務別売上・粗利率</li>
            </ul>            
            <p>期間を設定して検索するとページ下部の全てのテーブルとグラフが更新されます。<br>
            また、上記の各統計データをCSVフォーマットで出力できます。
            </p>
        </div>
    </div>


    </div>
    <!-- /.box-body -->
</div>  
</section>


<section class="voffset4">
    <div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Top（ダッシュボード）</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【Top（ダッシュボード）画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/top.png') ?>" data-lightbox="top" data-title="Top（ダッシュボード）画面">
            <?php
                echo $this->Html->image("manual/top.png");
            ?>    
        </a>
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <p>ここでは、システム上の各種データを閲覧できます。画面上部から順に下記のコンテンツが表示されます。</p>
            <ul>
                <li>受注数・作業実施数・完了未請求数</li>
                <li>受注業務一覧表</li>
                <li>作業スケジュールカレンダー</li>
                <li>ToDoリスト</li>
                <li>月別売上データとグラフ</li> 
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
        <h3 class="box-title">データインポート(管理者用)</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【データインポート画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/import.png') ?>" data-lightbox="import" data-title="データインポート画面">
            <?php
                echo $this->Html->image("manual/import.png");
            ?>    
        </a>        
    </div>
     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <p>スタッフ・業務取引先・注文データを所定の書式で作成したエクセルファイルを
            システムにインポートできます。</p>
            <p>ページ右上のインポート雛形で各雛形ファイルをダウンロードできます。</p>
            <ol>
                <li>インポートしたいファイルを選択して、「データの読込」ボタンをクリック</li>
                <li>ファイルデータ一覧にインポートデータが表示される</li>
                <li>データ内容を確認し、必要ならば修正</li>
                <li>種別が適切に選択されていることを確認して「データをアップロード」ボタンをクリック</li>
                <li>結果の成否がデータ一覧の「処理結果」カラムに表示され、最後にダイアローグに結果がまとめて表示される</li> 
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
        <h3 class="box-title">イベントログ(管理者用)</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body vertical-align">
    <div class="col-md-4 vcenter">
    <h4>【ユーザー閲覧画面】</h4>
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/user_log.png') ?>" data-lightbox="user_log" data-title="ユーザー閲覧画面">
            <?php
                echo $this->Html->image("manual/user_log.png");
            ?>    
        </a>        
    </div>
    <h4>【イベントログ一覧画面】</h4>    
    <div class="thumbnail text-center">
        <a href="<?= $this->Url->image('manual/eventlog.png') ?>" data-lightbox="eventlog" data-title="イベントログ一覧画面">
            <?php
                echo $this->Html->image("manual/eventlog.png");
            ?>    
        </a>        
    </div>     
    </div>
    <div class="col-md-8 vcenter text-large">
        <div>
            <p>ユーザーのログイン・ログアウト情報、注文・作業・請求テーブル更新情報をイベントログとして記録します。
            ログ情報は、イベントログページか、ユーザー閲覧ページの下部（そのユーザーのイベントログリスト）に表示されます。</p>
            <p>イベントログ一覧画面へは、トップナビ右端の「設定」ドロップダウンリストからアクセスできます。</p>
            <p>ログデータはCSVで出力できます。</p>
        </div>
    </div>
    

    </div>
    <!-- /.box-body -->
</div>  
</section>


</div>
</div>
</section>