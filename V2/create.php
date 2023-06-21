<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16" >
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/hyper.css?v=1.8" />
    <script src="../js/uikit.js"></script>
    <?php include "../config.php";?>
</head>

<body>

<?php include"./include/header.php"; ?>

<div class="uk-section uk-section-muted">
  <div class="uk-container">
    <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
      <div class="uk-container uk-container-xsmall uk-padding-large">
        <div calss="hyper_mt" style="margin-top:30px;"></div>
        <article class="uk-article">
          <center>
          <div style='filter: invert(1); height: 50px; width: 50px; margin-top: -4px;margin-bottom: 40px;'><img src="../anonymousheader.svg"></div>
          </center>
          <div class="uk-article-content">
              <center>
               <p class="uk-text-lead uk-text-muted">Already have account? <a href="./?_login=create_session" class="access_link"> Login</a></p>
              </center>
            
              <div class="uk-text-center">
                <a class="uk-button uk-button-primary uk-border-rounded" href="<?php echo $appconfig['bot_link']; ?>" >
                Register On Bot
          </a>
              </div>
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