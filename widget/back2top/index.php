<?php
    include('settings.php');
    extract($settings);
    if       ( $location=='header'){
        echo "<style>\n";
        echo "#top-link-block.affix-top {\n";
        echo "    position: absolute; /* allows it to \"slide\" up into view */\n";
        echo "    bottom: -82px;\n";
        echo "    {$bt_position}: 10px;\n";
        echo "}\n";
        echo "#top-link-block.affix {\n";
        echo "    position: fixed; /* keeps it on the bottom once in view */\n";
        echo "    bottom: 18px;\n";
        echo "    {$bt_position}: 10px;\n";
        echo "}\n";
        echo "a.well{\n";
        echo "    color: {$bt_fgcolor};\n";
        echo "    background-color: {$bt_bgcolor};\n";
        echo "}\n";
        echo "</style>\n";
    }else if ( $location=='top'){
        echo "<span id=\"top-link-block\" class=\"hidden\">\n";
        echo "    <a href=\"#top\" class=\"well\" onclick=\"$('html,body').animate({scrollTop:0},'slow');return false;\">\n";
        echo "        {$bt_text}\n";
        echo "    </a>\n";
        echo "</span>\n";
    }else if ( $location=='bottom'){
        echo "<script>\n";
        echo "// Only enable if the document has a long scroll bar\n";
        echo "// Note the window height + offset\n";
        echo "if ( ($(window).height() + 20) < $(document).height() ) {\n";
        echo "    $('#top-link-block').removeClass('hidden').affix({\n";
        echo "        // how far to scroll down before link \"slides\" into view\n";
        echo "        offset: {top:100}\n";
        echo "    });\n";
        echo "}\n";
        echo "</script>\n";
    }else if ( $location=='footer'){
    }
