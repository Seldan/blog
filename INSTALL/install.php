<form method=post>
user<input name=user><br />
pw<input type=password name=pw><br />
<input type=hidden name=INSTALL>
<input type=submit><br />
</form>

<?php
if(isset($_POST["INSTALL"])) {
    require_once "../conf/main.conf.php";
    require_once "../inc/functions.inc.php";
    //read the default database SQL
    $sqlfile = fopen("DB.SQL", "r");
    $hq = fread($sqlfile, filesize("DB.SQL"));
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $r1 = mysqli_multi_query($db, $hq);
    echo $hq;
    if ($r1 != 0) {
        echo "done";
    } else {
        echo "error";
    }
}
?>