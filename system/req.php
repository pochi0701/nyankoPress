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
        dbAddContents(array('mode'=>1,'title'=>'投稿一覧','contents'=>'','header'=>'','eyecatch'=>'','page'=>-1,'native'=>''));
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
function dbAddContents($param)//$mode, $title, $contents, $head, $eyecatch, $page, $native)
{
    //$param = array('page'=>$page,'mode'=>$mode,'title'=>$title,'contents'=>$contents,'header'=>$head,'eyecatch'=>$eyecatch, 'native'=>$native);
    global $_contents;
    $max = -1;
    $target = -1;
    foreach( $_contents as $key => $value){
        if( $value['page'] > $max ){
             $max = $value['page'];
        }
        if( $value['page'] == $param['page'] ){
             $target = $key;
        }
    }
    //$page0は固定ページindex用
    //番号無指定なら最後に
    if( $target < 0 ){
        $param['page'] = $max+1;
        $param['regdate'] = date("Y-m-d H:i:s");
        $param['moddate'] = date("Y-m-d H:i:s");
        $param['auther']  = isset($_SESSION['auther'])?($_SESSION['auther']):'SYSTEM';
        $_contents[] = $param;
        $page = $max+1;
    }else{
        $param['regdate'] = $_contents[$target]['regdate'];
        $param['moddate'] = date("Y-m-d H:i:s");
        $param['auther']  = isset($_SESSION['auther'])?($_SESSION['auther']):'SYSTEM';
        $_contents[$target] = $param;
        $page = $param['page'];
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
        //空白ページができる方がちょっとおかしい
        return null;
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
   usort($_contents2, function ($a, $b) { return strtotime($b['regdate']) - strtotime($a['regdate']); });
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
            "投稿一覧"       => "index.php?mode=2",
            "固定ページ編集" => "index.php?mode=1",
            "固定ページ一覧" => "index.php?mode=3",
            "メディア管理"   => "index.php?mode=4\" target=\"blank",
            "設定"           => "index.php?mode=5",
            "サイト表示"     => "index.php",
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
$start = $settings['start'];
//CDN
$bootstrap_css = $settings['bootstrap_css'];
$bootstrap_js  = $settings['bootstrap_js'];
$jquery_js     = $settings['jquery'];

$header  = function($params){global $theme;extract($params);include "themes/{$theme}/header.php";};
$footer  = function()       {global $theme;                 include "themes/{$theme}/footer.php";};
$disp    = function($params){global $theme;extract($params);include "themes/{$theme}/main.php";};
$mainidx = function($params){global $theme;extract($params);include "themes/{$theme}/mainidx.php";};
$carousel= function($slides){global $theme;                 include "themes/{$theme}/carousel.php";};
$navbar  = function($params){global $theme;extract($params);include "themes/{$theme}/navbar.php";};

$syshdr  = function($params){extract($params);include "system/header.php";};
$sysftr  = function()       {include "system/footer.php";};
$sysnav  = function($params){extract($params);include "system/navbar.php";};
$editpage= function($params){extract($params);include "system/editpage.html";};
$edit    = function($params){extract($params);include "system/edit.php";};
$upload  = function($params){extract($params);include "system/upload.php";};
$editmenu= function($params){extract($params);include "system/editmenu.php";};
$setting = function($params){extract($params);include "system/setting.php";};
$widget  = function($params){extract($params);include "widget/{$name}/index.php";};
$snippet = function($params){extract($params);include "system/snippet.php";};
$atom    = function()       {include "system/atom.php";};

//echo with evaluate
$native = function($data) {
  $file = stream_get_meta_data($_fp = tmpfile());
  file_put_contents( $file['uri'],$data );
  include( $file['uri']);
  fclose($_fp);
};

//filter
function entag($text){
    $ary = explode("\r\n", $text); // とりあえず行に分割
    $xdv = $tag = $lst = 0;
    foreach($ary as $key => &$str){
        $len = strlen($str);
        $xdv+=substr_count($str, "<div");       //divタグ開始
        if( $len*(!$xdv) ){                     //divタグ外
           if( $lst ){
               $last .= '<br>';
           }else{
               $str = "<p>{$str}";
               $tag =1;
           }
        }else if( $tag ){                       //divタグ内
           $last .= '</p>';
           $tag = 0;
        }
        $lst = $len*(!$xdv);
        $last = &$str;
        $xdv-=substr_count($str,"</div");       //divタグ終了
    }
    if( $tag ) $last .= "</p>";
    unset($last);
    unset($str);
    return implode("\r\n",$ary);
}

