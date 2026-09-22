<?php
/**
 * Portal > seccion aun no activada (Score Tracker, Debt Analysis, Score Simulator...).
 *
 * @var bool                $es
 * @var array<string,array> $tools
 * @var string              $activeTool
 */
$tool = $tools[$activeTool] ?? ['en' => 'This tool', 'es' => 'Esta herramienta', 'icon' => 'fa-solid fa-hourglass-half'];
?>
<?= view('portal/partials/header', get_defined_vars()) ?>

<div class="portal-page-header">
  <h1><?= esc($tool[$es ? 'es' : 'en']) ?></h1>
</div>

<div class="portal-card portal-coming-soon">
  <i class="<?= $tool['icon'] ?>"></i>
  <h2><?= $es ? 'Muy pronto en tu portal' : 'Coming soon to your portal' ?></h2>
  <p>
    <?= $es
      ? 'Estamos activando esta herramienta con Array.io para que la veas aqui mismo, sin salir de tu portal.'
      : "We're activating this tool with Array.io so you can use it right here in your portal." ?>
  </p>
  <span class="portal-badge-soon"><?= $es ? 'Proximamente' : 'Coming soon' ?></span>
</div>

<?= view('portal/partials/footer', get_defined_vars()) ?>
