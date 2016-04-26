<?php
    global $header;
    global $footer;
    global $widget;
    global $native;
    global $settings;
    $wl = count($settings['widget_l']);
    $wr = count($settings['widget_r']);
    $header(array('title'=>$title,'bland'=>$bland,'head'=>$data['header'],'menu'=>$menu,'wgt_name'=>'widget_mainidx'));
    if( isset($_SESSION) && isset($_SESSION['login']) && $_SESSION['login'] == 1 )  echo "<a class = \"btn btn-primary\" href=\"index.php?mode={$data['mode']}&p={$data['page']}\">編集</a>\n";
    $mainidx = count($settings['widget_mainidx']);
    if( $mainidx>0){
        foreach( $settings['widget_mainidx'] as $wgt ){
            $widget( array('name'=>$wgt,'location' =>'top' ));
        }
    }
    if( $wl+$wr > 0 ){ 
        echo "<div class=\"row\">\n";
        //widget_l
        $grid = 12;
        if( $wl > 0 ){
            $grid -= 2;
            echo "  <div class=\"col-xs-12 col-sm-2 col-md-2\">\n";
            foreach( $settings['widget_l'] as $wgt ){
                $widget( array('name'=>$wgt) );
            }
            echo "  </div>\n";  
        }
        if( $wr > 0 ){
            $grid -= 2;
        }
        echo "  <div class=\"col-xs-12 col-sm-{$grid} col-md-{$grid}\">\n";
    }
    //メインコンテンツ
    if( $data['native'] == 'on'){
        $native($data['contents']);
    }else{
        echo $data['contents'];
    }
    //main contents
    //pagenation
    $_contents = dbSortedContents(array('ym'=>$ym));
    $page = array_getn($_GET,'page');
    $perPage = 4;
    $total = 0;
    foreach( $_contents as $value){
        if( $value['mode'] == 0 ) $total++;
    }
    $param = Pagenation($total,$page,$perPage);
    extract($param);
    $cnt2=-1;
    //display
    foreach( $_contents as $value){
        //投稿ページのみ
        if( $value['mode'] == 0 ){
            $cnt2++;
            if($cnt2<$start) continue;
            if($cnt2>=$start+$perPage) continue;
?>
            <div class="panel panel-info">
              <div class="panel-heading"><h4><?php echo "<a href=\"index.php?p={$value['page']}\">{$value['title']}</a>";?></h4></div>
              <div class="panel-body">
                <?php echo "<span><small>投稿日：".date('Y年m月d日 H時i分s秒',strtotime($data['regdate']))."</small></span>\n"; ?>
                <?php echo "<p>".mb_strimwidth(strip_tags($value['contents']),0, 120, '…', 'utf-8')."</p>\n"; ?>
            </div>
          </div>
<?php
        }
    }
    echo "  </div>\n";
    if( $wr > 0 ){
        echo "  <div class=\"col-xs-12 col-sm-2 col-md-2\">\n";
        foreach( $settings['widget_r'] as $wgt ){
            $widget( array('name'=>$wgt) );
        }
        echo "  </div>\n";
    }
    if( $wr+$wl>0 ){
        echo "</div>\n";
    }
    if( $mainidx>0){
        foreach( $settings['widget_mainidx'] as $wgt ){
            $widget( array('name'=>$wgt,'location' =>'bottom' ));
        }
    } 
    echo "<div class=\"text-center\">\n";
    echo "<ul class=\"pagination\">\n";
    echo "<li".(($prv==0)?" class=\"disabled\"":"")."><a href=\"index.php?&page={$prv}\">前</a></li>\n";
    for( $num = $st ; $num<=$ed ; $num++ ){
         echo "<li".(($page==$num)?" class=\"active\"":"")."><a href=\"index.php?&page={$num}\">{$num}</a></li>\n";
    }
    echo "<li".(($nxt==0)?" class=\"disabled\"":"")."><a href=\"index.php?&page={$nxt}\">次</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    $footer(array('wgt_name'=>'widget_mainidx'));

