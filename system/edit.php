<?php
global $syshdr;
global $sysftr;
global $editpage;
global $_contents;
$syshdr($title,$bland,$menu);
$submit = array_get($_POST,'submit');
$stitle = array_get($_POST,'title');
$stext  = array_get($_POST,'text');
$simg   = array_get($_POST,'simg');
//投稿された
if( strlen($submit)>0 ){
    if( strlen($simg) == 0 ){
        $simg = 'http://placehold.it/320x240';
    }
    $page = dbAddContents(floor($mode/2),$stitle,$stext,$simg,$page);
}
//編集
if( $mode == 0 || $mode == 2){
    if( $page >= 0 ){
        $data = dbGetContents($page);
        $mode = $data['mode'];
        $stitle = $data['title'];
        $stext  = $data['contents'];
        $simg   = $data['eyecatch'];        
    }
    $editpage($stitle,$stext,$simg,$page);
}else if ($mode == 1 || $mode == 3){
    include( "displist.html");
}
$sysftr();

