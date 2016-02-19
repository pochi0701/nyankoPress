<?php
$_contents = array();
function dbLoad()
{
    global $_contents;
    global $_menu;
    if( file_exists("db/contents.txt") ){
        $_contents = json_decode(file_get_contents("db/contents.txt"),true);
    }
    foreach($_contents as $key => $value){
        if( ! isset($value['regdate']) ){
            $value['regdate'] = date("Y-m-d H:i:s");
            $_contents[$key] = $value;
        }
   }
}
function dbConv()
{
   global $_contents;
   $_contents2 = array();
   foreach($_contents as $key => $value){
        $line  = array('page'=>$value['page']);
        $line += array('mode'=>$value['mode']);
        $line += array('title'=>$value['title']);
        $line += array('contents'=>$value['contents']);
        $line += array('header'=>$value['header']);
        $line += array('eyecatch'=>$value['eyecatch']);
        $line += array('regdate'=>$value['regdate']);
        $line += array('moddate'=>$value['moddate']);
        $line += array('auther'=>$value{'auther']);
        $line += array('native'=>$value['native']);
        $_contents2[] = $line;
   }
   file_put_contents("db/contents.txt",json_encode($_contents2));
}
dbLoad();
dbConv();

