<?php
    session_start();
    require_once "conf/main.conf.php";
    require_once "inc/functions.inc.php";
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
    while ($i < $entries) {
        $entry = mysqli_fetch_assoc($res);
                echo "<h2><a href=\"show.php?id=".$entry["id"]."\">".$entry["title"]."</a></h2>";
                echo "<p>";
                echo "From: ".$entry["name"];
                echo "<br />";
                echo "Date: ".$entry["datetime"];
                echo "<br />";
                echo $entry["content"];
                echo "</p>";
                $comments = get_comment_count($entry["id"]);
                if (!$comments) {
                    echo "no comments";
                } else if ($comments == 1) {
                    echo "<a href=\"show.php?id=".$entry["id"]."#comments\">one comment</a>";
                } else {
                    echo "<a href=\"show.php?id=".$entry["id"]."#comments\">$comments comments</a>";
                }
                echo "<hr />";
        $i++;
    }
?>
    <p style="text-align:center;">
        <a href="index.php">Go back</a>
    </p>
    <hr />
    <?php include "footer.php"; ?>
</div>
</body>
</html>