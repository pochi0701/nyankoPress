<?php
require_once('req.php');
$errmsg = ""; // エラーメッセージ
define("FOLDER_UPLOAD" ,"img") ; // 保存先のフォルダ名  
function getimglist()
{
    //画像一覧取得
    $path = FOLDER_UPLOAD;
    $imglist = array();
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            if( ! is_dir("$path/$file") ){
                $imglist[] = "$path/$file";
            }
        }
        closedir($handle);
    }
    $cnt=0;
    $ec=0;
    $msg = "";
    foreach($imglist as $url){
        if( $cnt % 4 == 0 ){
            $msg .=  "<div class=\"row\">\n";
            $ec = 1;
        }
        $msg .= "<div class=\"col-xs-6 col-sm-4 col-md-3\"><input type=\"text\" value=\"{$url}\"><img src=\"{$url}\" class=\"img-responsive\"></div>\n";
        if( $cnt % 4 == 3 ){
            $msg .= "</div>\n";
            $ec = 0;
        }
        $cnt += 1;
    }
    if( $ec>0 ){
        $msg .= "</div>\n";
    }
    return $msg;
}
//upload
if (isset($_FILES['upfile'])){
    // エラーの確認
    foreach ($_FILES['upfile']['error'] as $key => $error) {
        // アップロード系のエラー
        switch ($error) {
        case UPLOAD_ERR_OK: // OK
            break;
        case UPLOAD_ERR_NO_FILE:   
            $errmsg = "<span class=\"text-danger\">ファイルが選択されていません。</span><br />";
            break;
        case UPLOAD_ERR_INI_SIZE:  
            $errmsg .= "<span class=\"text-danger\">「{$_FILES['upfile']['name'][$key]}」のファイルサイズが最大値を超えています。</span><br />";
            break;
        default:
            $errmsg .= "<span class=\"text-danger\">「{$_FILES['upfile']['name'][$key]}」：エラーが発生しました。</span><br />";
            break;
        }                
             
        if ($error === UPLOAD_ERR_OK){
            // 同名ファイルの確認
            if (file_exists(FOLDER_UPLOAD."/".$_FILES['upfile']['name'][$key])){            
                $errmsg .= "<span class=\"text-danger\">「{$_FILES['upfile']['name'][$key]}」は既に存在します。</span><br />";  
            }           
                  
            // ファイルのタイプの確認
            if (!( ($_FILES['upfile']['type'][$key] === 'image/gif')  || 
                   ($_FILES['upfile']['type'][$key] === 'image/jpeg') ||
                   ($_FILES['upfile']['type'][$key] === 'image/png'))){
                $errmsg .= "<span class=\"text-danger\">「{$_FILES['upfile']['name'][$key]}」は対応していない形式です。</span><br />"; 
            }
        }                              
    }  
              
    // ファイルのアップロード
    if ($errmsg  == ""){
        foreach ($_FILES['upfile']['error'] as $key => $value) {   
            $filename  = FOLDER_UPLOAD."/".$_FILES['upfile']['name'][$key];
            if (move_uploaded_file($_FILES['upfile']['tmp_name'][$key],$filename)){
                chmod($filename,0644);  
            }else{
               $errmsg .= "<span class=\"text-danger\">ファイルのアップロードに失敗しました。</span><br />";        
            }  
        }       
    } 
    if( $errmsg == "" ){
        $errmsg = getimglist();//画像一覧取得
    }          
          
    // ドラッグ&ドロップの場合は終了
    if ($_GET["drop"] == 1){
     // 下記2行の処理はAjaxで必須
       echo $errmsg;
       exit();
    }      
}else{
    $errmsg = getimglist();
}
global $syshdr;
global $sysftr;
$syshdr(array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
include("upload.html");
$sysftr();
