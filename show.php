<?php
session_start();
require_once "conf/main.conf.php";
require_once "inc/functions.inc.php";
require_once "inc/comments.inc.php";

//making sure title is set in every case
$title = "ERROR";
if(!empty($_GET["id"])) {
    //make sure id is an integer
    $id = (int)$_GET["id"];
    //connect Mysql
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    //get post resource
    $res = mysqli_query($db, "SELECT * FROM $db_table_entry WHERE id = $id;");
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
                    echo "name: ".$comment["name"]."<br />";
                    echo "mail: <a href=mailto:".$comment["mail"].">".$comment["mail"]."</a>"." ";
                    echo "www: <a href='".$comment["www"]."'>".$comment["www"]."</a><br />";
                    echo "<p>".$comment["content"]."</p>";
                    echo "</div>";
                }
                if (!$cc) {
                    echo "<div class=\"comment\">";
                    echo"no comments<br />";
                    echo "</div>";
                }
                echo "<br />comment to this post:";
                require "./comment.php";
                echo "<hr />";
                echo "<p style=\"text-align:center;\"><a href=\"index.php\">Go back</a></p><hr />";
            } else { 
                echo "<p>Please specify a post ID!</p>";
            }
        ?>
        <?php include "footer.php"; ?>
    </div>

</body>
</html>