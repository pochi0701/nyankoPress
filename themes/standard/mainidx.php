<?php
    global $header;
    global $footer;
    global $_contents;
    $header($title,$bland,$menu);
    echo $data['contents'];
    $cnt = 0;
    $ec = 0;
    foreach( $_contents as $key => $value){
        //投稿ページのみ
        if( $value['mode'] == 0 ){
            if( $cnt % 3 == 0 ){
                echo "        <div class=\"row\">\n";
                $ec += 1;
            }
?>
          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="thumbnail">
              <h4><?php echo "<a href=\"index.php?p={$key}\">{$value['title']}</a>";?></h4>
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
    $footer();

