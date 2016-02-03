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
    if( file_exists("db/contents.txt") ){
        $_contents = json_decode(file_get_contents("db/contents.txt"),true);
    }else{
        dbAddContents(1,'投稿一覧','','','',-1,0);
    }
    if( file_exists("db/menu.txt") ){
        $_menu = json_decode(file_get_contents("db/menu.txt"),true);
    }else{
        $_menu = array();
        $_menu['bland'] = "初期メニュー";
        $_menu['menu']  = array( "ログイン" => "system/login.php");
        dbSetMenu($_menu);
    }
}
//投稿/固定ページ追加
//戻り値：確定したpage
function dbAddContents($mode, $title, $contents, $head, $img, $page, $native)
{
    global $_contents;
    $max = -1;
    $target = -1;
    foreach( $_contents as $key => $value){
        if( $value['page'] > $max ){
             $max = $value['page'];
        }
        if( $value['page'] == $page ){
             $target = $key;
        }
    }
    //$page0は固定ページindex用
    //番号無指定なら最後に
    if( $target < 0 ){
        $_contents[] = array('page'=>($max+1),'mode'=>$mode,'title'=>$title,'contents'=>$contents,'header'=>$head,'eyecatch'=>$img, 'regdate'=>date("Y-m-d H:i:s"),'moddate'=>date("Y-m-d H:i:s"),'native'=>$native);
        $page = $max+1;
    }else{
        $_contents[$target] = array('page'=>$target,'mode'=>$mode,'title'=>$title,'contents'=>$contents,'header'=>$head,'eyecatch'=>$img, 'regdate'=>$_contents[$page]['regdate'],'moddate'=>date("Y-m-d H:i:s"),'native'=>$native);
        $page = $target;
    }
    file_put_contents("db/contents.txt",json_encode($_contents));
    return $page;
}
//０以上は直接ページ番号
function dbGetContents($page)
{
    global $_contents;
    $max = -1;
    $target = -1;
    foreach( $_contents as $key => $value){
        if( $value['page'] > $max ){
             $max = $value['page'];
        }
        if( $value['page'] == $page ){
             $target = $key;
        }
    }
    if( $target >= 0 ){
        return $_contents[$target];
    }else{
        return array('page'=>0,'mode'=>0,'title'=>'','contents'=>'','eyecatch'=>'','regdate'=>date("Y-m-d H:i:s"),'moddate'=>date("Y-m-d H:i:s"),'native'=>0);
    }
}
function dbDelContents($page)
{
    global $_contents;
    foreach( $_contents as $key => $value){
        if( $value['page'] == $page ){
             array_splice($_contents,$key,1);
             break;        
        }
    }
    file_put_contents("db/contents.txt",json_encode($_contents));
}
//
function dbSortedContents($param)
{
   global $_contents;
   extract($param);
   //投稿記事のみ
   $_contents2 = array();
   foreach( $_contents as $value){
       if( $value['mode'] != 0 ) continue;
       if( isset($ym) && date('Ym',strtotime($value['regdate'])) != date('Ym',strtotime($ym)) ) continue;
       $_contents2[] = $value;
   }
   //ソート
   $cnt = count($_contents2);
   for( $i = 0 ; $i < $cnt-1 ; $i++ ){
       for( $j = $i+1 ; $j < $cnt ; $j++ ){
           if( strtotime($_contents2[$i]['regdate'])<strtotime($_contents2[$j]['regdate']) ){
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
}
function dbGetMenu($mode)
{
    //編集時
    if( $mode >= 0 ){
        $bland = "編集";
        $menu = array(
            "投稿編集"       => "index.php?mode=0",
            "投稿一覧"       => "index.php?mode=1",
            "固定ページ編集" => "index.php?mode=2",
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
$theme = "ver001";
$blog  = "テストブログ";
$settings['theme']    = 'standard';
$settings['title']   = "テストブログ";
$settings['widget_l'] = array();
$settings['widget_r'] = array('calendar','youtube');
$settings['widget_fixl'] = array();
$settings['widget_fixr'] = array();
$settings['footer']    = array();
$attribute['theme']    = array('テーマ'=>'T');
$attribute['title']    = array('ブログタイトル'=>'T');
$attribute['widget_l'] = array('ブログウィジット右'=>'TA');
$attribute['widget_r'] = array('ブログウィジット左'=>'TA');
$attribute['widget_fixl'] = array('固定ページウィジット右'=>'TA');
$attribute['widget_fixr'] = array('固定ページウィジット左'=>'TA');
$attribute['footer']      = array('フッターウィジット'=>'TA');
$header  = function($params){global $theme;extract($params);include "themes/{$theme}/header.php";};//$title,$bland,$menu,$head
$footer  = function()       {global $theme;include "themes/{$theme}/footer.php";};
$disp    = function($params){global $theme;extract($params);include "themes/{$theme}/main.php";};//$title,$bland,$menu,$data
$mainidx = function($params){global $theme;extract($params);include "themes/{$theme}/mainidx.php";};//$title,$bland,$menu,$data
$carousel= function($slides){global $theme;include "themes/{$theme}/carousel.php";};
$navbar  = function($params){global $theme;extract($params);include "themes/{$theme}/navbar.php";};//$title,$bland,$menu

$syshdr  = function($params){extract($params);include "system/header.php";};
$sysftr  = function()       {include "system/footer.php";};
$sysnav  = function($params){extract($params);include "system/navbar.php";};
$editpage= function($params){extract($params);include "system/editpage.html";};
$edit    = function($params){extract($params);include "system/edit.php";};
$upload  = function($params){extract($params);include "system/upload.php";};
$editmenu= function($params){extract($params);include "system/editmenu.php";};
$widget  = function($name)  {include "widget/{$name}/{$name}.php";};

//echo with evaluate
$native = function($data) {
  $file = stream_get_meta_data($fp = tmpfile());
  file_put_contents( $file['uri'],$data );
  include( $file['uri']);
  fclose($fp);
};

//CDN
$bootstrap_var = "3.0.0";
$bootstrap_css = "http://netdna.bootstrapcdn.com/bootstrap/{$bootstrap_var}/css/bootstrap.min.css";
$bootstrap_js  = "http://netdna.bootstrapcdn.com/bootstrap/{$bootstrap_var}/js/bootstrap.min.js";
$jquery_js     = "http://code.jquery.com/jquery-1.11.1.min.js";
