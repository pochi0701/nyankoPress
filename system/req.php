<?php
//リクエスト文字列取得
function array_get($arr, $key) {
    return (array_key_exists($key, $arr)) ?    $arr[$key] : null;
}
//リクエスト数値取得
function array_getn($arr, $key) {
    return (array_key_exists($key, $arr)) ?    $arr[$key] : -1;
}
//グローバル
$_contents=array();
$_menu    =array();
$_setting =array();
$_widgetcnt = 0;
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
            "メディア管理"   => "index.php?mode=4\" target=\"blank",
            "設定"           => "index.php?mode=5",
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
include('settings.php');
//general
$theme = $settings['theme'];
$blog  = $settings['title'];
//CDN
$bootstrap_css = $settings['bootstrap_css'];
$bootstrap_js  = $settings['bootstrap_js'];
$jquery_js     = $settings['jquery'];

$header  = function($params){global $theme;extract($params);include "themes/{$theme}/header.php";};
$footer  = function()       {global $theme;include "themes/{$theme}/footer.php";};
$disp    = function($params){global $theme;extract($params);include "themes/{$theme}/main.php";};
$mainidx = function($params){global $theme;extract($params);include "themes/{$theme}/mainidx.php";};
$carousel= function($slides){global $theme;include "themes/{$theme}/carousel.php";};
$navbar  = function($params){global $theme;extract($params);include "themes/{$theme}/navbar.php";};

$syshdr  = function($params){extract($params);include "system/header.php";};
$sysftr  = function()       {include "system/footer.php";};
$sysnav  = function($params){extract($params);include "system/navbar.php";};
$editpage= function($params){extract($params);include "system/editpage.html";};
$edit    = function($params){extract($params);include "system/edit.php";};
$upload  = function($params){extract($params);include "system/upload.php";};
$editmenu= function($params){extract($params);include "system/editmenu.php";};
$setting = function($params){extract($params);include "system/setting.php";};
$widget  = function($name)  {include "widget/{$name}/{$name}.php";};

//echo with evaluate
$native = function($data) {
  $file = stream_get_meta_data($fp = tmpfile());
  file_put_contents( $file['uri'],$data );
  include( $file['uri']);
  fclose($fp);
};

//filter
function entag($text){
    $ary = explode("\r\n", $text); // とりあえず行に分割
    $cnt = count($ary);
    $lst = 0;
    $tag = 0;
    $xdv = 1;
    for($i = 0 ; $i<$cnt ; $i++ ){
        $str = $ary[$i];
        $len = strlen($str);
        if( strpos($str,'<div') !== false ) $xdv = 0;
        if( $len*$xdv ){
           if( $lst ){
               $ary[$i-1] .= '<br>';
           }else{
               $ary[$i] = "<p>{$ary[$i]}";
               $tag =1;
           }
        }else if( $tag ){
           $ary[$i-1] .= '</p>';
           $tag = 0;
        }
        $lst = $len*$xdv;
        if( strpos($str,'</div') !== false ) $xdv= 1;
    }
    if( $tag ) $ary[$cnt-1] .= "</p>";
    return implode("\n",$ary);
}

