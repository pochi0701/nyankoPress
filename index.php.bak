<?php
session_start();
require_once('system/req.php');
$mode = array_getn($_GET,'mode');
$page = array_getn($_GET,'p');
//ページデータ取得
dbLoad();
//編集
if( $mode >= 0 && isset($_SESSION['login'])){
    list($bland,$menu) = dbGetMenu($mode);
    $menu2 = $menu;
    uasort($menu2, function ($a, $b) { return strlen($b)-strlen($a); }); 
    $target=basename($_SERVER['REQUEST_URI']);
    foreach($menu2 as $key => $value){
        $value = explode('"',$value);
        //if( strpos(parse_url($value,PHP_URL_QUERY),$_SERVER['QUERY_STRING'])!==false ){
        if( strpos($target,$value[0])!==false ){
            $title = $key;
            break;
        }
    }
    if     ( $mode <= 3 ) $edit    (array('title'=>$title,'bland'=>$bland,'menu'=>$menu,'mode'=>$mode,'page'=>$page));
    else if( $mode == 4 ) $upload  (array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
    else if( $mode == 5 ) $setting (array('title'=>$title,'bland'=>$bland,'menu'=>$menu)); 
    else if( $mode == 6 ) {
          unset($_SESSION);
          session_destroy();
          header("Location:index.php");
    }else if ( $mode == 7 ){
          $snippet(array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
    }
//表示
}else{
    //ディフォールトページ設定
    if( $page<0 && strlen($start)>0){
        parse_str(parse_url($start, PHP_URL_QUERY),$_GET);
        $page = array_getn($_GET,'p');
    }
    $ym   = array_get($_GET,'ym');
    if( array_get($_GET,'feed')=='atom'){
         $atom();
    }else{
        list($bland,$menu) = dbGetMenu(-1);
        if ( $page <= 0 ){
            $mainidx(array('title'=>$blog,'bland'=>$bland,'data'=>dbGetContents(0),'menu'=>$menu,'ym'=>$ym));
        //各ページ themeの切り替えはreq.php内の$themeで変更
        }else{
            $disp   (array('title'=>$blog,'bland'=>$bland,'data'=>dbGetContents($page),'menu'=>$menu));
        }
    }
}


