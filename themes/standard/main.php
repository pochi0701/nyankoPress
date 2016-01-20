<?php
global $header;
global $footer;
$header($data['title'],$bland,$menu);
if($data['mode'] == 0){
echo "<div class=\"panel panel-default\">\n";
echo "  <div class=\"panel-heading\">\n";
echo "    <h2>{$data['title']}</h2>\n";
echo "  </div>\n";
echo "  <div class=\"panel-body\">\n";
echo "    <img src=\"{$data['eyecatch']}\">\n";
echo "  </div>\n";
echo "</div>\n";
}
$lines = explode("\n",$data['contents']);
foreach( $lines as $line){
    if( isset($line)>0 && strlen($line) > 0  && $line[0] === '#' ){
        eval(substr($line,1));
    }else{
        echo "$line\n";
    }
}
//echo $data['contents']."\n";
$footer();

