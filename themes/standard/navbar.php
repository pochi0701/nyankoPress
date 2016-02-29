    <div class="container">
      <!-- 1.ナビゲーションバーの設定 -->
      <nav class="navbar navbar-default">
        <!-- 2.ヘッダ情報 -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-menu-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $bland;?></a>
        </div>
        <!-- 3.リストの配置 -->
        <div class="collapse navbar-collapse" id="nav-menu-1">
          <ul class="nav navbar-nav">
             <?php
                 $okey = null;
                 $ovalue = null;
                 foreach($menu as $key => $value){
                   if( isset($okey) ){
                     if( is_array( $value ) ){
                       $flag = array_key_exists($target,$value);
                       echo "<li class=\"dropdown".(($flag)?" active":"")."\">\n";
                       echo "  <a href=\"{$ovalue}\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
                       echo "  <span class=\"link-menu\">{$okey}<b class=\"caret\"></b></span>\n";
                       echo "  </a>\n";
                       echo "  <ul class=\"dropdown-menu\">\n";
                       foreach($value as $key2 => $value2 ){
                           echo "    <li><a href=\"{$value2}\">{$key2}</a></li>\n";
                       }
                       echo "  </ul>\n";
                       echo "</li>\n";
                       unset($okey);
                       unset($ovalue);
                     }else{
                       if( $okey === $target ){
                         echo "<li class=\"active\"><a href=\"{$ovalue}\">{$okey}</a></li>\n";
                       }else{
                         echo "<li><a href=\"{$ovalue}\">{$okey}</a></li>\n";
                       }
                       $okey = $key;
                       $ovalue = $value;
                     }
                   }else{
                     $okey = $key;
                     $ovalue = $value;
                   }
                 }
                 //残り要素
                 if( ! is_null($okey) ){
                   if( $okey === $target ){
                     echo "<li class=\"active\"><a href=\"{$ovalue}\">{$okey}</a></li>\n";
                   }else{
                     echo "<li><a href=\"{$ovalue}\">{$okey}</a></li>\n";
                   }
                 }
             ?>
          </ul>
        </div>
      </nav>
    </div>
