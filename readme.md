NyankoPress
=============

にゃんこプレスは1000行程度のシンプルなCMSでPHPで書かれています。主な技術として１行テンプレートエンジンを使っています。１行テンプレートはテンプレートエンジンを１行で書く方法で、下記のように関数を使って構築されています。

```php
$header  = function($title,$bland,$menu){global $theme;include "themes/{$theme}/header.php";};
```

この例ではテンプレートに引き渡す変数を指定してテンプレート側のheader.phpをincludeしてます。global変数$themeによってテーマは自由に変更可能です。

## installation
多分どのバージョンのPHPでも動きます。ソース全体を適当なフォルダにコピーすればそれでおしまいです。windowsでは動作チェックしてないですが、特殊な機能には依存してないので多分動くでしょう。ID/PWは初回ログインで記録されます。必ずログインしてください。

## themes
テーマはthemes/テーマ名で自由に作ってください。footer,header,main,navbar,mainidxを最低作ればいいかと思います。

## database
データベースは使っていません。JSONでファイルに保存してます。PHP5.1くらいからSQLITE使えるそうなので、そのうちに入れるかも知れません。

## misc
操作はまあ適当にお願いします。正味１週間くらいで作ったのでこれくらいな感じで。

NyankoPress is Tiny(about 1000lines) Simple CMS based BootStrap and one liner template engine.

