<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
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
    }else{
      return header("location: ./dashboard?message=account_not_active");
    }
    if ($_SESSION['access'] !== null) {
      $access_tok = $_SESSION['access'];
    }
  }
  if ($is_active === false) {
    return header("location: ./dashboard?message=account_not_active");
  }
  if ($userLogged !== true) {
    return header("location: ./?message=user_not_logged");
  }
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checker - <?php echo $appconfig['site_title']; ?></title>
  <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/hyper.css?v=6.2" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <script src="../js/uikit.js"></script>
</head>

<body>

  <?php

  include("./include/header.php");

  ?>

  <div class="uk-section uk-section-muted">
    <div class="uk-container">
      <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
        <div class="uk-container uk-container-xsmall uk-padding-large">
          <article class="uk-article">
            <center>
            <div style='filter: invert(1); height: 70px; width: 70px; margin-top: -4px;margin-bottom: 40px;'><img src="../anonymousheader.svg"></div>
            </center>
            <div class="uk-article-content">
              <?php

              if ($hyper->get_parameter("limit", "reached")) {
                echo $hyper->create_notice_bar(
                  array(
                    "text" => "Limit reached (Dont check more than 5000)",
                    "css" => "text-warn",
                    "ele" => "p"
                  )
                );
              } elseif ($hyper->get_parameter("is_generated", "true")) {
                echo $hyper->create_notice_bar(
                  array(
                    "text" => "Cant check! You are using generated ccs.",
                    "css" => "text-warn",
                    "ele" => "p"
                  )
                );
              }
              ?>
              <!-- <p class="uk-text-lead uk-text-muted">Warning: don't use generated ccs don't be noob!</p> -->
              <div class="uk-form-stacked uk-margin-medium-top">

                <div class="uk-margin-bottom">
                  <!-- <span id="totalCount">430</span> -->
                  <label class="uk-form-label" for="message"><span>Drop Ccs
                      <span class="tag_required" id="lista_leb">Required</span></span>
                    <span class="tag_total">Total <span id="totalCount">0</span></span>

                    <span class="tag_info">Checked <span id="totalChecked">0</span></span>
                  </label>
                  <div class="uk-form-controls" id="lista_con">
                    <textarea id="message" class="hyper_ccs uk-textarea uk-border-rounded" placeholder="XXXXXXXXXXXXX|XX|XXXX|XXX" name="lista" rows="5" minlength="10" required=""></textarea>
                  </div>
                </div>

                <div class="row-col">
                <div class="uk-margin-bottom" id="amount_container">
                  <label class="uk-form-label" for="name">Telegram ID <span class="tag_optional">optional</span></label>
                  <div class="uk-form-controls hyper_login">
                    <input id="tg_id" class="hyper_input uk-input uk-border-rounded" name="name" type="text" placeholder="Telegram ID" required>
                  </div>
                </div>

                <div class="uk-margin-bottom" id="amount_container">
                  <label class="uk-form-label" for="name">Amount <span class="tag_optional">optional</span></label>
                  <div class="uk-form-controls hyper_login">
                    <input id="amount" class="hyper_input uk-input uk-border-rounded" name="number" type="text" placeholder="Enter Amount" required>
                  </div>
                </div>
            </div>

                <div class="row-col">
                <div class="uk-margin-bottom" id="amount_container">
                  <label class="uk-form-label" for="name">Forwarder<span class="tag_required">Types</span></label>
                  <div class="uk-form-controls hyper_login">
                    <select name="fwtype" id="fwtype">
                      <option value="hits">Charges|CVV|CCN</option>
                    </select>
                  </div>
                </div>

                <div class="uk-margin-bottom" id="amount_container">
                  <label class="uk-form-label" for="name">Currency<span class="tag_required">Choose</span></label>
                  <div class="uk-form-controls hyper_login">
                    <select name="curr" id="curr">
                      <option value="usd">USD</option>
                      <!-- <option value="gbp">GBP</option> -->
                      <option value="inr">INR</option>
                      <!-- <option value="cad">CAD</option> -->
                      <option value="eur">EUR</option>
                    </select>
                  </div>
                </div>
                </div>

                

                <!-- <div class="uk-margin-bottom">
                <label class="uk-form-label" for="_subject">SK KEY</label>
                <div class="uk-form-controls hyper_login">
                  <input id="_subject" class="hyper_input uk-input uk-border-rounded" placeholder="sk_live_xxxxxxxx" name="_subject" type="text">
                </div>
              </div> -->

                <div class="uk-text-center">
                  <button class="uk-button uk-button-primary uk-border-rounded" id="startbtn" type="submit">start check</button>
                  <button class="uk-button uk-button-primary uk-border-rounded" id="stopbtn" type="submit"> Reload It</button>

                </div>
              </div>




              <div class="uk-card card_cvv uk-card-category hyper_mt3 uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded uk-width-1-1">
                <!-- <a class="uk-position-cover" href="article.html"></a> -->
                <h3 class="uk-card-title uk-margin-remove uk-text-primary green_title">CVV - <span id="cvvCount">0</span>

                  <span id="showCvv">Show</span>
                  <span id="saveCvv">Save</span>
                </h3>
                <span id="cvvList">
                  <!-- <p class="uk-margin-small-top">4562463863427327|12|22|223 - Insufficient Funds</p>
                <p class="uk-margin-small-top">5362463863427326|12|27|674 - Insufficient Funds</p> -->
                </span>

              </div>

              <!-- ccn  -->
              <div class="uk-card ccn_card uk-card-category hyper_mt3 uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded uk-width-1-1">

                <h3 class="uk-card-title uk-margin-remove uk-text-primary warn_title">CCN - <span id="ccnCount">0</span>
                  <span id="showCcn">Show</span>
                  <span id="saveCcn">Save</span>
                </h3>
                <span id="ccnList">
                  <!-- <p class="uk-margin-small-top">4562463863427327|12|22|223</p> -->
                </span>


              </div>

              <!-- dead  -->
              <div class="uk-card dead_card uk-card-category hyper_mt3 uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded uk-width-1-1">

                <h3 class="uk-card-title uk-margin-remove uk-text-primary dead_title">Dead - <span id="deadCount">0</span>
                  <span id="showDead">Show</span>
                </h3>
                <div id="deadList">
                </div>

              </div>

            </div>
          </article>
        </div>
      </div>
    </div>
  </div>

  <?php include './include/footer.php'; ?>

  <script src="../js/awesomplete.js"></script>
  <script src="../js/jquery.js"></script>
  <script src="../js/hyper.js?v=1.2"></script>
  <script src="../js/hyper.notify.js?v=1.2"></script>
  <script src="../js/hyper.checker.js?v=2.5"></script>
  <!-- <script src="js/session.js"></script> -->



</body>

</html>