<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
if (!$_SESSION["acl"]["canacledit"]) { echo("Access denied!"); exit();}
echo "welcome to the ACL control panel, here you can edit... uhm... see all the permissions. Yay!<br />";

//connect to mysql
require "conf/main.conf.php";
$db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
$sql = "SELECT * FROM acl";
$raw = mysqli_query($db, $sql);
echo "<table border=\"1\">";
echo "<tr>";
echo "<td>uid</td><td>post</td><td>edit</td><td>delete</td><td>comment_edit</td><td>comment_delete</td><td>create user</td><td>edit acl</td></tr>";
for ($i = 0; $i < mysqli_num_rows($raw); $i++) {
    $acl = mysqli_fetch_assoc($raw);
    
    //html table new row
    echo "<tr>";
    echo "<td>".$acl["id"]."</td>";
    echo "<td>".$acl["canpost"]."</td>";
    echo "<td>".$acl["canedit"]."</td>";
    echo "<td>".$acl["candelete"]."</td>";
    echo "<td>".$acl["cancommentedit"]."</td>";
    echo "<td>".$acl["cancommentdelete"]."</td>";
    echo "<td>".$acl["canusercreate"]."</td>";
    echo "<td>".$acl["canacledit"]."</td>";
    //end row
    echo "<tr>";
}

?>