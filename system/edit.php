<?php
global $syshdr;
global $sysftr;
global $editpage;
global $_contents;
$syshdr($title,$bland,$menu,'');
$submit = array_get($_POST,'submit');
$stitle = array_get($_POST,'title');
$stext  = array_get($_POST,'text');
$shead  = array_get($_POST,'head');
$simg   = array_get($_POST,'simg');
$snativ = array_get($_POST,'native');
//投稿された
if( strlen($submit)>0 ){
    if( strlen($simg) == 0 ){
        $simg = 'http://placehold.it/320x240';
    }
    $page = dbAddContents(floor($mode/2),$stitle,$stext,$shead,$simg,$page,$snativ);
}
//編集
if( $mode == 0 || $mode == 2){
    if( $page >= 0 ){
        $data = dbGetContents($page);
        $mode = $data['mode'];
        $stitle = $data['title'];
        $shead  = $data['header'];
        $stext  = $data['contents'];
        $simg   = $data['eyecatch'];        
        $snativ = $data['native'];        
    }
    $editpage($stitle,$stext,$shead,$simg,$mode*2,$page,$snativ);
}else if ($mode == 1 || $mode == 3){
    $del = array_getn($_GET,'del');
    if( $del > 0 && $page > 0 ){
        dbDelContents($page);
    }        
    include( "displist.html");
}
$sysftr();

