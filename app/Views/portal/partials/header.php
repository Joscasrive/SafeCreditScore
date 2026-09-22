<?php
/**
 * Header + sidebar del portal de miembros.
 *
 * @var string               $idioma
 * @var bool                 $es
 * @var string               $MY_CURRENT_PATH
 * @var string               $title_page
 * @var array<string,array>  $tools
 * @var string               $activeTool
 * @var array<string,mixed>  $user
 */
$portalBase = $MY_CURRENT_PATH . ($es ? 'es/portal' : 'portal');

$toolUrls = [
    'credit-report'   => $portalBase,
    'score-tracker'   => $portalBase . '/score-tracker',
    'debt-analysis'   => $portalBase . '/debt-analysis',
    'score-simulator' => $portalBase . '/score-simulator',
];

$userName  = $user['full_name'] ?? ($es ? 'Miembro' : 'Member');
$userEmail = $user['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="<?= $es ? 'es' : 'en' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title_page) ?></title>
  <link rel="shortcut icon" href="<?= $MY_CURRENT_PATH ?>image/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= $MY_CURRENT_PATH ?>fonts/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap">
  <link rel="stylesheet" href="<?= $MY_CURRENT_PATH ?>css/portal.css">
</head>
<body class="portal-body">

  <div class="portal-shell">

    <div class="portal-sidebar__overlay" id="portalOverlay"></div>

    <aside class="portal-sidebar" id="portalSidebar">
      <div class="portal-sidebar__brand">
        <img src="<?= $MY_CURRENT_PATH ?>image/logo-3.png" alt="Safe Credit Score">
      </div>

      <div class="portal-sidebar__user">
        <p class="portal-sidebar__user-name"><?= esc($userName) ?></p>
        <p class="portal-sidebar__user-email"><?= esc($userEmail) ?></p>
      </div>

      <ul class="portal-nav">
        <?php foreach ($tools as $slug => $tool): ?>
          <li>
            <a href="<?= $toolUrls[$slug] ?? $portalBase ?>" class="<?= $slug === $activeTool ? 'is-active' : '' ?>">
              <i class="<?= $tool['icon'] ?>"></i>
              <span><?= esc($tool[$es ? 'es' : 'en']) ?></span>
              <?php if (! $tool['enabled']): ?>
                <span class="portal-nav__soon"><?= $es ? 'Pronto' : 'Soon' ?></span>
              <?php endif; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="portal-sidebar__footer">
        <a href="<?= $MY_CURRENT_PATH . ($es ? 'es/' : '') ?>">
          <i class="fa-solid fa-house"></i>
          <span><?= $es ? 'Ir al sitio' : 'Back to site' ?></span>
        </a>
        <a href="<?= $MY_CURRENT_PATH ?>logout">
          <i class="fa-solid fa-right-from-bracket"></i>
          <span><?= $es ? 'Cerrar sesion' : 'Log out' ?></span>
        </a>
      </div>
    </aside>

    <div class="portal-main">
      <div class="portal-topbar">
        <button type="button" class="portal-topbar__toggle" id="portalToggle" aria-label="Menu">
          <i class="fa-solid fa-bars"></i>
        </button>
        <img src="<?= $MY_CURRENT_PATH ?>image/logo-3.png" alt="Safe Credit Score" style="height: 26px;">
        <span style="width: 24px;"></span>
      </div>

      <div class="portal-content">
