<?php
/*login functions */
function hash_password($pass) {
    for ($i = 0; $i < 65536; $i++) {
        $pass = hash('md5', $pass);
    }
    return $pass;
}
