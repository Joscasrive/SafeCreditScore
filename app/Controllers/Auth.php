<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Login / logout del portal de miembros.
 *
 * La cuenta (email + contrasena) se crea una sola vez, al final del flujo
 * de enrolamiento con Array (ver Enroll::finish). Esta clase solo maneja el
 * inicio/cierre de sesion de cuentas que ya existen.
 */
class Auth extends BaseController
{
    public function login(string $language = ''): string
    {
        $idioma          = $language === 'es' ? 'es' : '';
        $es              = $idioma === 'es';
        $MY_CURRENT_PATH = $this->currentBaseUrl();
        $title_page      = $es ? 'Iniciar sesion | Safe Credit Score' : 'Log in | Safe Credit Score';

        require APPPATH . 'Views/site/partials/traduccion.php';

        if (strtoupper($this->request->getMethod()) === 'POST') {
            return $this->attemptLogin($es, get_defined_vars());
        }

        return view('auth/login', array_merge(get_defined_vars(), [
            'errors' => session()->getFlashdata('errors') ?? [],
            'old'    => session()->getFlashdata('old') ?? [],
        ]));
    }

    /**
     * @param array<string,mixed> $viewData Contexto de plantilla ya resuelto (idioma, rutas, etc.)
     */
    private function attemptLogin(bool $es, array $viewData): string|RedirectResponse
    {
        $email    = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $errors = [];
        if ($email === '' || $password === '') {
            $errors[] = $es
                ? 'Ingresa tu correo y tu contrasena.'
                : 'Enter your email and password.';
        }

        $user = null;
        if ($errors === []) {
            $userModel = new UserModel();
            $user      = $userModel->findByEmail($email);

            if ($user === null || ! $userModel->verifyPassword($user, $password)) {
                $errors[] = $es
                    ? 'Correo o contrasena incorrectos.'
                    : 'Incorrect email or password.';
            } elseif ($user['status'] !== 'active') {
                $errors[] = $es
                    ? 'Tu cuenta esta suspendida. Contacta a soporte.'
                    : 'Your account is suspended. Please contact support.';
            }
        }

        if ($errors !== []) {
            session()->setFlashdata('errors', $errors);
            session()->setFlashdata('old', ['email' => $email]);

            return view('auth/login', array_merge($viewData, [
                'errors' => $errors,
                'old'    => ['email' => $email],
            ]));
        }

        /** @var array<string,mixed> $user */
        (new UserModel())->touchLastLogin((int) $user['id']);

        session()->regenerate();
        session()->set([
            'user_id'    => (int) $user['id'],
            'user_name'  => $user['full_name'],
            'user_email' => $user['email'],
        ]);

        $redirectTo = session()->get('redirect_after_login');
        session()->remove('redirect_after_login');

        if (is_string($redirectTo) && $redirectTo !== '') {
            return redirect()->to(base_url(ltrim($redirectTo, '/')));
        }

        return redirect()->to(base_url($es ? 'es/portal' : 'portal'));
    }

    public function logout(): RedirectResponse
    {
        $uri = trim((string) $this->request->getUri()->getPath(), '/');
        $es  = str_starts_with($uri, 'es/') || $uri === 'es';

        session()->destroy();

        return redirect()->to(base_url($es ? 'es/' : ''));
    }

    private function currentBaseUrl(): string
    {
        $https      = (string) $this->request->getServer('HTTPS');
        $scheme     = $https !== '' && strtolower($https) !== 'off' ? 'https' : 'http';
        $host       = (string) ($this->request->getServer('HTTP_HOST') ?: $this->request->getServer('SERVER_NAME'));
        $scriptName = str_replace('\\', '/', (string) $this->request->getServer('SCRIPT_NAME'));
        $basePath   = rtrim(str_replace('/index.php', '', $scriptName), '/');

        return $scheme . '://' . $host . $basePath . '/';
    }
}
