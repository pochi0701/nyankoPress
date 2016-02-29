    </div>
    <!-- ===== copyright ===== -->
    <div class="copyright">
      <p class="text-center">
        Copyright(c) 2015 <a href="http://www.birdland.co.jp">Birdland Ltd.</a> All Rights Reserved.
      </p>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.dropdown-toggle').click(function(e) {
             // 要素で親メニューリンクとドロップダウンメニュー表示を切り分ける
             if ($(e.target).hasClass('link-menu')) {
                 var location = $(this).attr('href');
                 window.location.href = location;
                 return false;
             }
             return true;
        });
    });
    </script>
    <?php
        global $settings;
        global $widget;
        $position = count($settings['widget_main']);
        if( $position>0){
            foreach( $settings['widget_main'] as $wgt ){
                $widget( array('name'=>$wgt,'location' =>'footer' ) );
            }
        }
    ?>
  </body>
</html>
