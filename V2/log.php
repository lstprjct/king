<?php 


include '../config.php';
header("content-type:application/json");
session_start();

$query = "
	SELECT session_id FROM users 
	WHERE user_id = '".$_SESSION['user_id']."'
";

$r = $connect->query($query);
$user_state['new_user_logged'] = false;

foreach($r as $row)
{
	if($_SESSION['session_id'] != $row['session_id'])
	{
		$user_state['new_user_logged'] = true;
	}
	
}

echo json_encode($user_state);