<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Control Panel</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/scrollbars.css" />
</head>
<body>
    <div id="container">
        <?php
{
    echo "Welcome to the Control Panel!\n<br />";
        # Links here.
        echo "Some actions: ";
        echo "<a href=?action=post>post</a> <a href=?action=stats>stats</a> <a href=?action=debug>debug</a>";
        echo "\n<br />";
        if(!empty($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'stats';
        }
}
switch ($action) {
    case 'post':
        require "post.php";
        break;
    case 'stats':
        require "stats.php";
        break;
    case 'debug':
        echo "Work in progress!";
        require "debug.php";
        break;
    case 'removedeadcomments':
        $kill = "yes";
        require "stats.php";
        break;
    default:
        echo "Sorry, this is not a 404 but an error: No such action!";
        break;
}
        ?>
    </div>
</body>
</html>