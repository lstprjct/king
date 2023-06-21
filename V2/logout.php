<?php
session_id($_SESSION['session_id']);
session_start();
session_destroy();
if (isset($_GET['new_user_logged'])) {
    $n = $_GET['new_user_logged'];
    header('location: ./?session_destroyed=true&__user_loggedOut=true&new_user_logged=' . $n . '');
} else {
    header('location: ./?session_destroyed=true&__user_loggedOut=true');
}
