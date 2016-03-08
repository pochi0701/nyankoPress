<?php
    include('settings.php');
    extract($settings);
    echo "<div class=\"{$mode}\">\n";
    if( strlen($twitter) )  echo "<a href=\"{$twitter}\"><i class=\"fa fa-twitter fa-3x\"></i></a>\n";
    if( strlen($facebook) ) echo "<a href=\"{$facebook}\"><i class=\"fa fa-facebook-official fa-3x\"></i></a>\n";
    if( strlen($linkedin) ) echo "<a href=\"{$linkedin}\"><i class=\"fa fa-linkedin fa-3x\"></i></a>\n";
    if( strlen($google) )   echo "<a href=\"{$google}\"><i class=\"fa fa-google-plus fa-3x\"></i></a>\n";
    if( strlen($github) )   echo "<a href=\"{$github}\"><i class=\"fa fa-github fa-3x\"></i></a>\n";
    if( strlen($mail) )     echo "<a href=\"mailto:{$mail}\"><i class=\"fa fa-envelope fa-3x\"></i></a>\n";
    if( strlen($tel) )      echo "<a href=\"tel:{$tel}\"><i class=\"fa fa-phone-square fa-3x\"></i></a>\n";
    echo "</div>\n";
