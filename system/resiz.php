<?php
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
//画像一覧取得
$path = "../img/";
$imglist = array();
if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if( ! is_dir("$path/$file") ){
            resizer($path,$file);
            //echo "$path   /    $file\n";
        }
    }
    closedir($handle);
}
//$path = "../img/";
//$file = "IMGP0396.JPG";
//resizer($path,$file);  
