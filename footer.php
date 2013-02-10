<?php
    if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    require_once "conf/main.conf.php";
    if ($show_fortunes) {
        require_once "conf/fortunes.conf.php";
        require_once "inc/fortune.inc.php";
        echo "<div id=footer>(c)".$site_name." 2011 - ".date("Y", time())." | ". fortune($fortunes) ." | \"".$codename."\" Ver. ".$version."-".$release."</div>\n";
    } else {
        echo "<div id=footer>(c)".$site_name." 2011 - ".date("Y", time())." | \"".$codename."\" Ver. ".$version."-".$release."</div>\n";
    }

?>