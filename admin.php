<?php
if(!empty($_GET['action'])) {
    $action = $_GET['action'];
    /*redirect to mainpage on logout*/
    if ($action == 'logout') {
        session_start();
        session_destroy();
        require 'conf/main.conf.php';
        header ('HTTP/1.1 307 Temporary Redirect');
        header ('Location: '.$site_url.'/index.php');
    }
} else {
    $action = 'stats';
}
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
        include 'header.php'; 
        echo "<div id=\"bar\"><a href='?action=post'>post</a> | <a href='?action=managecomments'>comments</a> | <a href='?action=manageposts'>posts</a> | <a href='?action=stats'>stats</a></div>";
        echo "\n<br />";
if (empty($_SESSION['admin'])){ //not authenticated, ask for password
    if(isset($_POST['password'])) { //password typed in, check it
        require 'conf/main.conf.php';
        $input_pw = $_POST['password'];
        //hash password
        for ($i = 0; $i < 65536; $i++) {
            $input_pw = hash('md5', $input_pw);
        }
        if($input_pw == $password) { //grant access
            $_SESSION['admin'] = 1;
        } else { //wrong password
            echo 'Access denied!';
        }
    } else { //show login form
        echo '<form method="post"><div style="text-align: center;" class="input-append"><input type=password name="password" placeholder="Password" size=20 /> <input name="login" value="login" type="submit" class="btn btn-inverse" /></div></form>';
    }
}
if (!empty($_SESSION['admin'])) {
    /*all actions here should be selfexplaining*/
    switch ($action) {
        case 'post':
            require 'post.php';
            break;
        case 'stats':
            require 'stats.php';
            break;
        case 'removedeadcomments':
            $kill = 'yes';
            require 'stats.php';
            break;
        case 'managecomments':
            require 'managecomments.php';
            break;
        case 'manageposts':
            require 'manageposts.php';
            break;
        case 'edit':
            require 'edit.php';
            break;
        case 'debug':
            require 'debug.php';
            break;
        default:
            echo 'Sorry, there is such action!';
            break;
    } 
    echo '<div style="float: right;"><a href="index.php">back</a> | <a href="?action=logout">logout</a></div>';
}
        ?>

    </div>
</body>
</html>
