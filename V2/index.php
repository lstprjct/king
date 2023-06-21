<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login </title>
    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/hyper.css?v=2.6" />
    <script src="../js/uikit.js"></script>
    <?php
    include "../config.php";
    session_start();
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    $userLogged = false;
    if (isset($_SESSION['username'])) {
        $userLogged = true;
    }
    if ($userLogged === true) {
        return header("location: ./dashboard");
    }
    $pass = generateRandomString(15);
    $pass2 = generateRandomString(10);
    if (isset($_POST['login'])) {
        $userid = mysqli_real_escape_string($connect,$_POST['access']);
        $sel = "SELECT * from users where user_id = '$userid'";
        $res = mysqli_query($connect, $sel);
        if (mysqli_num_rows($res) <= 0) {
            return header("location: ./?message=no_account&retry=true");
        }
        while ($user = mysqli_fetch_assoc($res)) {
            if ($user['status'] === "banned") {
                
                return header("location: ./?message=banned_account");
            } else {
                session_regenerate_id();
                
                $session_id = session_id();
                $qy = "UPDATE users SET session_id = '$session_id' WHERE user_id = '$userid'";
                $qy2 = "UPDATE users SET password = 'ASURxKING-$pass-$pass2' WHERE user_id = '$userid'";
                $connect->query($qy);
                $connect->query($qy2);
                hyper_chk_bot($userid, "<b>𝙉𝙚𝙬 𝙇𝙤𝙜𝙞𝙣 𝘼𝙩𝙩𝙚𝙢𝙥𝙩</b>\n𝙔𝙤𝙪𝙧 𝙖𝙘𝙘𝙚𝙨𝙨 𝙘𝙤𝙙𝙚 𝙞𝙨 <code>ASURxKING-$pass-$pass2</code>");
                $connect->close();
                header("location: ./code?code_sent=true&client=telegram&user_id=$userid");
            }
        }
    }





    ?>
</head>

<body>

    <?php include "./include/header.php"; ?>

    <div class="uk-section uk-section-muted">
        <div class="uk-container">
            <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
                <div class="uk-container uk-container-xsmall uk-padding-large">
                  <div style="margin-top:50px;"></div>
                    <article class="uk-article">
                        <center>
                            <div style='filter: invert(1); height: 90px; width: 90px; '><img src="../anonymousheader.svg"></div>
                        </center>
                        <div class="uk-article-content">
                            <?php
                             if ($hyper->get_parameter("message", "no_account")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "No account found.",
                                        "css" => "text-warn",
                                        "ele"=>"p"
                                    )
                                );
                            } else if ($hyper->get_parameter("message", "banned_account")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Your account has been banned",
                                        "css" => "text-danger",
                                        "ele"=>"p"
                                    )
                                );
                            } else if ($hyper->get_parameter("message", "unkown_ip")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Unauthorized ip address (".$hyper->get_user_ip().")",
                                        "css" => "text-danger",
                                        "ele"=>"p"
                                    )
                                );
                            }else if ($hyper->get_parameter("new_user_logged", "true")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Another user logged in!",
                                        "css" => "text-danger",
                                        "ele"=>"p"
                                    )
                                );
                            }

                            ?>
                            <form class="uk-form-stacked uk-margin-medium-top" method="POST" action="">
                                <div class="uk-margin-bottom">
                                    <!-- <label class="uk-form-label" for="name">Secret Code</label> -->
                                    <div class=" hyper_login uk-form-controls">
                                        <!-- <input id="name" class="hyper_input uk-input uk-border-rounded" name="access" type="text" placeholder="Enter Username Here" required> -->
                                        <input id="name" class="hyper_input uk-input uk-border-rounded" name="access" type="number" placeholder="Enter Telegram ID" required>
                                    </div>
                                </div>

                                <div class="uk-text-center">
                                    <input class="uk-button uk-button-primary uk-border-rounded" name="login" type="submit" value="Login With Bot">
                                </div>
                            </form>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>

    <?php include './include/non_footer.php'; ?>

    <script src="../js/awesomplete.js"></script>
    <script src="../js/custom.js"></script>


</body>

</html>