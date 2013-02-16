<?php
require_once "conf/main.conf.php";
require_once "inc/comments.inc.php";

$p = explode("/", $_SERVER['SCRIPT_FILENAME']);
if(array_pop($p) == 'comment.php') {
    /*Validate comment*/
    $pid = (int)$_POST["pid"];
    /*connect to DB*/
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    /*VALIDATE IF THERE IS A POST WITH THIS ID*/
    $res = mysqli_query($db, "SELECT * FROM entry WHERE id=$pid");
    if(mysqli_num_rows($res) != 1) {
        exit("Sorry, you cannot comment on something not even existing.");
    }
    $datetime = date('Y-m-d H:i:s', time());
    $name = htmlentities($_POST["name"], ENT_HTML5);
    if (empty($name)) {
        $name = "Anonymous";
    }
    $www = strip_tags($_POST["www"]);
    $mail = strip_tags($_POST["mail"]);
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
    $res = mysqli_query($db, "INSERT INTO comment (id,pid,datetime,name,www,mail,content) 
        VALUES ('','$pid','$datetime','$name','$www','$mail','$content');");
    if ($res == 0) {
        echo "Sorry, an error occured while posting your comment.";
    } else {
        /* //unkomment for old redirection style
        if (empty($_SERVER['HTTP_REFERER'])) {
            echo "You did not transfer a referer, please go back manually.";
            exit();
        }
        header ('HTTP/1.1 307 Temporary Redirect');
        header ('Location: '.$_SERVER['HTTP_REFERER']);
        */
        header ('HTTP/1.1 307 Temporary Redirect');
        header ('Location: '.$site_url.'/show.php?id='.$_POST["pid"]);
    }
}

if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
echo "<form method='POST' action='comment.php'><input name='pid' value='$id' type='hidden' /><br />\n";
echo "<div class='form-inline' style='margin-bottom: 6px;'><input type=text name='name' placeholder='name' /> ";
echo "<input type=email name='mail' placeholder='mail' /> ";
echo "<input type=url name='www' placeholder='www' /> <input name='post' type='submit' class=\"btn btn-inverse\" value=\"Post\"></div>";
echo "<textarea name='content' placeholder='comment here!' style='width:99%; max-width:99%;'></textarea></form><br />";
?>
