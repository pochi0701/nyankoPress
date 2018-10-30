<?php
require_once('req.php');
$errmsg = ""; // エラーメッセージ
define("FOLDER_UPLOAD" ,"img") ; // 保存先のフォルダ名  
//$path：パス末尾はデリミタあり、なし可能
//$file：ファイル名
function resizer($path,$file)
{
    //$pathの末尾から'/'を削除
    $path   = rtrim($path,"/");
    $target = "$path/$file";
    list($x,$y) = getimagesize($target);
    //800x600より大きい物はoriginalにコピーして現物を縮小
    //それ以下のものは変更しない
    if( $x>800 && $y>600 ){
        $newFile = "$path/original/{$file}";
        if( 3*$x>4*$y ){
            $nx = 800;
            $ny = intval($y*800/$x);
        }else{
            $ny = 600;
            $nx = intval($x*600/$y);
        }
        $type = exif_imagetype($target);
        if( $type === IMAGETYPE_GIF ){
            //　画像生成
            copy( $target, $newFile);
            $in  = ImageCreateFromGIF($target);
            $out = ImageCreateTrueColor($nx , $ny);
            ImageCopyResampled($out, $in,0,0,0,0, $nx, $ny, $x, $y);
            ImageGIF($out, $target);
        }else if ( $type === IMAGETYPE_JPEG ){
            //　画像生成
            copy( $target, $newFile);
            $in  = ImageCreateFromJPEG($target);
            $out = ImageCreateTrueColor($nx , $ny);
            ImageCopyResampled($out, $in,0,0,0,0, $nx, $ny, $x, $y);
            ImageJPEG($out, $target);
        }else if ( $type === IMAGETYPE_PNG  ){
            //　画像生成
            copy( $target, $newFile);
            $in  = ImageCreateFromPNG($target);
            $out = ImageCreateTrueColor($nx , $ny);
            ImageCopyResampled($out, $in,0,0,0,0, $nx, $ny, $x, $y);
            ImagePNG($out, $target);
        }
    }
}
function getimglist()
{
    //画像一覧取得
    $path = FOLDER_UPLOAD;
    $imglist = array();
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            if( ! is_dir("$path/$file") ){
                $imglist[] = array('url'=>"$path/$file",'file'=>$file,'mtime'=>filemtime("$path/$file"));
            }
        }
        closedir($handle);
    }
    usort($imglist, function ($a, $b) { return $b['mtime'] - $a['mtime']; });
    $cnt=0;
    $ec=0;
    $msg = "";
    foreach($imglist as $ary){
        extract($ary);
        if( $cnt % 4 == 0 ){
            $msg .=  "<div class=\"row\">\n";
            $ec = 1;
        }
        $msg .= "<div class=\"col-xs-6 col-sm-4 col-md-3\"><input type=\"text\" class=\"form-control\" value=\"{$url}\"><a href=\"#\" data-href=\"index.php?mode=4&del={$file}\" data-toggle=\"modal\" data-target=\"#confirm-delete\"><img src=\"{$url}\" class=\"img-responsive\"></a></div>\n";
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
            $path      = FOLDER_UPLOAD;
            $file      = $_FILES['upfile']['name'][$key];
            if (move_uploaded_file($_FILES['upfile']['tmp_name'][$key],$filename)){
                chmod($filename,0644);  
                //大きかったら自動リサイズ
                resizer($path,$file);
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
    $delfile = array_get($_GET,'del');
    if( strlen($delfile)>0 ) unlink(FOLDER_UPLOAD.'/'.$delfile); 
    $errmsg = getimglist();
}
global $syshdr;
global $sysftr;
$head = <<<'EOT'
    <style type="text/css">
        /* layout.css Style */
.upload-drop-zone {
  height: 200px;
  border-width: 2px;
  margin-bottom: 20px;
}

/* skin.css Style*/

  color: #ccc;
  border-style: dashed;
  border-color: #ccc;
  line-height: 200px;
  text-align: center
}
.upload-drop-zone.drop {
  color: #222;
  border-color: #222;
}
#loading{
  position:absolute;
  left:50%;
  top:20%;
  margin-left:-30px;
  display:none;
}
    </style>
EOT;
$syshdr(array('title'=>$title,'bland'=>$bland,'menu'=>$menu,'head'=>$head));
include("upload.html");
$sysftr();
