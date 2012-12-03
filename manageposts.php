<?php
    if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    echo "Delete post: <form method=\"post\"><div style=\"text-align: center;\" class=\"input-append\"><input type=text name=\"id\" placeholder=\"ID\" size=20 /> <input name=\"delete\" type=\"submit\" class=\"btn btn-inverse\" /></div></form>";
    if (!empty($_POST["id"])) {
        require "conf/main.conf.php";
        $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
        $sql = "DELETE FROM entry WHERE id=".(int)$_POST["id"].";";
        $err = mysqli_query($db, $sql);
        if ($err == 0) {
            echo "Error deleting post";
        } else {
            echo "post deleted";
        }
    }   
?>