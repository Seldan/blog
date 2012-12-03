<?php
    require_once "conf/main.conf.php";
    require_once "inc/comments.inc.php";
    $title = "$site_name: Archive";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/scrollbars.css" />
</head>
<body>
    <div id="container">
        <?php include "header.php"; ?>
        <div id="bar"><a href="admin.php">admin</a> | <a href="index.php">index</a></div>
        <div id="content">
<?php
    //connect Mysql
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    //number of posts
    $entrynumber = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) FROM entry;"));
    $entries = $entrynumber['COUNT(*)'];
    //get post resource
    $res = mysqli_query($db, "SELECT * FROM entry ORDER BY datetime DESC;");
    $i = 0;
    if (!$entries) {
        echo "<p>Sorry, no content on this blog yet. Maybe come back another time.</p><hr />";
    }
    while ($i < $entries) {
        $entry = mysqli_fetch_assoc($res);
            echo "<h2><a href=\"show.php?id=".$entry["id"]."\">".$entry["title"]."</a></h2>\n";
            echo "<p>\n";
            echo "From: ".$entry["name"];
            echo "<br />\n";
            echo "Date: ".$entry["datetime"];
            echo "<br />\n";
            echo $entry["content"];
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
        $i++;
    }
?>
    <p style="text-align:center;">
        <a href="index.php">Go back</a>
    </p>
    <hr />
    </div>
    <?php include "footer.php"; ?>
</div>
</body>
</html>