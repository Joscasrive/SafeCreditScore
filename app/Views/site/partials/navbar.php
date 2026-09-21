<?php
$t_nav_home_url    ??= '';
$t_nav_mfaq_url    ??= '';
$t_nav_cfaq_url    ??= '';
$t_nav_contact_url ??= '';
$t_nav_login_url   ??= '';
$t_lang_switch_url ??= '';
$t_nav_home        ??= '';
$t_nav_member_faq  ??= '';
$t_nav_credit_faq  ??= '';
$t_nav_contact     ??= '';
$t_nav_signup      ??= '';
$t_nav_signup_url  ??= '#';
$t_nav_login       ??= '';
?>
<body>
  <div class="preloader-wrapper">
    <div class="lds-ellipsis">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  <div class="page-wrapper overflow-hidden">
    <header class="site-header site-header--transparent site-header--sticky">
      <div class="container">
        <nav class="navbar site-navbar">
          <div class="brand-logo">
            <a href="<?php echo $t_nav_home_url; ?>">
              <img class="logo-light" src="<?php echo $MY_CURRENT_PATH; ?>image/logo-3.png" alt="brand logo">
              <img class="logo-dark" src="<?php echo $MY_CURRENT_PATH; ?>image/logo-3.png" alt="brand logo">
            </a>
          </div>
          <div class="menu-block-wrapper ">
            <div class="menu-overlay"></div>
            <nav class="menu-block" id="append-menu-header">
              <div class="mobile-menu-head">
                <div class="current-menu-title"></div>
                <div class="mobile-menu-close">&times;</div>
              </div>
              <ul class="site-menu-main">
                <li class="nav-item">
                  <a href="<?php echo $t_nav_home_url; ?>" class="nav-link-item"><?= $t_nav_home ?></a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo $t_nav_mfaq_url; ?>" class="nav-link-item"><?= $t_nav_member_faq ?></a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo $t_nav_cfaq_url; ?>" class="nav-link-item"><?= $t_nav_credit_faq ?></a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo $t_nav_contact_url; ?>" class="nav-link-item"><?= $t_nav_contact ?></a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="lang-switcher">
            <a href="<?php echo $MY_CURRENT_PATH; ?>es/" class="lang-btn" title="Español">
              <img src="<?php echo $MY_CURRENT_PATH; ?>image/esp.png" alt="Bandera español">
            </a>
            <a href="<?php echo $t_lang_switch_url; ?>" class="lang-btn" title="English">
              <img src="<?php echo $MY_CURRENT_PATH; ?>image/usa.png" alt="Bandera inglés">
            </a>
          </div>
          <div class="mobile-menu-trigger">
            <span></span>
          </div>
          <div class="header-cta-btn-wrapper">
            <a href="<?php echo $t_nav_signup_url; ?>" class="btn-masco btn-masco--header btn-masco--header-secondary">
              <span><?= $t_nav_signup ?></span>
            </a>
            <a href="#" class="btn-masco btn--header btn-primary-l03 btn-shadow rounded-pill">
              <span><?= $t_nav_login ?></span>
            </a>
          </div>
        </nav>
      </div>
    </header>
