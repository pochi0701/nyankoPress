<?php
global $header;
global $footer;
global $widget;
global $native;
global $settings;
$header($data['title'],$bland,$menu,$data['header']);
$fixl = count($settings['widget-fixl']);
$fixr = count($settings['widget-fixr']);
//left widget
if( $fixl+$fixr>0){
    $grid = 12;
    echo "<div class=\"row\">\n";
    if( $fixl > 0 ){
        $grid -= 2;
        echo "  <div class=\"col-xs-12 col-sm-2 col-md-2\">\n";
        foreach( $settings['widget-fixl'] as $wgt ){
            $widget( $wgt );
        }
        echo "  </div>\n";
    }
    if( $fixr > 0 ){
        $grid -= 2;
    }
    echo "  <div class=\"col-xs-12 col-sm-{$grid} col-md-{$grid}\">\n";
}
//title
if($data['mode'] == 0){
    echo "<div class=\"panel panel-default\">\n";
    echo "  <div class=\"panel-heading\">\n";
    echo "    <h2>{$data['title']}</h2>\n";
    echo "  </div>\n";
    echo "  <div class=\"panel-body\">\n";
    echo "    <img src=\"{$data['eyecatch']}\" class=\"img-responsive\">\n";
    echo "  </div>\n";
    echo "</div>\n";
    echo "<span>投稿日：".date('Y年m月d日 H時i分s秒',strtotime($data['regdate']))."</span>\n"; 
}
//main contents
if( $data['native'] == 'on'){
    $native($data['contents']);
}else{
    echo $data['contents'];
}
//right widget
if( $fixr > 0 ){
    echo "  <div class=\"col-xs-12 col-sm-2 col-md-2\">\n";
    foreach( $settings['widget-fixr'] as $wgt ){
        $widget( $wgt );
    }
    echo "  </div>\n";
}
if( $fixl+$fixr>0 ){
    echo "</div>\n";//-row
}
$footer();
