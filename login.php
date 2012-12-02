<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Seldan's Blog</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="css/main.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
<?php
//start session
session_start();
require_once "inc/functions.inc.php";
if (isset($_SESSION["uid"])) {
    echo 'Uhm yes, you\'re... ALREADY LOGGED IN! <a href="admin.php">Control Panel</a>';
} else if (isset($_POST["username"]) && isset($_POST["password"])) {
    echo "<div id=\"container\">";
    if(login($_POST["username"], $_POST["password"])) {
        echo 'You logged in successfully!  <a href="admin.php">Control Panel</a>';
    } else {
        echo "something went wrong or you just forgot your password... =(";
    }
    echo "\t</body>\n</html>";
    exit();
}
?>
        <div style="position:absolute;top:50%;left:50%;margin-top:-75px;margin-left:-200px;width:400px;height:150px;text-align:center;">
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" size=20>
                <br>
                <input type="password" name="password" placeholder="Password" size=20>
                <br>
                <input name="login" type="submit" class="btn btn-inverse" value="Login">
            </form>
        </div>
    </body>
</html>