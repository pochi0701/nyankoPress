<?php
global $syshdr;
global $sysftr;
global $_contents;
$submit = array_get($_POST,'submit');
$sbland = array_get($_POST,'bland');
$text   = array_get($_POST,'text');
//投稿された
if( strlen($submit) ){
    //$_menu構築
    $smenu = array();
    $array=preg_split("/[\r\n]+/",$text);
    $cnt = 0;
    foreach( $array as $value){
        if( strlen($value) > 0 ){
            $value = mb_convert_kana($value,'s','UTF-8');
            $flag = ($value[0]==' ')?1:0; 
            $line = explode(",",trim($value));
            if( count($line) == 2 ){        
                if( $flag == 0 ){
                    $smenu   += array($line[0] => $line[1]);
                    //通常メニューが来たら$prevリセット
                    unset($prev);
                }else{
                    //$prevが設定されてたら追加
                    if( isset($prev) ){
                        $prev += array($line[0] => $line[1]);
                    }else{
                        //初回の２段目について$prevに保存
                        $smenu[$cnt]  = array($line[0] => $line[1]);
                        $prev = &$smenu[$cnt];
                        $cnt++;
                    }
                }
            }
        }else{
            break;
        }
    }
    unset($prev);
    dbSetMenu(array('bland'=>$sbland,'menu'=>$smenu));
    echo "設定完了";
//編集
}else{    
    list($sbland,$smenu) = dbGetMenu(-1);
    foreach( $smenu as $key => $value ){
        if( is_array($value) ){
            foreach( $value as $key2 => $value2 ){
                $text .= " {$key2},{$value2}\n";
            }
        }else{
            $text .= "{$key},{$value}\n";
        }
    }
    $text .= "\n";
    foreach( $_contents as $value ){
        if( $value['mode'] == 1 ){ //固定ページのみ
            if( strpos($text,$value['title']) === false && strpos($text,"index.php?p={$value['page']}") === false ){
                $text .= "{$value['title']},index.php?p={$value['page']}\n";
            }
        }
    }
    include( "editmenu.html");
}

