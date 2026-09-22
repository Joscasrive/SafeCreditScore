<?php
/**
 * Portal > Reporte de credito 3B (array-credit-report).
 *
 * @var string $appKey
 * @var string $embedUrl
 * @var string $componentApiUrl
 * @var string $sandbox
 * @var string $userToken
 * @var string $error
 * @var bool   $es
 */
?>
<?= view('portal/partials/header', get_defined_vars()) ?>

<div class="portal-page-header">
  <h1><?= $es ? 'Tu reporte de credito 3B' : 'Your 3B credit report' ?></h1>
  <p><?= $es
    ? 'Datos de las tres agencias (TransUnion, Experian y Equifax) en un solo lugar.'
    : 'Data from all three bureaus (TransUnion, Experian and Equifax) in one place.' ?></p>
</div>

<?php if (! empty($error)): ?>
  <div class="portal-alert portal-alert--error"><?= esc($error) ?></div>
<?php endif; ?>

<?php if ($userToken === ''): ?>
  <div class="portal-card portal-coming-soon">
    <i class="fa-solid fa-triangle-exclamation"></i>
    <h2><?= $es ? 'No pudimos cargar tu reporte' : "We couldn't load your report" ?></h2>
    <p><?= $es
      ? 'Vuelve a intentarlo en unos minutos. Si el problema continua, contacta a soporte.'
      : 'Please try again in a few minutes. If the issue continues, contact support.' ?></p>
  </div>
<?php else: ?>
  <div class="portal-card portal-array-embed">
    <array-credit-report
      appKey="<?= esc($appKey, 'attr') ?>"
      userToken="<?= esc($userToken, 'attr') ?>"
      apiUrl="<?= esc($componentApiUrl, 'attr') ?>"
      sandbox="<?= esc($sandbox, 'attr') ?>"
      defaultBureau="all">
    </array-credit-report>
  </div>

  <script src="<?= $embedUrl ?>/array-credit-report.js?appKey=<?= esc($appKey, 'attr') ?>"></script>
  <script>
    window.addEventListener('array-event', function (arrayEvent) {
      console.log('array-event:', arrayEvent.detail);
    });
  </script>
<?php endif; ?>

<?= view('portal/partials/footer', get_defined_vars()) ?>
