NyankoPress
=============

にゃんこプレスは2000行程度のシンプルなCMSでPHPで書かれています。主な技術として１行テンプレートエンジンを使っています。１行テンプレートはテンプレートエンジンを１行で書く方法で、下記のように関数を使って構築されています。

```php
$header  = function_name($param){global $theme;extract($param);include "themes/{$theme}/header.php";};
```

この例ではテンプレートに引き渡す変数を指定してテンプレート側のheader.phpをincludeしてます。global変数$themeによってテーマは自由に変更可能です。
snippetを選択可能になりました。VisualStudioCodeのbootstrapSnippetsを編集してsnippetsを選択、表示して使えるようになりました。
bootstrapSnippetsのフォーマットのXMLから変換して登録できますが、もう少し後でやります。

## installation
多分どのバージョンのPHPでも動きます。ソース全体を適当なフォルダにコピーします。dbフォルダと、system,widgetにあるsettings.phpを書き込み可能(766)に設定します。windowsでは動作チェックしてないですが、特殊な機能には依存してないので多分動くでしょう。ID/PWは初回ログインで記録されます。必ずログインしてアカウント作成にタブを切り替えてID,EMail,パスワードを設定してください。

## themes
テーマはthemes/テーマ名で自由に作ってください。footer,header,main,navbar,mainidxを最低作ればいいかと思います。
現在standardに加え固定ナビゲーションのver001が有効です。設定画面から変更可能です。

## widget
ウィジットはBootstrapで投稿コンテンツ右、左、ブログページ右、左、フッタに配置可能です。今のところカレンダーとyoutubeを作成しました。これからもう少し増やします。設定は画面の設定から行えます。設定はsettings.phpというファイルに$settingsと$attributeという変数を設定します。$settingsは連想配列の値、$attributeは夫々の編集形式を指定します。キーとなる値は編集用の表示タイトル、Tはテキスト入力、Cはチェックボックス入力、Rはテキストのみ有効で必須項目です。TRと書けばテキストの必須項目となります。
BACK2TOPウィジットを実装しました。固定ページまたは投稿でTOPに戻る機能です。この実装に伴い、header,top,bottom,footerに任意の文字列を表示できるようになりました。
```php
    if       ( $location=='header'){
    ...
    }else if ( $location=='top'){
    ...
    }else if ( $location=='bottom'){
    ...
    }else if ( $location=='footer'){
    ...
    }

```
こんな記述です。

## database
データベースは使っていません。JSONでファイルに保存してます。PHP5.1くらいからSQLITE使えるそうなので、そのうちに入れるかも知れません。

## snippets
bootstrapの機能を切り出したsnippetsを表示しコピーできる機能をいれました。
固定ページ編集、投稿編集のページ下部にsnippetが表示されます。選択すると例が表示されます。
そのうちにsnippetsを投稿できるようにするかもしれません。取り敢えずは必要なコードをsystem/snippets以下のサンプル同様に格納してみてください。

## misc
ページ編集時にnativeフラグを用意しました。nativeにチェックを入れるとphpのコードが有効になり、<?php .. ?>を記述できます。また、P,BRタグを挿入できるフィルタも入れました。簡単な文書は&lt;p&gt;で囲まれます。

サンプルサイト http://neon.cx

NyankoPress is Tiny(about 2000lines) Simple CMS based BootStrap and one liner template engine.

