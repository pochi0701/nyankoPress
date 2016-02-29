<?php include("settings.php");extract($settings);
      $afs =($allowfullscreen=='on')?' allowfullscreen':'';
      $apy =($autoplay       =='on')?' autoplay':'';
      global $_widgetcnt;
echo "<div class=\"embed-responsive embed-responsive-16by9\">\n";
echo "  <iframe class=\"embed-responsive-item\" style=\"width:{$width}; height:{$height};\" src=\"https://www.youtube.com/embed/{$name[$_widgetcnt++]}\"{$afs}{$apy}></iframe>\n";
echo "</div>\n";
