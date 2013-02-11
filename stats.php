<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    require "conf/main.conf.php";
    require "inc/comments.inc.php";
    /*Stats*/
    $posts = 0;
    $comments = 0;
    //get number of posts
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $sql = "SELECT * FROM entry";
    $posts = mysqli_num_rows(mysqli_query($db, $sql));
    echo "Posts: ".$posts."<br />\n";
    //get views
    $sql = "SELECT SUM(views) FROM entry";
    $views = mysqli_fetch_assoc(mysqli_query($db, $sql));
    echo "Views: ".$views['SUM(views)']."<br />\n";
    //get number of comments
    $sql = "SELECT * FROM comment";
    $comments = mysqli_num_rows(mysqli_query($db, $sql));
    echo "Comments: ".$comments."<br />\n";
    //get dead comments
    $dead_comments = get_dead_comments();
    echo "Orphaned comments: ".count($dead_comments)." <a href=\"?action=removedeadcomments\">remove dead comments</a>"."<br />\n"; 
    if (isset($kill)) {
        foreach ($dead_comments as $id) {
            $sql = "DELETE FROM comment WHERE id = $id";
            mysqli_query($db, $sql);
        }
        echo "orphaned comments removed";
    }
?>
