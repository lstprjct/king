<div id="offcanvas-docs" data-uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar">
    <button class="uk-offcanvas-close" type="button" data-uk-close></button>
    <h5 class="uk-margin-top">Contact us</h5>
    <ul class="uk-nav uk-nav-default doc-nav">
      <li class="uk-active"><a href="https://t.me/+ZEaR6sg52HViN2Zh">Join Group</a></li>
      <li><a href="https://t.me/+5qMdG8WUdYg5YjJl">Join Channel</a></li>
    </ul>

  </div>
</div>

<div id="offcanvas" data-uk-offcanvas="flip: true; overlay: true">
  <div class="uk-offcanvas-bar">
    <a class="uk-logo" href="index.html"><span class="dr_logo"></span></a>
    <button class="uk-offcanvas-close" type="button" data-uk-close></button>
    <ul class="uk-nav uk-nav-primary uk-nav-offcanvas uk-margin-top uk-text-center">
      <li><a href="./">Home</a></li>
      <li><a href="./create?utm_source=drchcker">Create Token</a></li>
      <?php if ($userLogged === false) { ?>
        <li>
          <div class="uk-navbar-item"><a class="uk-button uk-button-primary" href="./login?utm_source=drchecker">Login</a></div>
        </li>
      <?php } else { ?>
        <li>
          <div class="uk-navbar-item"><a class="uk-button uk-button-primary logoutbtn" href="./logout?seession_destroy=true">Logout</a></div>
        </li>

      <?php } ?>
    </ul>
    <div class="uk-margin-top uk-text-center">
      <div data-uk-grid class="uk-child-width-auto uk-grid-small uk-flex-center">

        <div>
          <a href="./social?join=telegram&username=dr_bins&utm_source=drchcker" data-uk-icon="icon: telegram" class="uk-icon-link" target="_blank"></a>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="uk-section uk-text-center uk-text-muted">
  <div class="uk-container uk-container-small">
    <div>
      <ul class="uk-subnav uk-flex-center">
        <li><a href="./">Home</a></li>
        <li><a href="#">Support</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>

    <div class="uk-margin-medium uk-text-small uk-link-muted">
      Crafted By <a href="https://t.me/K1NGX"><?php echo $appconfig['author']; ?>.</a></div>
  </div>
</footer>
