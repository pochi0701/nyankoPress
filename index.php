<?php
session_start();
require_once('system/req.php');
$mode = array_getn($_GET,'mode');
$page = array_getn($_GET,'p');
$ym   = array_get($_GET,'ym');
//ページデータ取得
dbLoad();
//編集
if( $mode >= 0 && isset($_SESSION['login'])){
    list($bland,$menu) = dbGetMenu($mode);
    $cnt = 0;
    foreach($menu as $key => $value){
        if($cnt == $mode ){ $title = $key; }
        $cnt += 1;
    }
    if     ( $mode <= 3 ) $edit    (array('title'=>$title,'bland'=>$bland,'menu'=>$menu,'mode'=>$mode,'page'=>$page));
    else if( $mode == 4 ) $editmenu(array('title'=>$title,'bland'=>$bland,'menu'=>$menu)); 
    else if( $mode == 5 ) $upload  (array('title'=>$title,'bland'=>$bland,'menu'=>$menu)); 
    else if( $mode == 6 ) {
          unset($_SESSION['login']);
          header("Location:index.php");
    }else if( $mode == 7 ){
        include('system/dump.php');
    }
//表示
}else{
    list($bland,$menu) = dbGetMenu(-1);
    //一覧
    if( $page<=0){
        $mainidx(array('title'=>$blog,'bland'=>$bland,'data'=>dbGetContents(0),'menu'=>$menu,'ym'=>$ym));
    //各ページ themeの切り替えはreq.php内の$themeで変更
    }else{
        $disp   (array('title'=>$blog,'bland'=>$bland,'data'=>dbGetContents($page),'menu'=>$menu));
    }
}


