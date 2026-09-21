<?= view('site/partials/header', get_defined_vars()) ?>
<?= view('site/partials/navbar', get_defined_vars()) ?>
<div class="inner_banner-section bg-light-2">
      <div class="container">
        <div class="inner_banner-content-block">
          <h3 class="inner_banner-title"><?= $t_cfaq_banner ?></h3>
          <ul class="banner__page-navigator">
            <li>
              <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $t_cfaq_breadcrumb_home ?></a>
            </li>
            <li class="active">
              <a href="#">
                <?= $t_cfaq_breadcrumb ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="faq-section_main section-padding-120">
      <div class="container">
        <div class="row row--custom justify-content-center">
          <div class="col-lg-10">
            <div class="accordion-style-1" id="faq-1_faq">
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item" aria-expanded="false" aria-controls="faq-1_faq-item">
                  <?= $t_cfaq_q1 ?> 
                </button>
                <div id="faq-1_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a1 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-2" aria-expanded="false" aria-controls="faq-1_faq-item-2">
                  <?= $t_cfaq_q2 ?> 
                </button>
                <div id="faq-1_faq-item-2" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a2 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-3" aria-expanded="false" aria-controls="faq-1_faq-item-3">
                  <?= $t_cfaq_q3 ?> 
                </button>
                <div id="faq-1_faq-item-3" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a3 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-4" aria-expanded="false" aria-controls="faq-1_faq-item-4">
                  <?= $t_cfaq_q4 ?>
                </button>
                <div id="faq-1_faq-item-4" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a4 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-5" aria-expanded="false" aria-controls="faq-1_faq-item-5">
                  <?= $t_cfaq_q5 ?>
                </button>
                <div id="faq-1_faq-item-5" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a5 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-6" aria-expanded="false" aria-controls="faq-1_faq-item-6">
                  <?= $t_cfaq_q6 ?>
                </button>
                <div id="faq-1_faq-item-6" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a6 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-7" aria-expanded="false" aria-controls="faq-1_faq-item-7">
                  <?= $t_cfaq_q7 ?>
                </button>
                <div id="faq-1_faq-item-7" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a7 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-8" aria-expanded="false" aria-controls="faq-1_faq-item-8">
                  <?= $t_cfaq_q8 ?> 
                </button>
                <div id="faq-1_faq-item-8" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a8 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-9" aria-expanded="false" aria-controls="faq-1_faq-item-9">
                  <?= $t_cfaq_q9 ?>
                </button>
                <div id="faq-1_faq-item-9" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a9 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-10" aria-expanded="false" aria-controls="faq-1_faq-item-10">
                  <?= $t_cfaq_q10 ?>
                </button>
                <div id="faq-1_faq-item-10" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a10 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-11" aria-expanded="false" aria-controls="faq-1_faq-item-11">
                  <?= $t_cfaq_q11 ?> 
                </button>
                <div id="faq-1_faq-item-11" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_cfaq_a11 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="section-button">
          <a href="<?php echo $t_nav_contact_url; ?>" class="btn-masco btn-fill--up rounded-pill"><span><?= $t_cfaq_cta ?></span></a>
        </div>
      </div>
    </div>
<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars()); 
?>
