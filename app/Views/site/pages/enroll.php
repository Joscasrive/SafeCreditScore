<?php
/**
 * Pagina de enrolamiento (array-account-enroll) integrada al diseno del sitio.
 *
 * @var string $appKey
 * @var string $embedUrl
 * @var string $sandbox
 * @var string $saveTokenUrl
 * @var string $reportUrl
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
      <h3 class="inner_banner-title"><?= $es ? 'Crea tu cuenta' : 'Create your account' ?></h3>
      <ul class="banner__page-navigator">
        <li>
          <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $es ? 'Inicio' : 'Home' ?></a>
        </li>
        <li class="active">
          <a href="#"><?= $es ? 'Registro' : 'Sign up' ?></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="array-embed-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-xl-8">
        <div class="text-center array-embed-intro">
          <h2 style="font-weight: 700;">
            <?= $es ? 'Verifica tu identidad' : 'Verify your identity' ?>
          </h2>
          <p class="text-muted mb-0">
            <?= $es
              ? 'Completa el proceso de verificacion para acceder a tu reporte y puntaje de credito de las tres agencias.'
              : 'Complete the verification process to access your three-bureau credit report and score.' ?>
          </p>
        </div>

        <array-account-enroll
          appKey="<?= esc($appKey, 'attr') ?>"
          sandbox="<?= esc($sandbox, 'attr') ?>">
        </array-account-enroll>

        <div class="array-embed-status text-center mt-3" id="enroll-status"></div>
      </div>
    </div>
  </div>
</div>

<style>
  .array-embed-section { padding: 48px 0 64px; }
  .array-embed-intro { max-width: 620px; margin: 0 auto 8px; }
  .array-embed-intro h2 { margin-bottom: 12px; }
  /* El componente de Array trae su propia tarjeta: la alineamos sin dobles espacios */
  array-account-enroll { display: block; }
  array-account-enroll::part(container) { margin-top: 0; }
</style>

<script src="<?= $embedUrl ?>/array-account-enroll.js?appKey=<?= esc($appKey, 'attr') ?>"></script>
<script>
  (function () {
    const saveTokenUrl = <?= json_encode($saveTokenUrl) ?>;
    const finishUrl    = <?= json_encode($finishUrl) ?>;
    const statusEl     = document.getElementById('enroll-status');
    const texts = {
      saving:   <?= json_encode($es ? 'Verificacion exitosa. Guardando tu sesion...' : 'Verification successful. Saving your session...') ?>,
      redirect: <?= json_encode($es ? 'Listo. Vamos a crear tu contrasena...' : 'Done. Let\'s create your password...') ?>,
      error:    <?= json_encode($es ? 'Ocurrio un error al guardar tu sesion. Intenta de nuevo.' : 'An error occurred saving your session. Please try again.') ?>
    };

    window.addEventListener('array-event', function (arrayEvent) {
      const { event, metadata = {}, userId } = arrayEvent.detail || {};
      console.log('array-event:', arrayEvent.detail);

      if (event !== 'success') {
        return;
      }

      const userToken = metadata['user-token'];
      console.log('Evento success -> userId:', userId, '| userToken presente:', !!userToken);
      statusEl.textContent = texts.saving;

      fetch(saveTokenUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_token: userToken, user_id: userId })
      })
        .then(function (response) {
          return response.text().then(function (raw) {
            let parsed = null;
            try { parsed = JSON.parse(raw); } catch (e) { /* no era JSON */ }
            return { ok: response.ok, status: response.status, raw: raw, data: parsed };
          });
        })
        .then(function (result) {
          console.log('Respuesta de save-token:', result);
          if (result.data && result.data.success) {
            statusEl.textContent = texts.redirect;
            window.location.href = (result.data.redirect || finishUrl);
          } else if (result.data && result.data.message) {
            statusEl.textContent = texts.error + ' (' + result.data.message + ')';
          } else {
            statusEl.textContent = texts.error + ' [HTTP ' + result.status + ']';
          }
        })
        .catch(function (err) {
          console.error('Error de red guardando token:', err);
          statusEl.textContent = texts.error + ' (' + (err && err.message ? err.message : 'network') + ')';
        });
    });
  })();
</script>

<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars());
