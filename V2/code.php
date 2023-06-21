<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter Access Code </title>
    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/hyper.css?v=4.3" />
    <script src="../js/uikit.js"></script>
    <?php
    include "../config.php";

    session_start();
    $userLogged = false;
    if (isset($_SESSION['username'])) {
        $userLogged = true;
    }
    if ($userLogged === true) {
        return header("location: ./dashboard");
    }
    if (isset($_POST['login'])) {
        $password = mysqli_real_escape_string($connect,$_POST['access']);
        $user_id = mysqli_real_escape_string($connect, $_GET['user_id']);
        $sel = "SELECT * from users where password = '$password' and user_id = '$user_id'";
        $res = mysqli_query($connect, $sel);
        if (mysqli_num_rows($res) <= 0) {
            return header("location: ./code?message=invalid_code&retry=true");
        }
        while ($user = mysqli_fetch_assoc($res)) {
            if ($user['status'] === "banned") {
               return header("location: ./code?message=banned_account");
            } else {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['session_id'] = $user['session_id'];;
                $_SESSION['username'] = $user['username'];
                $_SESSION['status'] = $user['status'];
                $_SESSION['access'] = $user['password'];
                $_SESSION['roles'] = $user['roles'];
                $connect->close();
                header("location: ./dashboard?success=user_logged&auth_token=tok_" . $hyper->toLowercase($hyper->gen_tok(30)) . "");
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
                         <div style='filter: invert(1); height: 45px; width: 45px; margin-top: -4px;margin-bottom: 40px;'><img src="../anonymousheader.svg"></div>
                        </center>
                        <div class="uk-article-content">
                            <?php

                            if ($hyper->get_parameter("code_sent", "true")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Code has been sent.",
                                        "css" => "text-success",
                                        "ele" => "p"
                                    )
                                );
                            } else if ($hyper->get_parameter("message", "invalid_code")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Incorrect Code.",
                                        "css" => "text-warn",
                                        "ele" => "p"
                                    )
                                );
                            } else if ($hyper->get_parameter("message", "banned_account")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Your account has been banned",
                                        "css" => "text-danger",
                                        "ele" => "p"
                                    )
                                );
                            } else if ($hyper->get_parameter("message", "unkown_ip")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Unauthorized ip address (" . $hyper->get_user_ip() . ")",
                                        "css" => "text-danger",
                                        "ele" => "p"
                                    )
                                );
                            } else if ($hyper->get_parameter("new_user_logged", "true")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Another user logged in!",
                                        "css" => "text-danger",
                                        "ele" => "p"
                                    )
                                );
                            }

                            ?>
                            <form class="uk-form-stacked uk-margin-medium-top" method="POST" action="">
                                <div class="uk-margin-bottom">
                                    <!-- <label class="uk-form-label" for="name">Secret Code</label> -->
                                    <div class=" hyper_login uk-form-controls">
                                        <!-- <input id="name" class="hyper_input uk-input uk-border-rounded" name="access" type="text" placeholder="Enter Username Here" required> -->
                                        <input id="name" class="hyper_input uk-input uk-border-rounded" name="access" type="text" placeholder="Enter Access Token" required>
                                    </div>
                                </div>

                                <div class="uk-text-center">
                                    <input class="uk-button uk-button-primary uk-border-rounded" name="login" type="submit" value="Get Access">
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