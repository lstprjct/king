<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/hyper.css?v=5.2" />
    <script src="../js/uikit.js"></script>
    <?php
    require "../config.php";
    session_start();
    $userLogged = false;
    $isAdmin = false;
    $is_active = false;
    $access_tok = 'null';
    if (isset($_SESSION['username'])) {
        $userLogged = true;
        if ($_SESSION['roles'] === "slaver") {
            $isAdmin = true;
        }
        if ($_SESSION['status'] === 'active') {
            $is_active = true;
        }
        if ($_SESSION['access'] !== null) {
            $access_tok = $_SESSION['access'];
        }
    }
    if ($userLogged !== true) {
        return header("location: ./?message=user_not_logged");
    }


    ?>
</head>

<body>

    <?php include "./include/header.php"; ?>

    <div class="uk-section uk-section-muted">
        <div class="uk-container">
            <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
                <div class="uk-container uk-container-xsmall uk-padding-large">
                    <article class="uk-article">
                        <center>
                        <div style='filter: invert(1); height: 70px; width: 70px; margin-top: -4px;margin-bottom: 40px;'><img src="../anonymousheader.svg"></div>
                        </center>
                        <div class="uk-article-content">
                            <?php if ($_SESSION['roles'] === 'slaver') { ?>
                                <p class="uk-text-lead uk-text-muted">Manage your gates & settings <a href="./gates?utm_source=dashboard" class="access_link">here</a></p>

                                <div class="uk-card uk-card-category hyper_mt uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded uk-width-1-1">
                                    <a class="uk-position-cover" href="./addsk?add_new=true"></a>

                                    <div class="uk-article-meta uk-flex uk-flex-middle">

                                        <div class="uk-border-circle uk-avatar-small s_logo"></div>
                                        <div>
                                            <h3><a href=""> Manage API</a> </h3>
                                            <span class="tag_required">Add New Sk</span>

                                        </div>
                                    </div>
                                </div>

                                <!-- card one  -->
                                <div class="uk-card uk-card-category hyper_mt uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded uk-width-1-1">
                                    <a class="uk-position-cover" href="./pending"></a>

                                    <div class="uk-article-meta uk-flex uk-flex-middle">

                                        <div class="uk-border-circle uk-avatar-small s_logo"></div>
                                        <div>
                                            <h3><a href=""> Pending Users</a></h3>
                                            <span class="tag_active">Manage Users</span>

                                        </div>
                                    </div>
                                </div>

                                <!-- card one  -->
                                <div class="uk-card uk-card-category hyper_mt uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded uk-width-1-1">
                                    <a class="uk-position-cover" href="./active?utm_source=dashboard"></a>

                                    <div class="uk-article-meta uk-flex uk-flex-middle">

                                        <div class="uk-border-circle uk-avatar-small s_logo"></div>
                                        <div>
                                            <h3><a href=""> Active Users</a></h3>
                                            <span class="tag_active">Manage Users</span>

                                        </div>
                                    </div>
                                </div>
                            <?php
                            } else  if ($is_active === true) {

                                include("./include/user_dash.php");
                            } else {

                                if (isset($_POST['approve'])) {
                                    $msg = $_POST['msg_input'];
                                    if ($msg != "") {
                                        $user_id = $_SESSION['user_id'];
                                        $username = $_SESSION['username'];
                                        hyper_chk_bot(
                                            $bot_logs_channel_id,
                                            "<b>┃ 𝘼𝙥𝙥𝙧𝙤𝙫𝙚 𝙍𝙚𝙦𝙪𝙚𝙨𝙩 𝙁𝙧𝙤𝙢 <a href='tg://user?id=$user_id'>$username</a>\n┃ 𝙈𝙚𝙨𝙨𝙖𝙜𝙚 : $msg</b>"
                                        );
                                        return header("location: ./dashboard?message=request_sent");
                                    } else {
                                        header("location: ./dashboard?message=empty_msg");
                                    }
                                }

                            ?>
                                <h3 class="mtitle"> Your account status is <span class="tag_warn">pending</span></h3>

                                <p class="uk-text-lead uk-text-muted" style="text-align:center;">Once the site admin approve your account you can use Realm's Checker.</p>

                                <!-- <input type="text" class="uk-form-controls access_input" value="<?php echo $access_tok; ?>" readonly> -->
                                <form class="uk-form-stacked uk-margin-medium-top" method="POST" action="">
                                    <div class="uk-margin-bottom">
                                        <!-- <label class="uk-form-label" for="name">Enter sk key</label> -->
                                        <div class=" hyper_login uk-form-controls">
                                            <input id="name" class="hyper_input uk-input uk-border-rounded" name="msg_input" type="text" placeholder="Enter Message..." required>
                                        </div>
                                    </div>
                                    <div class="uk-text-center">
                                        <input class="uk-button uk-button-primary uk-border-rounded" name="approve" type="submit" value="Approve Request">
                                    </div>
                                </form>
                            <?php
                            } ?>


                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>


    <?php include './include/footer.php'; ?>

    <script src="../js/awesomplete.js"></script>
    <script src="../js/custom.js"></script>


</body>

</html>