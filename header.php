<?php
    if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    require "conf/main.conf.php";
    if($show_header) {
        echo "<div id=\"header\"><img src=\"".$header_url."\" alt=\"Website header\"></div>\n";
    }
?>