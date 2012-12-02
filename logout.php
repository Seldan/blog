<?php
session_start();
require "inc/functions.inc.php";
logout();
header ('HTTP/1.1 307 Temporary Redirect');
header ('Location: '.$_SERVER['HTTP_REFERER']);
?>