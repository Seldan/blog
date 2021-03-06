<?php
require_once "conf/main.conf.php";
require_once "inc/comments.inc.php";
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
<?php    include "header.php"; ?>
        <div id="bar"><a href="admin.php">admin</a> | <a href="archive.php">archive</a></div>
        <div id="content">
        <!-- SCRIPT GENERATRED -->
<?php
            //connect Mysql
            $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
            if (mysqli_connect_errno()) {
                echo "<p>Error connecting to database.</p>";
            }
            //number of posts
            // TODO improve mysql error handling
            $res = mysqli_query($db, "SELECT COUNT(*) FROM entry;");
            if (!($res == NULL)) {
                $entrynumber = mysqli_fetch_assoc($res);
                $entries = $entrynumber['COUNT(*)'];
            } else {
                echo "Database error, try again or contact the site admin.";
                goto end;
            }
            //get post resource
            $res = mysqli_query($db, "SELECT * FROM entry ORDER BY datetime DESC;");
            if (!$entries && !mysqli_connect_errno()) { //mysqli_connect_errno <--- only print if connected to db
                echo "<p>Sorry, no content on this blog yet. Maybe come back another time.</p>";
            }
            for ($i = 0; ($i < 10) && ($i < $entries); $i++) {
                $entry = mysqli_fetch_assoc($res);
                echo "<h2><a href=\"show.php?id=".$entry["id"]."\">".$entry["title"]."</a></h2>\n";
                echo "<p>\n";
                echo "From: ".$entry["name"];
                echo "<br />\n";
                echo "Date: ".$entry["datetime"];
                echo "<br />\n";
                echo "Views: ".$entry["views"];
                echo "<br />\n<br />\n";
                if (mb_strlen($entry["content"], 'UTF8') <= 1200) {
                    echo $entry["content"];
                } else {
                    echo mb_substr($entry["content"], 0, 1200, 'UTF8')."...<br />\n<a href=\"show.php?id=".$entry["id"]."\">Read more</a>";
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
                echo "\n<hr />\n\n\n";
            }
            if($entries > 10) {
                echo "<p style=\"text-align:center;\"><a href=\"archive.php\">For older posts click here.</a></p><hr />\n";
            }
            end:
?>
        </div>
        <?php include "footer.php"; ?>
        <!-- SCRIPT GENERATRED END -->
    </div>
</body>
</html>
