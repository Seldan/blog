<?php
session_start();
echo date('Y-m-d H:i:s', time());
echo var_dump($_SESSION);
function pw_hash($pw) {
    for ($i = 0; $i < 65536; $i++){
        $pw = hash('md5', $pw);
    }
    return $pw;
}
//EXTRA FEATURE!!!
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) {echo "<form method=post><input name=pahsword /><input type=submit></form>";if (!empty($_POST["pahsword"])) {echo pw_hash($_POST["pahsword"]);}}

$out = shell_exec("markdown/Markdown.pl <<EOF\n".$_POST['md']);
echo $out;

?>

<form method="post">
<textarea name="md">

</textarea>
<input type="submit" \>
</form>