NyankoPress
=============

にゃんこプレスは1500行程度のシンプルなCMSでPHPで書かれています。主な技術として１行テンプレートエンジンを使っています。１行テンプレートはテンプレートエンジンを１行で書く方法で、下記のように関数を使って構築されています。

```php
$header  = function($title,$bland,$menu){global $theme;include "themes/{$theme}/header.php";};
```

この例ではテンプレートに引き渡す変数を指定してテンプレート側のheader.phpをincludeしてます。global変数$themeによってテーマは自由に変更可能です。

## installation
多分どのバージョンのPHPでも動きます。ソース全体を適当なフォルダにコピーすればそれでおしまいです。windowsでは動作チェックしてないですが、特殊な機能には依存してないので多分動くでしょう。ID/PWは初回ログインで記録されます。必ずログインしてください。

## themes
テーマはthemes/テーマ名で自由に作ってください。footer,header,main,navbar,mainidxを最低作ればいいかと思います。
現在standardに加え固定ナビゲーションのver001が有効です。設定画面から変更可能です。

## widget
ウィジットはBootstrapで投稿コンテンツ右、左、ブログページ右、左、フッタに配置可能です。今のところカレンダーとyoutubeを作成しました。これからもう少し増やします。設定は画面の設定から行えます。

## database
データベースは使っていません。JSONでファイルに保存してます。PHP5.1くらいからSQLITE使えるそうなので、そのうちに入れるかも知れません。

## misc
ページ編集時にnativeフラグを用意しました。nativeにチェックを入れるとphpのコードが有効になり、<?php .. ?>を記述できます。また、P,BRタグを挿入できるフィルタも入れました。簡単な文書は<p>で囲まれます。

サンプルサイト http://neon.cx

NyankoPress is Tiny(about 1000lines) Simple CMS based BootStrap and one liner template engine.

