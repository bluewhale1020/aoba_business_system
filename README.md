<a href="https://github.com/cakephp/cakephp"><img src="https://img.shields.io/badge/cakePHP-3.8.*-brightgreen.svg?style=flat-square" alt="CakePHP3"></a>
<img src="https://img.shields.io/badge/license-Apache-blue.svg?style=flat-square" alt="license">

# AOBA Business System

**AOBA Business System**は弊社内で利用する業務処理用システムの一つです。



## 概要

青葉の業務で主に受注・現場作業計画・経費・売掛・請求処理をシステム上でまとめて管理する目的で Aoba業務システムは開発されました。
また、取引先や現場作業で利用する装置やスタッフの管理、 簡単な統計資料を提供する機能も実装しました。



## 機能一覧

+ ユーザー認証

+ アクセス制限

+ 取引先管理

+ 装置管理

+ スタッフ管理

+ 受注処理

+ 作業データの管理

+ 費用管理

+ 売掛金管理

+ 請求書管理

+ 統計データ

+ Topページのダッシュボード（各種データの集計、管理）

+ 各ページでの帳票出力

+ お知らせ機能

+ データインポート機能

  
## インストール手順

### アプリケーションデータのインストール

```bash
# このプロジェクトをウェブサーバー上にクローン
git clone https://github.com/bluewhale1020/aoba_business_system.git

# プロジェクトのディレクトリに移動
cd aoba_business_system

# PHPのパッケージをcomposerでインストール
composer install

```

### DBの設定

DBサーバーを起動し、システム用の適当な名前のデータベースを作成します。`tmp/db_backup/Dump~.sql`ファイルにシステム用のテーブルデータが含まれているので、作成したデータベースにインポートします。

### Config設定

`app.php`ファイルの下記のDB設定の箇所を作成したデータベースに合わせて書き換えてください。

```php
    'Datasources' => [
        'default' => [
            // ...
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'password',
            'database' => 'new_db',
            // ...
            ]
        ]
```

Security.saltの値の変更

```php
    'Security' => [
        'salt' => env('SECURITY_SALT', 'something long and containing lots of different values.'),
    ],
```



### 設定状態の確認

正しい設定がなされているか確認するためには、adminユーザーでログイン後、サイドメニューの`SAMPLES/Debug`ページを開くと環境設定やデータベース接続状況が表示されます。



## 使い方

詳細についてはシステム内のマニュアルに記載



### 登録済み管理者

```
ユーザー名： admin
パスワード： admin
役柄	   ： admin
```



### 役柄による利用制限

ユーザーの役柄により、ログイン後のメニューの表示項目が変わります。

#### 「admin」

全て表示

#### 「user」

ユーザー管理・データインポート・レファレンスメニューが非表示

## 動作環境

開発時に想定した利用環境は以下の通り。

+ Windows10
+ PHP 7.2.11
+ CakePHP 3.8
+ Apache server 2.4.17
+ MariaDB 10.1.8
+ PHP拡張（ mbstring, simplexml, intl ）



## ライセンス (License)

**Medcheck**は[Apache license](https://github.com/bluewhale1020/aoba_business_system/blob/master/LICENSE)のもとで公開されています。<br />
**AOBA Business System** is open-source software licensed under the [Apache license](https://github.com/bluewhale1020/aoba_business_system/blob/master/LICENSE).