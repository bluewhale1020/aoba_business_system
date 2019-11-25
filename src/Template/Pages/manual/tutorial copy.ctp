<?php $this->layout = 'tutorial'; ?>

<section id="introduction">
  <h2 class="page-header"><a href="#introduction">はじめに</a></h2>
  <p class="lead">
    <b>YSUploader</b>は、cakePHP3で作成されたシンプルな機能のアップローダーで、誰でも
    簡単にファイルをサーバーにアップロード／ダウンロードできます。
    ファイルをカテゴリごとに分類し、必要があればパスワードで制限をかけられます。
  一部の画像やテキストファイルは、ダウンロード前にファイルの中身を見れるPreview機能も提供しています。
 システム管理者は、分類カテゴリ、ユーザー、アップロードファイルの種類等を管理できます。
    また、ログインの際の認証機能で十分なセキュリティを確保しています。
  </p>
</section><!-- /#introduction -->

<section id="default-users">
  <h2 class="page-header"><a href="#default-users">登録済のユーザー</a></h2>
  <p class="lead">
    次のユーザーは最初から登録されています。
  </p>
<p><strong>ゲスト(guest)</strong></p>
<pre><code>username:guest
password:guest
</code></pre> 
</section><!-- /#default-users -->

<section id="simple-manual">
  <h2 class="page-header"><a href="#simple-manual">システムの利用方法</a></h2>
  <p class="lead">
    ユーザー権限によって利用可能な機能の範囲が変わります。
  </p>
  <h3>ログイン方法</h3>
  <p>ブラウザで以下のURLにアクセスします。</p>
  <pre class="prettyprint">
     サーバーURL/ys_uploader/users/login</pre>
  <b>ログイン後、<span class="text-red">アップロードファイル一覧画面</span>に移動します。</b>
  
  <h3>アップロード機能</h3>
  <p class="lead">主に利用できる機能は以下の通りです。</p>
  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
        </div><!-- /.box-header -->
        <div class="box-body">
<dt><strong>ファイルをアップロード</strong></dt><dd>ファイルをアップロードし、パスワードを設定できます（任意）。</dd>
<dt><strong>アップロードファイルの分類</strong></dt><dd>　カテゴリごとにファイルを分類して一覧表示します。</dd>
<dt><strong>ダウンロード</strong></dt><dd> ファイルをダウンロードします。パスワード設定のあるものは、パスワードの入力を要求します。</dd>
<dt><strong>ファイルの削除</strong></dt><dd> ファイルを削除します。パスワード設定のあるものは、パスワードの入力を要求します。</dd>
<dt><strong>アップロードファイルの制限</strong></dt><dd> アップロードのファイルは登録されたファイル種類(MimeType)のもののみ受け付けます。<code>MimeType管理</code>を参照。</dd>

 
         </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->  
  



  <h3>カテゴリ管理</h3>
  <p class="lead">ファイルを分類するカテゴリの新規作成・更新・削除機能を提供</p>
  
    <h3>ユーザー管理</h3>
  <p class="lead">ユーザーの新規作成・更新・削除機能を提供</p>
  
    <h3>MimeType管理</h3>
  <p class="lead">受け付けるファイルの種類を管理します。MimeTypeには、それだけでは拡張子が特定できないものがあります。
      その場合、登録の際に拡張子欄を<code>空欄</code>にし、拡張子が<code>非特定</code>と設定します。</p>
    <h3>debugページ</h3>
  <p class="lead">システムの基本的な項目のエラー内容が表示されます。</p>  
</section><!-- /#simple-manual -->


<!-- ============================================================= -->

<section id="license">
  <h2 class="page-header"><a href="#license">ライセンス</a></h2>
  <h3>YSUploader</h3>
  <p class="lead">
    本ソフトウェアは<a href="http://opensource.org/licenses/MIT">MITライセンス</a>の下で
    公開しています。ご利用にあたっては、本ソフトウェアを利用した際に発生するいかなる損害からも制作者が免責されることを、
  ご了解ください。 
  </p>
</section>
