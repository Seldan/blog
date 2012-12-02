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
        <?php include "header.php"; ?>
        <?php
if (!empty($_SESSION["admin"])){
        echo "<a href=?action=post>post</a> <a href=?action=stats>stats</a> <a href=?action=debug>debug</a>";
        echo "\n<br />";
        if(!empty($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'stats';
        }
    /*all actions here should be selfexplaining*/
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
        case 'logout':
            session_destroy();
            break;
        default:
            echo "Sorry, there is such action!";
            break;
    } 
} else { //not authenticated, ask for password
    if(isset($_POST["password"])) { //password typed in, check it
        require "conf/main.conf.php";
        $input_pw = $_POST["password"];
        //hash password
        for ($i = 0; $i < 65536; $i++) {
            $input_pw = hash('md5', $input_pw);
        }
        if($input_pw == $password) { //grant access
            $_SESSION["admin"] = 1;
        } else { //wrong password
            echo "access denied!";
        }
    } else { //show login form
        echo "no login form yet, just post you password";
    }
}
        ?>
    </div>
</body>
</html>