<?php
global $syshdr;
global $sysftr;
global $editpage;
global $_contents;
$syshdr(array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
$submit = array_get($_POST,'submit');
$title    = array_get($_POST,'title');
$text     = array_get($_POST,'text');
$head     = array_get($_POST,'head');
$eyecatch = array_get($_POST,'eyecatch');
$native   = array_get($_POST,'native');
$ptag     = array_get($_POST,'ptag');
//投稿された
if( strlen($submit)>0 ){
    if( strlen($eyecatch) == 0 ){
        $eyecatch = 'http://placehold.it/320x240';
    }
    if( strlen($ptag) ) $text = entag($text);
    $page = dbAddContents(array('mode'=>$mode,'title'=>$title,'contents'=>$text,'header'=>$head,'eyecatch'=>$eyecatch,'page'=>$page,'native'=>$native));
}
//編集
if( $mode == 0 || $mode == 1){
    if( $page >= 0 ){
        $data = dbGetContents($page);
        $mode     = $data['mode'];
        $title    = $data['title'];
        $head     = $data['header'];
        $text     = $data['contents'];
        $eyecatch = $data['eyecatch'];        
        $native   = $data['native'];        
    }
    $editpage(array('title'=>$title,'text'=>$text,'head'=>$head,'eyecatch'=>$eyecatch,'mode'=>$mode,'page'=>$page,'native'=>$native));
    $path = 'system/snippets';
    if( isset($_SESSION) && isset($_SESSION['snplst']) ){
        $snplst = $_SESSION['snplst'];
    }else{
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if( ! is_dir("$path/$file") ){
                    include("$path/$file");
                    $snplst["$path/$file"] = $snippet;
                }
            }
            closedir($handle);
        }
        usort($snplst, function ($a, $b) { return $b['Title'] < $a['Title']; });
        $_SESSION['snplst'] = $snplst;
    }
    include( "snippet.html");
}else if ($mode == 2 || $mode == 3){
    if( array_getn($_GET,'del') > 0 && $page > 0 ){
        dbDelContents($page);
    }
    $_contents2 = $_contents;
    usort($_contents2, function ($a, $b) { return strtotime($b['regdate']) - strtotime($a['regdate']); });

    include( "displist.html");
}
$sysftr();

