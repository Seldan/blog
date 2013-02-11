<!DOCTYPE html>
<html>
<head>
    <title>Installation</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
    <link rel="stylesheet" type="text/css" href="../css/scrollbars.css" />
</head>
<body>
    <div id="container">
        <div id="content" style="margin-top: 20px;">
        <p>Welcome to the installation, click install to install.</p>
        <form method=post>
        <input type=hidden name=INSTALL>
        <input type=submit value="Install" class="btn btn-inverse"><br />
        </form>
<?php
if(isset($_POST["INSTALL"])) {
    require_once "../conf/main.conf.php";
    //read the default database SQL
    $sqlfile = fopen("DB.SQL", "r");
    $hq = fread($sqlfile, filesize("DB.SQL"));
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $r1 = mysqli_multi_query($db, $hq);
    if ($r1 != 0) {
        echo "<p>done</p>";
    } else {
        echo "<p>error</p>";
    }
}
?>
        </div>
    </div>
</body>
</html>
