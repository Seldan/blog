<?php
    if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    require "conf/main.conf.php";
    if($header_show) {
        echo "      <div id=\"header\"><a href=\"".$site_url."\" ><img src=\"".$header_url."\" alt=\"Website header\"></a></div>\n";
    }
?>
