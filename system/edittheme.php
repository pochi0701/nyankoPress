<?php
$theme = array_get($_GET,'themes');
$file  = array_get($_GET,'file');
$mode  = array_get($_GET,'mode');
if( strlen($file)==0 ) $file="main.php";
$text = file_get_contents("themes/$theme/$file");
function flist($path){
    $list = array();
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            if( is_file("$path/$file") ){
                $list[] = "$file";
            }
        }
        closedir($handle);
    }
    return $list;
}
?>
<div class="row">
  <div class="col-sm-10">
    <form class="form-horizontal" role="form" method="post" action="<?php echo "index.php?mode={$mode}&target=themes&themes={$theme}&file={$file}";?>">
      <div class="form-group">
        <textarea class="form-control" id="text" name="text" rows="20"><?php echo htmlspecialchars($text);?></textarea>
      </div>
      <div class="form-group">
        <button type="submit" name="submit" value="submit" class="btn btn-primary">登録</button>
      </div>
    </form>
  </div>
  <div class="col-sm-2">
    <div class="list-group">
    <?php $list = flist("themes/{$theme}/");
        foreach( $list as $value ){
            echo "  <a href=\"index.php?mode=5&target=themes&themes={$theme}&file={$value}\" class=\"list-group-item".(($file==$value)?' active':'')."\">{$value}</a>\n";
        }?>
    </div>
  </div>
</div>    
