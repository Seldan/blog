<?php
/*
    Script for Posting something
*/
//exit on direct access.

//TODO CRITICAL! EVERYTHING IS FUCKING SQLINJECTABLE AND WORST THING IS I CAN'T USE ''''''''''''''''!!!!!

if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
require_once "conf/main.conf.php";
?>
    <form method="post" name="post">
        <input name="title" placeholder="Title" style="width:99%; max-width:99%;" type="text" /><br />
        Date and time: <input name="date" type="date" size=9 value=<?php echo date('Y-m-d', time());?> />
        <input name="time" type="text" size=4 value=<?php echo date('H:i:s', time());?> />
        <input name="user" placeholder="Name" size=30 type=text /><br />
        <textarea name="content" placeholder="Content. Use of HTML is possible." style="width:99%; max-width:99%;" rows="10" ></textarea><br />
        <input type="hidden" name="post" value="true" />
        <input type="submit" value="post" class="btn btn-inverse" /><br />
    </form>
<?php
    if (isset($_POST["post"])) {
        if ($_POST["post"] == TRUE) {
            $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
            $name = mysqli_real_escape_string($db, $_POST["user"]);
            if(empty($name)) {
                $name = "Anonymous";
            }
            $title = mysqli_real_escape_string($db, $_POST["title"]);
            if(empty($title)) {
                exit("Please enter a title");
            }
            $date = $_POST["date"];
            $time = $_POST["time"];
            $datetime = mysqli_real_escape_string($db, $date." ".$time);
            $content = mysqli_real_escape_string($db, nl2br($_POST["content"]));
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
