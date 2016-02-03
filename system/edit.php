<?php
global $syshdr;
global $sysftr;
global $editpage;
global $_contents;
$syshdr(array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
$submit = array_get($_POST,'submit');
$stitle = array_get($_POST,'title');
$stext  = array_get($_POST,'text');
$shead  = array_get($_POST,'head');
$simg   = array_get($_POST,'simg');
$snativ = array_get($_POST,'native');
$ptag   = array_get($_POST,'ptag');
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
//投稿された
if( strlen($submit)>0 ){
    if( strlen($simg) == 0 ){
        $simg = 'http://placehold.it/320x240';
    }
    if( strlen($ptag) ) $stext = entag($stext);
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
    $editpage(array('title'=>$stitle,'text'=>$stext,'head'=>$shead,'img'=>$simg,'mode'=>$mode*2,'page'=>$page,'native'=>$snativ));
}else if ($mode == 1 || $mode == 3){
    $del = array_getn($_GET,'del');
    if( $del > 0 && $page > 0 ){
        dbDelContents($page);
    }        
    include( "displist.html");
}
$sysftr();

