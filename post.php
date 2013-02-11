<?php
/*
    Script for Posting something
*/
//exit on direct access.
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
require_once "conf/main.conf.php";
?>
    <form method="post" name="post">
        <!--<input name="datetime" type="datetime" />-->
        <input name="title" placeholder="Enter a nice title here..." size=30 type=text /><br />
        Date 'n' Time: <input name="date" type="date" size=9 value=<?php echo date('Y-m-d', time());?> />
        <input name="time" type="timde" size=4 value=<?php echo date('H:i:s', time());?> />
        <input name="user" placeholder="Wanna post under a different name?" size=30 type=text /><br />
        <textarea name="content" placeholder="Only thing left is to enter some nice text, huh? Oh, and you can use HTML!" rows=10 cols=80></textarea><br />
        <input type="hidden" name="post" value=true />
        <input type="submit" value="Post" /><br />
    </form>
<?php
    if (isset($_POST["post"])) {
        if ($_POST["post"] == TRUE) {
            $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
            $name = $_POST["user"];
            $title = $_POST["title"];
            if(empty($title)) {
                exit("Please enter a title"); //require title
            }
            $date = $_POST["date"];
            $time = $_POST["time"];
            $datetime = $date." ".$time;
            $content = nl2br($_POST["content"]);
            $done = mysqli_query($db, 
                "INSERT INTO entry (id, name, datetime, title, content)
                 VALUES ('', '$name', '$datetime', '$title', '$content');"
            );
            if ($done != FALSE) {
                echo "\nPOSTED AS $name\n<br />";
            } else {
                echo "\nERROR!\n<br />";
            }
        }
    }
?>
