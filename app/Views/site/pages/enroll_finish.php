<?php
/**
 * Ultimo paso del enrolamiento: el cliente crea su nombre/correo/contrasena
 * para poder volver a entrar a su portal despues.
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
      <h3 class="inner_banner-title"><?= $es ? 'Ultimo paso' : 'Last step' ?></h3>
      <ul class="banner__page-navigator">
        <li>
          <a href="<?php echo $MY_CURRENT_PATH; ?>"><?= $es ? 'Inicio' : 'Home' ?></a>
        </li>
        <li class="active">
          <a href="#"><?= $es ? 'Crea tu contrasena' : 'Create your password' ?></a>
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

        <div class="bg-light-2 rounded-4 p-4 p-md-5">
          <div class="text-center mb-4">
            <i class="fa-solid fa-circle-check" style="font-size: 2.2rem; color: #22a06b;"></i>
          </div>
          <h2 class="mb-2 text-center" style="font-weight: 700;">
            <?= $es ? 'Identidad verificada!' : 'Identity verified!' ?>
          </h2>
          <p class="text-muted mb-4 text-center">
            <?= $es
              ? 'Crea tu correo y contrasena para acceder a tu portal cada vez que quieras, sin repetir la verificacion.'
              : "Create your email and password so you can access your portal any time, without repeating verification." ?>
          </p>

          <form method="post" action="<?= current_url() ?>">
            <div class="mb-3">
              <label class="form-label"><?= $es ? 'Nombre completo' : 'Full name' ?></label>
              <input type="text" name="full_name" class="form-control" required
                     value="<?= esc($old['full_name'] ?? '') ?>"
                     placeholder="<?= $es ? 'Tu nombre completo' : 'Your full name' ?>">
            </div>
            <div class="mb-3">
              <label class="form-label"><?= $es ? 'Correo electronico' : 'Email address' ?></label>
              <input type="email" name="email" class="form-control" required
                     value="<?= esc($old['email'] ?? '') ?>"
                     placeholder="<?= $es ? 'tu@correo.com' : 'you@email.com' ?>">
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label"><?= $es ? 'Contrasena' : 'Password' ?></label>
                <input type="password" name="password" class="form-control" required minlength="8"
                       placeholder="<?= $es ? 'Minimo 8 caracteres' : 'At least 8 characters' ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label"><?= $es ? 'Confirmar contrasena' : 'Confirm password' ?></label>
                <input type="password" name="password_confirm" class="form-control" required minlength="8"
                       placeholder="<?= $es ? 'Repite tu contrasena' : 'Repeat your password' ?>">
              </div>
            </div>
            <button type="submit" class="btn-masco rounded-pill w-100 mt-2">
              <span><?= $es ? 'Crear cuenta y ver mi portal' : 'Create account and view my portal' ?></span>
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<?php
echo view('site/partials/footer', get_defined_vars());
echo view('site/partials/scripts', get_defined_vars());
