<?php
    /*
     *  Database Configuration
     */
    $db_host    = "localhost";
    $db_user    = "dev";
    $db_pw      = "streetwars";
    $db_db      = "blog";
    
    /*Tables: DO NOT CHANGE!*/
    $db_prefix          = ""; //keep empty, not yet fully implemented and may break things because of that
    $db_table_user      = "user";
    $db_table_entry     = "entry";
    $db_table_comment   = "comment";
    $db_table_acl       = "acl";
    /*$db_table_stats for later when including stats*/

    /*Version*/
    $codename   = "Flandre";
    $version    = "0.1.1";
    $release    = "alpha";
    //$build      = "2";
    /*API configuration*/
    $API_KEY    = "qwerty";
    /*general configuration*/
    $config['ssl']          = false;
    $config['force_ssl']    = false;

    $site_name      = "Seldan's Blog";
    $site_url       = "http://seldan.de/blog/";
    $site_url_ssl   = "https://seldan.de/blog/";
    if ($config['force_ssl']) {
        $site_url   = $site_url_ssl;
    }

    require_once "fortunes.conf.php";
?>