<?php
require "../config.php";
header("content-type: application/json");
function rest_json($status = "failed", $msg = "Request has been failed!", $data = [])
{
    return json_encode(
        array(
            "status" => $status,
            "message" => $msg,
            "data" => $data
        )
    );
}
$user_status = 'active';
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

if (isset($_GET['status'])) {
    $user_status = $_GET['status'];
}
$ppp = 50;
if (isset($_GET['limit'])) {
    $ppp = $_GET['limit'];
}
$pageNum = 1;
if (isset($_GET['page'])) {
    $pageNum = $_GET['page'];
}
if (!is_numeric($pageNum)) {
    exit();
}
$rows  = ($pageNum - 1) * $ppp;

$run   = mysqli_query($connect, "SELECT * FROM `users` where status ='$user_status' ORDER BY id DESC LIMIT $rows, $ppp");
$count = mysqli_num_rows($run);
if ($count <= 0) {
    echo rest_json("ok", "No records found");
} else {
    $d = array();
    while ($r = mysqli_fetch_assoc($run)) {
        $d[] = $r;
    }
    echo rest_json("ok", "succeeded", $d);
    $query   = "SELECT COUNT(id) AS numrows FROM users WHERE status='$user_status'";
    $result  = mysqli_query($connect, $query);
    $row     = mysqli_fetch_array($result);
    $numrows = $row['numrows'];
    $maxPage = ceil($numrows / $ppp);
}
mysqli_close($connect);
