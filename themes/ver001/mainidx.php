<?php
    global $header;
    global $footer;
    global $widget;
    global $native;
    global $settings;
    $wl = count($settings['widget-l']);
    $wr = count($settings['widget-r']);
    $header($title,$bland,$menu,$data['header']);
    if( $wl+$wr > 0 ){ 
        echo "<div class=\"row\">\n";
        //widget-l
        $grid = 12;
        if( $wl > 0 ){
            $grid -= 2;
            echo "  <div class=\"col-xs-12 col-sm-2 col-md-2\">\n";
            foreach( $settings['widget-l'] as $wgt ){
                $widget( $wgt );
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
    $cnt = 0;
    $ec = 0;
    $_contents = dbSortedContents(0);
    foreach( $_contents as $value){
        //投稿ページのみ
        if( $value['mode'] === 0 ){
            if( $cnt % 3 == 0 ){
                echo "        <div class=\"row\">\n";
                $ec += 1;
            }
?>
          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="thumbnail">
              <h4><?php echo "<a href=\"index.php?p={$value['page']}\">{$value['title']}</a>";?></h4>
              <img src="<?php echo $value['eyecatch']; ?>" alt="...">
              <div class="caption">
              </div>
            </div>
          </div>
<?php
           if( $cnt % 3 == 2 ){
                echo "</div>\n";
                $ec -= 1;
           }
           $cnt = $cnt + 1;
        }
    }
    if( $ec > 0 ){
        echo "</div>\n";
    }
    echo "  </div>\n";
    if( $wr > 0 ){
        echo "  <div class=\"col-xs-12 col-sm-2 col-md-2\">\n";
        foreach( $settings['widget-r'] as $wgt ){
            $widget( $wgt );
        }
        echo "  </div>\n";
    }
    if( $wr+$wl>0 ){
        echo "</div>\n";
    } 
    $footer();

