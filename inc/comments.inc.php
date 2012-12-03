<?php

function get_comment_count($pid) {
    require "conf/main.conf.php";
    //make sure pid is int
    $pid  = (int)$pid;
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $sql = "SELECT COUNT(*) FROM comment WHERE pid='$pid';";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_array($query);
    $number_of_comments = $result["COUNT(*)"];
    return $number_of_comments;
}

function get_dead_comments() {
    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    /*get all comment IDs and their PIDs*/
    $sql = "SELECT id, pid FROM comment";
    $res = mysqli_query($db, $sql);
    $commentids = array();
    $commentpids = array();
    for ($i = 0; $comment = mysqli_fetch_assoc($res); $i++) {
        $commentids[$i] = $comment['id'];
        $commentpids[$i] = $comment['pid'];
    }
    /*get all post ids*/
    $sql = "SELECT id FROM entry";
    $res = mysqli_query($db, $sql);
    $postids = array();
    $dcc = 0;
    for ($i = 0; $post = mysqli_fetch_assoc($res); $i++) {
        $postids[$i] = $post['id'];
    }
    //COMPARE!
    $dead_comments = array();
    for ($i = 0; $i < count($commentids); $i++) {
        $compid = $commentpids[$i];
        $found = 0;
        for ($i2=0; $i2 < count($postids); $i2++) { 
            if ($compid == $postids[$i2]) {
                $found = 1;
            }
        }
        if (!$found) {
            $dead_comments[$dcc] = $commentids[$i];
            $dcc++;
        }
    }
    return $dead_comments;
}
?>