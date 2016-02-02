<?php
//カレンダーを表示する
list($y,$m) = (isset($_GET['ym']))?explode('/',$_GET['ym']):array(null,null);
if( ! isset($m) ) $m = date('m');
if( ! isset($y) ) $y = date('Y');
$ld = date("t", mktime(0, 0, 0, $m, 1, $y));//最終日
$w  = date("w", mktime(0, 0, 0, $m, 1, $y));//１日の曜日
//7x6w分の配列に開始日から終了日まで設定
for( $i = 0 ; $i < 42 ; $i++ ){
    $d[$i] = ( $w <= $i && $i-$w<$ld)?$i-$w+1:0;
}
//処理用
$ln = floor(($ld+$w-1)/7)+1;
if( date("Y/m")>date("Y/m",mktime(0,0,0,$m+1,0,$y))){
    $nym = date('Y/m',mktime(0,0,0,$m+1,1,$y));
}
$lym = date('Y/m',mktime(0,0,0,$m-1,1,$y));
//何故かこのパスのincludeでうまくいくんだよね
include('calender.html');
