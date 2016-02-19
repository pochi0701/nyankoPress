<?php
session_start();
require_once("req.php");
$id=array_get($_POST,"username");
$pw=array_get($_POST,"password");
$em=array_get($_POST,"email");
include("info.php");
$msg = "";
if( array_get($_GET,'force') == '' && isset($_SESSION) && array_getn($_SESSION,'login') == 1 ){
    header("Location:../index.php?mode=0");
    exit;
}
if( ! isset($login) ){
    $msg = "IDとパスワードを記録します。";
}   
if( strlen($id)>0 && strlen($pw) ) {
    //初回
    if( ! isset($login) && strlen($em)>0){
        $msg = array('userid'=>$id,'password'=>md5($pw),'email'=>$em);
        $login[] = $msg;
        file_put_contents("info.php",'<?php $login = json_decode(\''.json_encode($login).'\',true);'."\n");
        $_SESSION['login'] = 1;
        $_SESSION['auther'] = $id;
        header("Location:../index.php?mode=0");
        exit;
    //２回目以降
    }else if ( strlen($em)>0 && $_SESSION['login'] === 1){
        $msg = array('userid'=>$id,'password'=>md5($pw),'email'=>$em);
        $login[] = $msg;
        file_put_contents("info.php",'<?php $login = json_decode(\''.json_encode($login).'\',true);'."\n");
        $_SESSION['login'] = 1;
        $_SESSION['auther'] = $id;
        header("Location:../index.php?mode=0");
        exit;
    }else{
        foreach( $login as $key => $value){
            if( $value['userid'] === $id && $value['password'] === md5($pw) ){
                $_SESSION['login'] = 1;
                $_SESSION['auther'] = $id;
                header("Location:../index.php?mode=0");
                exit;
            }
        }
        $msg = "IDまたはパスワードが違います。";
    }
}
include("login.html");

