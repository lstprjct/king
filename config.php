<?php

use Hyper\Hyper;

$host = "localhost";
$username = "u804180676_su";
$password = "Piash@01761$";
$database = "u804180676_checker";
$is_connected = false;

$connect = new mysqli($host, $username, $password, $database);
// Checking Connection
if (mysqli_connect_errno()) {
    printf("Database connection failed: %s\n", mysqli_connect_error());
    exit();
} else {
    $is_connected = true;
}

require "../V2/hyper.php";

// enter a channel id or group id or ur tg id 
// this is for bot logs not stealer

$bot_logs_channel_id = "1972095603";


$hyper = new Hyper($connect, "SQL");
$appconfig = array(
    "site_title" => "King",
    "app_version" => "1.0.1",
    "author" => "KING",
    "bot_link" => "tg://resolve?domain=CHKerCCBot",
    "site_auth" => "King"
);

$hyper_config =  array(
    "bot_token" => "5929089968:AAFVBq4UvQfYTKyvpfTWSByIVG_P92Ahd8s",
    "creator" => "KING"
);
$bot_token = $hyper_config['bot_token'];

function hyper_chk_bot($chatId, $message, $mode = "HTML")
{
    $website = "https://api.telegram.org/bot" . $GLOBALS['bot_token'];
    $url = $website . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=$mode";
    url_get_contents($url);
}

function url_get_contents($Url)
{
    if (!function_exists('curl_init')) {
        die('CURL not found');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function set_social_menu($menus, $loop = "")
{
    if (count($menus) !== 0) {

        foreach ($menus as $menu) {
            echo '<div class="' . $menu['col'] . '" >
					<a href="' . $menu['link'] . '" data-uk-icon="icon: ' . $menu['icon'] . '" class="uk-icon-link uk-icon" target="_blank"></a>
				</div>';
        }
    }
}
