<?php
require_once "conf/main.conf.php";
require_once "inc/comments.inc.php";

//making sure title is set in every case
$title = "Error";
if(!empty($_GET["id"])) {
    //make sure id is an integer
    $id = (int)$_GET["id"];
    //connect Mysql
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $entrynumber = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) FROM entry WHERE id = $id;"));
    $entries = $entrynumber['COUNT(*)'];
    if ($entries == 0) {
        goto notexisting;
    }
    //get post resource
    $res = mysqli_query($db, "SELECT * FROM entry WHERE id = $id;");
    $entry = mysqli_fetch_assoc($res);
    //set title
    $title = $entry["title"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo "$site_name: $title"; ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/scrollbars.css" />
</head>
<body>
    <div id="container">
        <?php include "header.php"; ?>
        <div id="bar"><a href="admin.php">admin</a> | <a href="archive.php">archive</a></div>
        <div id="content">
        <?php
            if(isset($id)) {
                //print post
                echo "<h2><a href=\"show.php?id=".$entry["id"]."\">".$entry["title"]."</a></h2>";
                echo "<p>\n";
                echo "From: ".$entry["name"];
                echo "<br />\n";
                echo "Date: ".$entry["datetime"];
                echo "<br />\n<br />\n";
                echo $entry["content"];
                echo "</p>\n";
                echo "<h3><a name=comments href=\"show.php?id=".$entry["id"]."#comments\">comments</a></h3>\n<br />";
                //load and show comments | cc = commentcounter
                $cc = get_comment_count($id);
                $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
                //get post resource
                $res = mysqli_query($db, "SELECT * FROM comment WHERE pid = $id ORDER BY datetime ASC;");
                for ($i=0; $i < $cc; $i++) {
                    $comment = mysqli_fetch_assoc($res);
                    echo "<div class=\"comment\">";
                    echo "name: ".$comment["name"]."<div style=\"float:right;\">id:".$comment["id"]."</div>"."<br />";
                    if (!empty($comment["mail"])) {
                        echo "mail: <a href=mailto:".$comment["mail"].">".$comment["mail"]."</a>"." ";
                    }
                    if (!empty($comment["www"])) {
                        echo "www: <a href='".$comment["www"]."'>".$comment["www"]."</a><br />";
                    }
                    echo "<p>".$comment["content"]."</p>";
                    echo "</div>";
                }
                if (!$cc) {
                    echo "<div class=\"comment\">";
                    echo "no comments<br />";
                    echo "</div>";
                }
                echo "<br />comment to this post:";
                require "./comment.php";
                echo "<hr />";
                echo "<p style=\"text-align:center;\"><a href=\"index.php\">Go back</a></p><hr />";
            } else { 
                echo "<p>Please specify a post ID!</p>";
            }
            if (0) {
                notexisting:
                    echo "<p>Post not existing!</p>";
            }
        ?>
        </div>
        <?php include "footer.php"; ?>
    </div>

</body>
</html>
