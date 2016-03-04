<?php include("settings.php");extract($settings);
      $afs =($allowfullscreen=='on')?' allowfullscreen':'';
      $apy =($autoplay       =='on')?' autoplay':'';
      global $_widgets;
      if( ! isset($_widgets['youtube'])) $_widgets['youtube'] = 0;
echo "<div class=\"embed-responsive embed-responsive-16by9\">\n";
echo "  <iframe class=\"embed-responsive-item\" style=\"width:{$width}; height:{$height};\" src=\"https://www.youtube.com/embed/{$name[$_widgets['youtube']++]}\"{$afs}{$apy}></iframe>\n";
echo "</div>\n";
