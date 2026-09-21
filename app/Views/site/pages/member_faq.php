<?= view('site/partials/header', get_defined_vars()) ?>
<?= view('site/partials/navbar', get_defined_vars()) ?>
<div class="inner_banner-section bg-light-2">
      <div class="container">
        <div class="inner_banner-content-block">
          <h3 class="inner_banner-title"><?= $t_mfaq_banner ?></h3>
          <ul class="banner__page-navigator">
            <li>
              <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $t_mfaq_breadcrumb_home ?></a>
            </li>
            <li class="active">
              <a href="#">
                <?= $t_mfaq_breadcrumb ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    FAQ  : FAQ Section 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="faq-section_main section-padding-120">
      <div class="container">
        <div class="row row--custom justify-content-center">
          <div class="col-lg-10">
            <div class="accordion-style-1" id="faq-1_faq">
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item" aria-expanded="false" aria-controls="faq-1_faq-item">
                  <?= $t_mfaq_q1 ?> 
                </button>
                <div id="faq-1_faq-item" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_mfaq_a1 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-2" aria-expanded="false" aria-controls="faq-1_faq-item-2">
                  <?= $t_mfaq_q2 ?> 
                </button>
                <div id="faq-1_faq-item-2" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_mfaq_a2 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-3" aria-expanded="false" aria-controls="faq-1_faq-item-3">
                  <?= $t_mfaq_q3 ?>
                </button>
                <div id="faq-1_faq-item-3" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_mfaq_a3 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-4" aria-expanded="false" aria-controls="faq-1_faq-item-4">
                  <?= $t_mfaq_q4 ?>
                </button>
                <div id="faq-1_faq-item-4" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_mfaq_a4 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-5" aria-expanded="false" aria-controls="faq-1_faq-item-5">
                  <?= $t_mfaq_q5 ?>
                </button>
                <div id="faq-1_faq-item-5" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_mfaq_a5 ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1_faq-item-6" aria-expanded="false" aria-controls="faq-1_faq-item-6">
                  <?= $t_mfaq_q6 ?>
                </button>
                <div id="faq-1_faq-item-6" class="accordion-collapse collapse" data-bs-parent="#faq-1_faq">
                  <div class="accordion-item__body">
                    <?= $t_mfaq_a6 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="section-button">
          <a href="<?php echo $t_nav_contact_url; ?>" class="btn-masco btn-fill--up rounded-pill"><span><?= $t_mfaq_cta ?></span></a>
        </div>
      </div>
    </div>
<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars()); 
?>
