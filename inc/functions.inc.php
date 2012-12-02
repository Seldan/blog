<?php
/*login functions */
function hash_password($pass) {
    for ($i = 0; $i < 65536; $i++) {
        $pass = hash('md5', $pass);
    }
    return $pass;
}

function login($name, $pass) {
    //check if Username Typed in
    if(!empty($name)) {
        $name = htmlspecialchars($name); //check if this allows japanes chares to get through...
    } else {
        return 0;
    }
    //check if PW typed in and hash
    if(!empty($pass)) {
        //hash password
        $pass = hash_password($pass);
    } else {
        return 0;
    }
    //check if login valid and set login cookie
    if(isset($pass, $name)) {
        // pw und usernam abfrage...
        require "conf/main.conf.php";
        $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
        $sql = "SELECT * FROM user WHERE name='$name'";
        $query = mysqli_query($db, $sql);
        $result = mysqli_fetch_assoc($query);
        if($pass == $result["pass"]) {
            $_SESSION["uid"] = $result["id"];
            $_SESSION["acl"] = load_user_acl($result["id"]);
            unset($pw);
            unset($result);
            return 1;
        } else {
            return 0;
        }
    }
    unset($pass);
}

function load_user_acl($uid) {
    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $sql = "SELECT aid FROM user WHERE id='".$_SESSION["uid"]."'";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);
    $sql = "SELECT * FROM acl WHERE id='".$result["aid"]."'";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result;
}

function logout() {
    session_destroy();
}
/*general functions*/

function isurl($url) {
    /*
        Checks if the passed url is valid and prepends missing http:// if not set.
        NOT WRITTEN YET AND RETURNS PASSED URL!
    */
    return $url;
}

function ismail($mail) {
    /*
        Checks if the passed email adress is valid.
        NOT WRITTEN YET AND RETURNS PASSED EMAIL ADDRESS!
    */
    return $mail;
}