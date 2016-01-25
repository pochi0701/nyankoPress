<?php
/////////////////////////////////////////////////////////////////////////////////////////
//リクエスト文字列取得
function array_get($arr, $key) {
    return (array_key_exists($key, $arr)) ?    $arr[$key] : null;
}
/////////////////////////////////////////////////////////////////////////////////////////
//リクエスト数値取得
function array_getn($arr, $key) {
    return (array_key_exists($key, $arr)) ?    $arr[$key] : -1;
}
/////////////////////////////////////////////////////////////////////////////////////////
//DB保存
$_contents=array();
$_menu    =array();
$_setting =array();
function dbLoad()
{
    global $_contents;
    global $_menu;
    if( $_SERVER['SCRIPT_FILENAME'] != $_SESSION['home'] ){
       if( $_SESSION['login'] === 1 ){
           $_SESSION = array();
           $_SESSION['login'] = 1;
       }else{
           $_SESSION = array();
       }
       $_SESSION['home'] = $_SERVER['SCRIPT_FILENAME'];
    }
    if( isset($_SESSION['_contents'] )){
        $_contents = $_SESSION['_contents'];
    }else{
        if( file_exists("db/contents.txt") ){
            $_contents = json_decode(file_get_contents("db/contents.txt"),true);
        }else{
            dbAddContents(1,'投稿一覧','','',-1);
        }
    }
    if( isset($_SESSION['_menu'] )){
        $_menu = $_SESSION['_menu'];
    }else{
        if( file_exists("db/menu.txt") ){
            $_menu = json_decode(file_get_contents("db/menu.txt"),true);
            $_SESSION['_menu'] = $_menu;
        }else{
            $_menu = array();
            $_menu['bland'] = "初期メニュー";
            $_menu['menu']  = array( "ログイン" => "system/login.php");
            dbSetMenu($_menu);
        }
    }
}
//投稿/固定ページ追加
//戻り値：確定したpage
function dbAddContents($mode, $title, $contents, $img, $page)
{
    global $_contents;
    //$page0は固定ページindex用
    //番号無指定なら最後に
    if( $page < 0 ){
        $_contents[] = array('mode'=>$mode,'title'=>$title,'contents'=>$contents,'eyecatch'=>$img, 'regdate'=>date("Y-m-d H:i:s"),'moddate'=>date("Y-m-d H:i:s"));
        $page = count($_contents)-1;
    }else{
        $_contents[$page] = array('mode'=>$mode,'title'=>$title,'contents'=>$contents,'eyecatch'=>$img, 'regdate'=>$_contents[$page]['regdate'],'moddate'=>date("Y-m-d H:i:s"));
    }
    file_put_contents("db/contents.txt",json_encode($_contents));
    $_SESSION['_contents'] = $_contents;
    return $page;
}
//０以上は直接ページ番号
function dbGetContents($number)
{
    global $_contents;
    if( $number >= 0  && count($_contents) > $number ){
        return $_contents[$number];
    }else{
        return array(""=>'mode',""=>'title',""=>'contents',""=>'eyecatch',""=>'regdate',""=>'moddate');
    }
}
//
function dbSortedContents($type)
{
   global $_contents;
   //投稿記事のみ
   foreach( $_contents as $value){
       if( $value['mode'] == 0 ){
          $_contents2[] = $value;
       }
   }
   //ソート
   $cnt = count($_contents2)-1;
   for( $i = 0 ; $i < $cnt-1 ; $i++ ){
       for( $j = $i+1 ; $j < $cnt ; $j++ ){
           if( $_contents2[$i]['regdate']<$_contents2[$j]['regdate'] ){
                $tmp = $_contents2[$i];
                $_contents2[$i] = $_contents2[$j];
                $_contents2[$j] = $tmp;
           }
       }
   }
   return $_contents2;
}
//mode =-1:normal 0:edit
function dbSetMenu($menu)
{
    file_put_contents("db/menu.txt",json_encode($menu));
    $_SESSION['_menu'] = $menu;
}
function dbGetMenu($mode)
{
    //編集時
    if( $mode >= 0 ){
        $bland = "編集";
        $menu = array(
            "新規投稿"       => "index.php?mode=0",
            "投稿一覧"       => "index.php?mode=1",
            "新規固定ページ" => "index.php?mode=2",
            "固定ページ一覧" => "index.php?mode=3",
            "メニュー編集"   => "index.php?mode=4",
            "メディア管理"   => "index.php?mode=5\" target=\"blank",
            "ログアウト"     => "index.php?mode=6"
        );
    //通常時。初回は投稿画面へ
    }else{
        global $_menu;
        $bland = $_menu['bland'];
        $menu  = $_menu['menu'];
    }
    return array($bland,$menu);
}
//設定
$theme = "standard";
$blog  = "テストブログ";
$header  = function($title,$bland,$menu){global $theme;include "themes/{$theme}/header.php";};
$footer  = function()                   {global $theme;include "themes/{$theme}/footer.php";};
$disp    = function($title,$bland,$menu,$data) {global $theme;include "themes/{$theme}/main.php";};
$mainidx = function($title,$bland,$menu,$data){global $theme;include "themes/{$theme}/mainidx.php";};
$carousel= function($slides)            {global $theme;include "themes/{$theme}/carousel.php";};
$navbar  = function($title,$bland,$menu){global $theme;include "themes/{$theme}/navbar.php";};

$syshdr  = function($title,$bland,$menu)            {include "system/header.php";};
$sysftr  = function()                               {include "system/footer.php";};
$sysnav  = function($title,$bland,$menu)            {include "system/navbar.php";};
$editpage= function($title,$text,$img,$page)        {include "system/editpage.html";};
$edit    = function($title,$bland,$menu,$mode,$page){include "system/edit.php";};
$upload  = function($title,$bland,$menu)            {include "system/upload.php";};
$editmenu= function($title,$bland,$menu)            {include "system/editmenu.php";};

//CDN
$bootstrap_var = "3.0.0";
$bootstrap_css = "http://netdna.bootstrapcdn.com/bootstrap/{$bootstrap_var}/css/bootstrap.min.css";
$bootstrap_js  = "http://netdna.bootstrapcdn.com/bootstrap/{$bootstrap_var}/js/bootstrap.min.js";
$jquery_js     = "http://code.jquery.com/jquery-1.11.1.min.js";
