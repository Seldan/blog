<?php
require_once "conf/main.conf.php";
require_once "inc/comments.inc.php";

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You need to enable the transfer of a referer for the comment funcion to work, sorry.";
    exit();
}

$p = explode("/", $_SERVER['SCRIPT_FILENAME']);
if(array_pop($p) == 'comment.php') {
    /*Validate comment*/
    $pid = (int)$_POST["pid"];
    /*connect to DB*/
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    /*VALIDATE IF THERE IS A POST WITH THIS ID*/
    $res = mysqli_query($db, "SELECT * FROM entry WHERE id=$pid");
    if(mysqli_num_rows($res) != 1) {
        exit("You cant comment something not even existing... lol");
    }
    $datetime = date('Y-m-d H:i:s', time());
    $name = htmlentities($_POST["name"], ENT_HTML5);
    if (empty($name)) {
        $name = "Anonymous";
    }
    $www = htmlentities($_POST["www"], ENT_HTML5);
    $mail = htmlentities($_POST["mail"], ENT_HTML5);
    if (empty($_POST["content"])) {
        echo "please enter a comment.";
        exit();
    }
    $content = nl2br(htmlentities($_POST["content"], ENT_HTML5));
    if (mb_strlen($content, 'UTF8') > 3500) {
        echo "It said: \"comment this post:\" not \"Write a book about it.\"\n<br />Anyways, maximum comment length exceeded.";
        exit();
    }
    /*post comment to DB*/
    $res = mysqli_query($db, "INSERT INTO comment (id,pid,datetime,name,www,mail,content) VALUES ('','$pid','$datetime','$name','$www','$mail','$content');");
    if ($res == 0) {
        echo "Fatality! Comment got killed by an Error!".mysqli_error($db);
    } else {
        header ('HTTP/1.1 307 Temporary Redirect');
        header ('Location: '.$_SERVER['HTTP_REFERER']);
        /*echo "posted comment";*/
    }
}

if (empty($id)) {
    exit();
}
echo "<form method='POST' action='comment.php'><input name='pid' value='$id' type='hidden' /><br />\n";
echo "<input type=text name='name' placeholder='name' /> ";
echo "<input type=email name='mail' placeholder='mail' /> ";
echo "<input type=url name='www' placeholder='www' /> <input name=login type=submit class=\"btn btn-inverse\" value=\"Post\"<br />";
echo "<textarea name='content' placeholder='comment here!' style='width:99%; max-width:99%;'></textarea><br />";

?>