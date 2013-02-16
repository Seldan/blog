<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
echo "Datetime is: ".date('Y-m-d H:i:s', time())."<br/>\n";
echo "Session: ";
var_dump($_SESSION);
echo "<br/>\n";
function pw_hash($pw) {
    for ($i = 0; $i < 65536; $i++){
        $pw = hash('md5', $pw);
    }
    return $pw;
}
echo "<form method='post' ><input name='password' /><input type='submit' /></form>";
if (!empty($_POST["password"])) {echo pw_hash($_POST["password"]);}
?>
