<?php
    if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { exit(); }
    echo "Delete comment: <form method=\"post\"><div style=\"text-align: center;\" class=\"input-append\"><input type=text name=\"id\" placeholder=\"ID\" size=20 /> <input name=\"delete\" value=\"delete\" type=\"submit\" class=\"btn btn-inverse\" /></div></form>";

    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    //deletion
    if (!empty($_POST["id"])) {
        $sql = "DELETE FROM comment WHERE id=".(int)$_POST["id"].";";
        $err = mysqli_query($db, $sql);
        if ($err == 0) {
            echo "An error occured deleting the specified comment.";
        } else if (mysqli_affected_rows($db) == 0) {
            echo "Could not find a comment with this ID.";
        } else {
            echo "Comment deleted.";
        }
    }

    //list comments
    echo "<table border=\"1\">";
    echo <<<EOF
            <tr>
                <th>id</th>
                <th>datetime</th>
                <th>content</th>
            </tr>
EOF;
    $sql = "SELECT id,datetime,content FROM comment;";
    $res = mysqli_query($db, $sql);
    while($post = mysqli_fetch_assoc($res)) {
        echo <<<EOF
            <tr>
                <td>$post[id]</td>
                <td>$post[datetime]</td>
                <td>$post[content]</td>
            </tr>
EOF;
    }

    echo "</table>";
?>
