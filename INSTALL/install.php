<form method=post>
user<input name=user><br />
pw<input type=password name=pw><br />
apikey<input name=apikey><br />
<input type=hidden name=INSTALL>
<input type=submit><br />
</form>

<?php
if(isset($_POST["INSTALL"])) {
    require_once "../conf/main.conf.php";
    require_once "../inc/functions.inc.php";
    //read the default database SQL
    $sqlfile = fopen("DB.SQL", "r");
    $sql = fread($sqlfile, filesize("DB.SQL"));
    //dump SQL to DB
    $pw = hash_password($_POST["pw"]);
    $hq = $sql."INSERT INTO user (id, name, pass, apikey, aid) VALUES ('', '".$_POST["user"]."', '$pw', '".$_POST["apikey"]."', '1');"." INSERT INTO acl (id, canpost, canedit, candelete, cancommentedit, cancommentdelete, canusercreate, canacledit) VALUES ('','1','1','1','1','1','1','1');";
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