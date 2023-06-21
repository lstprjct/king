<?php
require "../config.php";
header("content-type: application/json");
function rest( $msg = "")
{
    echo json_encode(
        array(
            "message" => $msg,
        )
    );
}
$sk_key = "";
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

if(isset($_GET['sk_key'])){
    $sk_key = $_GET['sk_key'];
    
}
if ($sk_key != ""){
    $sk = $hyper->encode($sk_key);
    file_put_contents('../api/skencrypted.txt', $sk . PHP_EOL, FILE_APPEND | LOCK_EX);
    return rest("sk key has been added!");
}else{
    return rest("Missing parameter");
}
