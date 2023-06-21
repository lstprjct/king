<?php
require "../config.php";
header("content-type: application/json");
function rest_msg( $msg = "")
{
    echo json_encode(
        array(
            "message" => $msg,
        )
    );
}
$tg_user_id = "";
$tg_user_status = 'inactive';
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

if(isset($_GET['tg_user_status'])){
    $tg_user_status = $_GET['tg_user_status'];
    
}
if(isset($_GET['tg_user_id'])){
    $tg_user_id = $_GET['tg_user_id'];
    
}
if ($tg_user_id != ""){
    $sel = "SELECT * from users where user_id = '$tg_user_id'";
    $rs = mysqli_query($connect, $sel);
    if (mysqli_num_rows($rs) <= 0){
        return rest_msg("No user found with this ID");
    }else{
        while($f =  mysqli_fetch_assoc($rs)){
                $qy = "
                    UPDATE users 
                    SET status = '".$tg_user_status."' 
                    WHERE user_id = '".$tg_user_id."'
                    ";
                $connect->query($qy);
                return rest_msg("user account status has been updated!");
            
        }
    }
}else{
    return rest_msg("Missing parameter");
}
$connect->close();