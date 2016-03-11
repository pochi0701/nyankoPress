<?php include("settings.php");extract($settings);
      $afs =($allowfullscreen=='on')?' allowfullscreen':'';
      $apy =($autoplay       =='on')?' autoplay':'';
      global $_widgets;
      if( ! isset($_widgets['youtube'])) $_widgets['youtube'] = 0;
echo "<div class=\"embed-responsive embed-responsive-{$size[$_widgets['youtube']]}\">\n";
echo "  <iframe class=\"embed-responsive-item\"  src=\"https://www.youtube.com/embed/{$name[$_widgets['youtube']]}\"{$afs}{$apy}></iframe>\n";
echo "</div>\n";
echo "<p>{$title[$_widgets['youtube']++]}</p>\n";
