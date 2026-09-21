<?= view('site/partials/header', get_defined_vars()) ?>
<?= view('site/partials/navbar', get_defined_vars()) ?>
<div class="inner_banner-section bg-light-2">
      <div class="container">
        <div class="inner_banner-content-block">
          <h3 class="inner_banner-title"><?= $t_contact_banner ?></h3>
          <ul class="banner__page-navigator">
            <li>
              <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $t_contact_breadcrumb_home ?></a>
            </li>
            <li class="active">
              <a href="#">
                <?= $t_contact_breadcrumb ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="contact-3_main-section section-padding-120">
      <div class="container">
        <div class="row row--custom">
          <div class="col-xl-5 col-lg-6">
            <div class="feature-widget-6-row">
              <div class="feature-widget-6" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="">
                <div class="feature-widget-6__icon">
                  <img src="<?php echo $MY_CURRENT_PATH; ?>image/contact-details/feature-icon-1.svg" alt="image alt">
                </div>
                <div class="feature-widget-6__body">
                  <h3 class="feature-widget-6__title"><?= $t_contact_w1_titulo ?></h3>
                  <p><?= $t_contact_w1_texto ?></p>
                </div>
              </div>
              <div class="feature-widget-6" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="">
                <div class="feature-widget-6__icon">
                  <img src="<?php echo $MY_CURRENT_PATH; ?>image/contact-details/feature-icon-2.svg" alt="image alt">
                </div>
                <div class="feature-widget-6__body">
                  <h3 class="feature-widget-6__title"><?= $t_contact_w2_titulo ?></h3>
                  <p><?= $t_contact_w2_texto ?></p>
                </div>
              </div>
              <div class="feature-widget-6" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="">
                <div class="feature-widget-6__icon">
                  <img src="<?php echo $MY_CURRENT_PATH; ?>image/contact-details/feature-icon-3.svg" alt="image alt">
                </div>
                <div class="feature-widget-6__body">
                  <h3 class="feature-widget-6__title"><?= $t_contact_w3_titulo ?></h3>
                  <p><?= $t_contact_w3_texto ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="offset-lg-1 col-lg-6 col-md-10">
            <div class="contact-3_main-comment-box-wrapper bg-light-2">
              <form class="contact-3_main-comment-box">
                <div class="contact-3_main-comment-box__form-inner">
                  <h2 class="contact-title">
                    <?= $t_contact_form_titulo ?>
                  </h2>
                  <div class="contact-3_main-comment-box__form-input">
                    <input class="form-control " type="text" placeholder="<?= $t_contact_form_nombre ?>">
                  </div>
                  <div class="contact-3_main-comment-box__form-input">
                    <input class="form-control " type="text" placeholder="<?= $t_contact_form_telefono ?>">
                  </div>
                  <div class="contact-3_main-comment-box__form-input">
                    <input class="form-control " type="text" placeholder="<?= $t_contact_form_email ?>">
                  </div>
                  <div class="contact-3_main-comment-box__form-input">
                    <textarea class="form-control  textarea" placeholder="<?= $t_contact_form_mensaje ?>"></textarea>
                  </div>
                </div>
                <div class="contact-3_main-comment-box__form-input-button">
                  <button type="submit" class="btn-masco rounded-pill w-100"><?= $t_contact_form_btn ?></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars()); 
?>