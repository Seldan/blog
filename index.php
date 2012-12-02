<?php
session_start();
require_once "conf/main.conf.php";
require_once "inc/functions.inc.php";
require_once "inc/comments.inc.php";
require_once "inc/fortune.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $site_name; ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/scrollbars.css" />
</head>
<body>
    <div id="container">
        <?php if(isset($_SESSION["uid"])) { ?>
        <p style="text-align: center;"><a href="logout.php">logout</a> | <a href="post.php">post</a> | <a href="archive.php">archive</a></p>
        <?php } else { ?>
        <p style="text-align: center;"><a href="login.php">login</a> | <a href="archive.php">archive</a></p>
        <?php } ?>
        <!-- SCRIPT GENERATRED -->
        <?php
            //connect Mysql
            $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
            //number of posts
            $entrynumber = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) FROM $db_table_entry;"));
            $entries = $entrynumber['COUNT(*)'];
            //get post resource
            $res = mysqli_query($db, "SELECT * FROM $db_table_entry ORDER BY datetime DESC;");
            $i = 0;
            if (!$entries) {
                echo "NO ENTRIES YET!";
            }
            while (($i < 10) && ($i < $entries)) {
                $entry = mysqli_fetch_assoc($res);
                echo "<h2><a href=\"show.php?id=".$entry["id"]."\">".$entry["title"]."</a></h2>\n";
                echo "<p>\n";
                echo "From: ".$entry["name"];
                echo "<br />\n";
                echo "Date: ".$entry["datetime"];
                echo "<br />\n";
                if (strlen($entry["content"]) <= 1200) {
                    echo $entry["content"];
                } else {
                    echo substr($entry["content"], 0, 1200)."...<br />\n<a href=\"show.php?id=".$entry["id"]."\">Read more</a>";
                }
                echo "\n</p>\n";
                $comments = get_comment_count($entry["id"]);
                if (!$comments) {
                    echo "no comments";
                } else if ($comments == 1) {
                    echo "<a href=\"show.php?id=".$entry["id"]."#comments\">one comment</a>";
                } else {
                    echo "<a href=\"show.php?id=".$entry["id"]."#comments\">$comments comments</a>";
                }
                echo "<hr />\n\n\n\n";
                $i++;
            }
            if($entries > 10) {
                echo "<p style=\"text-align:center;\"><a href=\"http://10.0.0.2/blog/archive.php\">For older posts click here.</a></p><hr />\n";
            }
        ?>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>