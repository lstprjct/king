<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/hyper.css?v=1.7" />
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
        if ($_SESSION['roles'] === "user") {
            $userid =  $_SESSION['user_id'];
            echo $userid;
            $upd = "UPDATE users SET status='banned' WHERE user_id=$userid";
            if ($connect->query($upd) === TRUE) {
                return  $hyper->redirect_to("logout?message=user_banned");
            } else {
                return $hyper->redirect_to("./pending?message=error_ocurred&error=" . $connect->error);
            }
            $connect->close();
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
  <title>Gates</title>
</head>

<body>

    <?php include "./include/header.php"; ?>

    <div class="uk-section uk-section-muted">
        <div class="uk-container">
            <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
                <div class="uk-container uk-container-xsmall uk-padding-large">
                    <article class="uk-article">
                        <h1 class="uk-article-title">Realm's Checker Gates
                        </h1>
                        <div class="uk-article-content">
                            <?php if ($_SESSION['roles'] === 'slaver') { 

                               include("./include/admin_dash.php");

                            } else  if ($is_active === true) {

                                include("./include/user_dash.php");
                            } else {

                            ?>
                                <h3 class="mtitle"> Your account status is <span class="tag_warn">pending</span></h3>

                                <p class="uk-text-lead uk-text-muted">Once the site admin approve your account you can use flex checker.</p>

                                <p class="uk-text-lead uk-text-muted">Here is your account token (keep it in safe place).</p>
                                <input type="text" class="uk-form-controls access_input" value="<?php echo $access_tok; ?>" readonly>

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