<?php
global $syshdr;
global $sysftr;
global $_contents;
$syshdr($title,$bland,$menu);
$submit = array_get($_POST,'submit');
$sbland = array_get($_POST,'bland');
$text   = array_get($_POST,'text');
//投稿された
if( strlen($submit) ){
    //$_menu構築
    $smenu = array();
    $array=preg_split("/[\r\n]+/",$text);
    $cnt = -1;
    foreach( $array as $value){
        $value = mb_convert_kana($value,'s','UTF-8');
        $line = explode(" ",$value);
        if( count($line) == 2 ){
            $smenu   += array($line[0] => $line[1]);
        }else if ( count($line) == 3 && strlen($line[0]) == 0 ){
            if( is_array($smenu[$cnt]) ){
                $smenu[$cnt] += array($line[1] => $line[2]);
            }else{
                $smenu[]  = array($line[1] => $line[2]);
                $cnt += 1;
            }
        }
    }
    $tmenu['bland'] = $sbland;
    $tmenu['menu']  = $smenu;
    dbSetMenu($tmenu);
    header("Location:../index.php?mode=1");
//編集
}else{    
    list($sbland,$smenu) = dbGetMenu(-1);
    foreach( $smenu as $key => $value ){
        if( is_array($value) ){
            foreach( $value as $key2 => $value2 ){
                $text .= " {$key2} {$value2}\n";
            }
        }else{
            $text .= "{$key} {$value}\n";
        }
    }
    $text .= "\n";
    foreach( $_contents as $key => $value ){
        if( $value['mode'] == 1 ){
            if( strpos($text,$value['title']) === false && strpos($text,"index.php?p={$key}") === false ){
                $text .= "{$value['title']} index.php?p={$key}\n";
            }
        }
    }
    include( "editmenu.html");
}
$sysftr();

