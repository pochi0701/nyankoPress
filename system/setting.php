<?php
global $syshdr;
global $sysftr;
global $editmenu;
$target=array_get($_GET,'target');
$widget=array_get($_GET,'widget');
$themes=array_get($_GET,'themes');
$syshdr(array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
if( !isset($target) ) $target='general';
if      ($target == 'general') {$inc = 'editsetting.php' ;$path = 'system';}
else if ($target == 'widget')  {$inc = 'editsetting.php' ;$path = "widget/$widget";}
else if ($target == 'themes')  {$inc = 'edittheme.php'   ;$path = "themes/$themes";}
else if ($target == 'menu')    {$inc = 'editmenu.php'    ;$path = '';}
else if ($target == 'vc')      {$inc = 'viewcontents.php';$path = '';}
$wpath = "widget";
function dlist($path){
    $list = array();
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            if( is_dir("$path/$file") && $file[0] != '.'){
                $list[] = "$file";
            }
        }
        closedir($handle);
    }
    return $list;
}
?>
<div class="row">
<div class="col-sm-2">
<h4>一般設定</h4>
<div class="list-group">
  <a href="index.php?mode=5&target=general"                class="list-group-item<?php echo (($target=='general')?' active':'');?>">一般</a>
  <a href="index.php?mode=5&target=menu"                   class="list-group-item<?php echo (($target=='menu')?' active':'');?>">メニュー編集</a>
  <a href="index.php?signin=1&force=1"                     class="list-group-item">ログインユーザの追加</a>
  <a href="index.php?mode=5&target=vc"                     class="list-group-item<?php echo (($target=='vc')?' active':'');?>">コンテンツダンプ</a>
</div>
<h4>ウィジット設定</h4>
<div class="list-group">
  <?php $list = dlist('widget');
        foreach( $list as $value ){
            echo "  <a href=\"index.php?mode=5&target=widget&widget={$value}\" class=\"list-group-item".(($widget==$value)?' active':'')."\">{$value}</a>\n";
        }?>
</div>
<h4>テーマ編集</h4>
<div class="list-group">
  <?php $list = dlist('themes');
        foreach( $list as $value ){
            echo "  <a href=\"index.php?mode=5&target=themes&themes={$value}\" class=\"list-group-item".(($themes==$value)?' active':'')."\">{$value}</a>\n";
        }?>
</div>
</div>
<div class="col-sm-10">
<?php
include($inc);
?>
</div>
</div>
<?php
$sysftr();
