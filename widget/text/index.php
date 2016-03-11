<?php
    include('settings.php');
    extract($settings);
    global $_widgets;
    if( ! isset($_widgets['text'])) $_widgets['text'] = 0;
    if( isset($ins_text[$_widgets['text']]) ) echo $ins_text[$_widgets['text']++];
