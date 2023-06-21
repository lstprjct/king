<?php
require "../config.php";
header("content-type: application/json");
function rest($created = false, $msg = "", $data = "")
{
    echo json_encode(
        array(
            "user_created" => $created,
            "message" => $msg,
            "data" => $data
        )
    );
}
$tg_user_id = "";
$session_id = "";
$tg_user_username = $hyper->gen_tok(15);
$password = $hyper->gen_tok(32);
$key = '';

if(isset($_GET['key'])){
    $key = $_GET['key'];
    if ($key != 'KING@SLAVER486'){
        return header("location: ../V2/dashboard.php");
    }  
}
if ($key == ''){
    return header("location: ../V2/dashboard.php");
}
if (isset($_GET['tg_user_id'])) {
    $tg_user_id = $_GET['tg_user_id'];
}
if (isset($_GET['tg_user_username'])) {
    $tg_user_username = $_GET['tg_user_username'];
}

if ($tg_user_id != "") {
    $s = "SELECT * from users where user_id='$tg_user_id'";
    $rs = mysqli_query($connect, $s);
    if (mysqli_num_rows($rs) <= 0) {
        $sel = "INSERT INTO users (user_id, username, password, session_id) VALUES ('$tg_user_id','$tg_user_username',
     '$password','$session_id')";
        if (mysqli_query($connect, $sel)) {
            return rest(
                true,
                "Account created successfully!",
                array("username" => $tg_user_username, "token" => $password)
            );
        } else {
            return rest(false, "Unable to create ID!");
        }
    } else {
        return rest(false, "User already registered!");
    }
} else {
    return rest(false, "required parameters are missing!");
}
$connect->close();
