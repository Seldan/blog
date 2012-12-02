<!-- gay stuff! REMOVE FOR RELEASE! -->
<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) { ?>
<form method=post>
    <textarea name="JSON" placeholder="paste valid json here"></textarea><br />
    <button type=submit>Click me to submit and test api... I will not exist in the final release!</button>
</form>
WORKING TEST JSON: { "API_KEY" : "qwerty", "action" : "post", "param" : {"user" : "Seldan", "uid" : 1, "title" : "api test", "date" : "2012-09-30", "time" : "22:11:11", "content" : "test"}}
<?php
}
/*api.php
this is the api of my blog, at the end i want it to require all the features
and the frontend will use it some time in the future as just another client,
that way cool things like dynamic pages etc are available.
*/
function api_authenticate($submitted_key) {
    require "conf/main.conf.php";
    /*TÒDO Implement user APIKEYs!*/
    if ($submitted_key == $API_KEY) {
        return 1;
    } else {
        return 0;
    }
}
function api_authenticate_user($name, $pass) {
    require "conf/main.conf.php";
    //check if Username Typed in
    if(!empty($name)) {
        $name = htmlspecialchars($name);
        $pass = hash_password($pass);
        require "conf/main.conf.php";
        $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
        $sql = "SELECT * FROM user WHERE name='$name'";
        $query = mysqli_query($db, $sql);
        $result = mysqli_fetch_assoc($query);
        if($pass == $result["pass"]) {
            return 1;
        } else {
            return 0;
        }
    }
}

function api_backend_delete_post($param) {
    //delete post
    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $sql = "DELETE * FROM entry WHERE id=".(int)$param['id'].";";
    $err = mysqli_query($db, $sql);
    if ($err == 0) {
        return "Error deleting post";
    } else {
        return 1;
    }
}

function api_backend_delete_comment($param) {
    //delete comment
    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $sql = "DELETE * FROM comment WHERE id=".(int)$param['id'].";";
    $err = mysqli_query($db, $sql);
    if ($err == 0) {
        return "Error deleting comment";
    } else {
        return 1;
    }
}

function api_backend_find_comment_id($param) {
    //find comment
    require "conf/main.conf.php";
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $sql = "";

    /*Insert code here*/

    if ($err) {
        return "Error finding comment";
    } else {
        return 1;
    }
}

function api_backend_comment($param) {
    //comment creation function
    /*Validate comment*/
    $pid = (int)$param["pid"];
    /*connect to DB*/
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    /*VALIDATE IF THERE IS A POST WITH THIS ID*/
    $res = mysqli_query($db, "SELECT * FROM entry WHERE id=$pid");
    if(mysqli_num_rows($res) != 1) {
        return "You cant comment something not even existing... lol";
    }
    $datetime = date('Y-m-d H:i:s', time());
    $name = htmlentities($param["name"], ENT_HTML5);
    if (empty($name)) {
        $name = "Anonymous";
    }
    $www = htmlentities($param["www"], ENT_HTML5);
    $mail = htmlentities($param["mail"], ENT_HTML5);
    $content = nl2br(htmlentities($param["content"], ENT_HTML5));
    /*post comment to DB*/
    $res = mysqli_query($db, "INSERT INTO comment (id,pid,datetime,name,www,mail,content) VALUES ('','$pid','$datetime','$name','$www','$mail','$content');");
    if ($res == 0) {
        return "Fatality! Comment got killed by an Error!".mysqli_error($db);
    } else {
        return 1;
    }
}

function api_backend_post($post = array("suicide" => true)) {
    require "conf/main.conf.php";
    if (isset($post['suicide'])) {
        return "No arguments provided!";
    }
    $db = mysqli_connect($db_host, $db_user, $db_pw, $db_db);
    $name = $post["user"];
    $uid = $post["uid"];
    $title = $post["title"];
    if(empty($title)) {
        return "Can't post without title"; //require title
    }
    $date = $post["date"];
    $time = $post["time"];
    $datetime = $date." ".$time;
    $content = nl2br($post["content"]);
    //finally post everything
    $done = mysqli_query($db,
    	"INSERT INTO $db_table_entry (id, uid, name, datetime, title, content)
	     VALUES ('', '$uid', '$name', '$datetime', '$title', '$content');"
    );
    if ($done != FALSE) {
        return 1;
    } else {
        return "Error querying database";
    }
    return "Error, should never reach this code.";
}

function api_frontend_parse($json) {
    /*Parses Json and selects apropriate action*/
    if (!array_key_exists('action', $json)) {
        return "Fatal error: What the fuck do you want me to do?";
    }
    switch ($json['action']) {
        case "post":
            $status = api_backend_post($json['param']);
            if ($status != 1) {
                return "api_backend_post(): ".$status;
            } else {
                return 1;
            }
            break;
        case "delete_post":
            //code to delete a post
            $status = api_backend_delete_post($json['param']);
            if ($status != 1) {
                return "api_backend_delete_post(): ".$status;
            } else {
                return 1;
            }
            break;
        case "delete_comment":
            //code to delete a post
            $status = api_backend_delete_comment($json['param']);
            if ($status != 1) {
                return "api_backend_delete_comment(): ".$status;
            } else {
                return 1;
            }
            break;
        case 'comment':
            $status = api_backend_comment($json['param']);
            if ($status != 1) {
                return "api_backend_comment(): ".$status;
            } else {
                return 1;
            }
            break;
        break;
        default:
            return "Error processing your request: Your request is invalid.";
            break;
        }
}

if(isset($_POST['JSON'])) {
    $json = json_decode($_POST['JSON'], true);
    if (!$json) {
        exit("Error processing your request: Malformed or damaged request");
    }
    switch ($json['auth_method']) {
        case 'api_key':
            api_authenticate($json['API_KEY']);
            break;
        case '':
            //api_authenticate_user($json['LOGIN']); //dismember login and pass the true variables
            echo "not yet supported";
            break;
        default:
            exit("Please provide a authentication method!");
            break;
    }
    if(api_authenticate($json['API_KEY'])) {
        $status = api_frontend_parse($json);
        if ($status != 1) {
            exit('api_frontend_parse(): '.$status);
        } else {
            exit('Looks like success!');
        }
    } else {
        exit('Access denied! Please provide an valid API_KEY!');
    }
} else {
    exit('Error processing your request: No request sent.');
}
?>
