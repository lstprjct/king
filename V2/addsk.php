<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/hyper.css?v=1.1" />
    <script src="../js/uikit.js"></script>
</head>

<body>

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
        }else{
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
         if ($_SESSION['status'] === 'active'){
            $is_active =true;
        }else{
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
        if($_SESSION['access']!== null){
            $access_tok = $_SESSION['access'];
        }
      }
      if ($userLogged !== true) {
        return header("location: ./?message=user_not_logged");
      }

    include "./include/header.php";

    $message = "";
    function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
    if (isset($_POST['addsk'])) {
        $sk = $hyper->encode($_POST['sk_input']);
            file_put_contents('../api/skencrypted.txt', $sk . PHP_EOL, FILE_APPEND | LOCK_EX);
            header("location:./addsk?message=added_sk");
            // exit();
    }

    ?>

    <div class="uk-section uk-section-muted">
        <div class="uk-container">
            <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
                <div class="uk-container uk-container-xsmall uk-padding-large">
                    <article class="uk-article">
                        <h1 class="uk-article-title">Add New SK</h1>
                        <div class="uk-article-content">
                            <?php
                            
                            if ($hyper->get_parameter("message", "sk_invalid")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Invalid sk provided.",
                                        "css" => "text-warn",
                                        "ele"=>"p"
                                    )
                                );
                            } 
                             if ($hyper->get_parameter("message", "added_sk")) {
                                echo $hyper->create_notice_bar(
                                    array(
                                        "text" => "Your sk has been added",
                                        "css" => "text-success",
                                        "ele"=>"p"
                                    )
                                );
                            }
                            ?>
                            <p class="uk-text-lead uk-text-muted">Your current sk is <a href="#" class="access_link">


         <?php
                                    $sk_file = file("../api/skencrypted.txt");
                                    $get_sk = end($sk_file);
                                    $sk = trim($get_sk);
                                    if (strlen($sk) > 20)
                                        $sk = substr($sk, 0, 20).'xxx';
                                    echo $hyper->decode($sk);

                                    ?>
                                </a></p>
                            <form class="uk-form-stacked uk-margin-medium-top" method="POST" action="">
                                <div class="uk-margin-bottom">
                                   
                                    <div class=" hyper_login uk-form-controls">
                                        <input id="name" class="hyper_input uk-input uk-border-rounded" name="sk_input" type="text" placeholder="Enter Sk Live Key..." required>
                                    </div>
                                </div>
                                <div class="uk-text-center">
                                    <input class="uk-button uk-button-primary uk-border-rounded" name="addsk" type="submit" value="Add new sk">
                                </div>
                            </form>
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