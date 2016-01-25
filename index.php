<?php
session_start();
require_once('system/req.php');
$mode = array_getn($_GET,'mode');
$page = array_getn($_GET,'p');
$ym   = array_getn($_GET,'ym');
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
    if     ( $mode <= 3 ) $edit($title,$bland,$menu,$mode,$page);
    else if( $mode == 4 ) $editmenu($title,$bland,$menu); 
    else if( $mode == 5 ) $upload($title,$bland,$menu); 
    else if( $mode == 6 ) {
          unset($_SESSION['login']);
          header("Location:index.php");
    }
//表示
}else{
    list($bland,$menu) = dbGetMenu(-1);
    //一覧
    if( $page<=0){
        $mainidx($blog,$bland,$menu,dbGetContents(0));
    //各ページ themeの切り替えはreq.php内の$themeで変更
    }else{
        $disp   ($blog,$bland,$menu,dbGetContents($page));
    }
}


