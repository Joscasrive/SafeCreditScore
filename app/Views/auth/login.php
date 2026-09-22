<?php
/**
 * Pagina de login del portal de miembros.
 *
 * @var string              $idioma
 * @var string              $MY_CURRENT_PATH
 * @var array<int,string>   $errors
 * @var array<string,mixed> $old
 */
$es = ($idioma ?? '') === 'es';
?>
<?= view('site/partials/header', get_defined_vars()) ?>
<?= view('site/partials/navbar', get_defined_vars()) ?>

<div class="inner_banner-section bg-light-2">
  <div class="container">
    <div class="inner_banner-content-block">
      <h3 class="inner_banner-title"><?= $es ? 'Inicia sesion' : 'Log in' ?></h3>
      <ul class="banner__page-navigator">
        <li>
          <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $es ? 'Inicio' : 'Home' ?></a>
        </li>
        <li class="active">
          <a href="#"><?= $es ? 'Iniciar sesion' : 'Log in' ?></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="section-padding-120">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-xl-5">

        <?php if (! empty($errors)): ?>
          <div class="alert alert-danger" role="alert" style="border-radius: 12px;">
            <ul class="mb-0 ps-3">
              <?php foreach ($errors as $err): ?>
                <li><?= esc($err) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('auth_error')): ?>
          <div class="alert alert-warning" role="alert" style="border-radius: 12px;">
            <?= esc(session()->getFlashdata('auth_error')) ?>
          </div>
        <?php endif; ?>

        <div class="bg-light-2 rounded-4 p-4 p-md-5">
          <h2 class="mb-2" style="font-weight: 700;"><?= $es ? 'Bienvenido de nuevo' : 'Welcome back' ?></h2>
          <p class="text-muted mb-4">
            <?= $es
              ? 'Ingresa con el correo y contrasena que creaste al finalizar tu registro.'
              : 'Sign in with the email and password you created when you finished signing up.' ?>
          </p>

          <form method="post" action="<?= current_url() ?>">
            <div class="mb-3">
              <label class="form-label"><?= $es ? 'Correo electronico' : 'Email address' ?></label>
              <input type="email" name="email" class="form-control" required
                     value="<?= esc($old['email'] ?? '') ?>"
                     placeholder="<?= $es ? 'tu@correo.com' : 'you@email.com' ?>">
            </div>
            <div class="mb-4">
              <label class="form-label"><?= $es ? 'Contrasena' : 'Password' ?></label>
              <input type="password" name="password" class="form-control" required
                     placeholder="<?= $es ? 'Tu contrasena' : 'Your password' ?>">
            </div>
            <button type="submit" class="btn-masco rounded-pill w-100">
              <span><?= $es ? 'Iniciar sesion' : 'Log in' ?></span>
            </button>
          </form>

          <p class="text-center text-muted mt-4 mb-0">
            <?= $es ? 'Aun no tienes cuenta?' : "Don't have an account yet?" ?>
            <a href="<?= $MY_CURRENT_PATH . ($es ? 'es/enroll' : 'enroll') ?>">
              <?= $es ? 'Registrate aqui' : 'Sign up here' ?>
            </a>
          </p>
        </div>

      </div>
    </div>
  </div>
</div>

<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars());
