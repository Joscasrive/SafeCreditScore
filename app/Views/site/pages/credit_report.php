<?php
/**
 * Pagina del reporte 3B (array-credit-report) integrada al diseno del sitio.
 *
 * @var string $appKey
 * @var string $embedUrl
 * @var string $componentApiUrl
 * @var string $sandbox
 * @var string $userToken
 * @var string $enrollUrl
 * @var string $error
 * @var string $idioma
 * @var string $MY_CURRENT_PATH
 */
$es = ($idioma ?? '') === 'es';
?>
<?= view('site/partials/header', get_defined_vars()) ?>
<?= view('site/partials/navbar', get_defined_vars()) ?>

<div class="inner_banner-section bg-light-2">
  <div class="container">
    <div class="inner_banner-content-block">
      <h3 class="inner_banner-title"><?= $es ? 'Tu reporte de credito 3B' : 'Your 3B credit report' ?></h3>
      <ul class="banner__page-navigator">
        <li>
          <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $es ? 'Inicio' : 'Home' ?></a>
        </li>
        <li class="active">
          <a href="#"><?= $es ? 'Reporte de credito' : 'Credit report' ?></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="section-padding-120">
  <div class="container">

    <?php if (! empty($error)): ?>
      <div class="alert alert-warning" role="alert" style="border-radius: 12px;">
        <?= esc($error) ?>
      </div>
    <?php endif; ?>

    <?php if ($userToken === ''): ?>
      <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
          <div class="p-5 bg-light-2 rounded-4">
            <h3 class="mb-3"><?= $es ? 'No hay una sesion activa' : 'No active session' ?></h3>
            <p class="text-muted mb-4">
              <?= $es
                ? 'No encontramos una sesion activa. Por favor completa tu registro primero.'
                : 'We could not find an active session. Please complete your sign up first.' ?>
            </p>
            <a href="<?= esc($enrollUrl, 'attr') ?>" class="btn-masco rounded-pill">
              <span><?= $es ? 'Ir al registro' : 'Go to sign up' ?></span>
            </a>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="array-embed-card bg-light-2 rounded-4 p-3 p-md-4">
        <array-credit-report
          appKey="<?= esc($appKey, 'attr') ?>"
          userToken="<?= esc($userToken, 'attr') ?>"
          apiUrl="<?= esc($componentApiUrl, 'attr') ?>"
          sandbox="<?= esc($sandbox, 'attr') ?>"
          defaultBureau="all">
        </array-credit-report>
      </div>
    <?php endif; ?>

  </div>
</div>

<?php if ($userToken !== ''): ?>
<script src="<?= $embedUrl ?>/array-credit-report.js?appKey=<?= esc($appKey, 'attr') ?>"></script>
<script>
  window.addEventListener('array-event', function (arrayEvent) {
    console.log('array-event:', arrayEvent.detail);
  });
</script>
<?php endif; ?>

<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars());
