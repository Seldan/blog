<?php
    if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    echo "Delete post: <form method=\"post\"><div style=\"text-align: center;\" class=\"input-append\"><input type=text name=\"id\" placeholder=\"ID\" size=20 /> <input name=\"delete\" type=\"submit\" class=\"btn btn-inverse\" /></div></form>";
    
    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    //deletion
    if (!empty($_POST["id"])) {
        $sql = "DELETE FROM entry WHERE id=".(int)$_POST["id"].";";
        $err = mysqli_query($db, $sql);
        if ($err == 0) {
            echo "An error occured deleting the specified post.";
        } else if (mysqli_affected_rows($db) == 0) {
            echo "Could not find a post with this ID.";
        } else {
            echo "Post deleted.";
        }
    }

    //list posts
    $sql = "SELECT id,title FROM entry;";
    $res = mysqli_query($db, $sql);
    while($post = mysqli_fetch_assoc($res)) {
        var_dump($post);
        echo "<br />\n";
    }
?>