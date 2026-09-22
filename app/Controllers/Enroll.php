<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Config\ArrayIo;

/**
 * Flujo de enrolamiento con Array.io (KBA) y creacion de la cuenta local
 * del portal de miembros.
 *
 * Orden del flujo (definido por el propio copy del sitio en member_faq /
 * credit_faq: "una vez completado el enrolamiento seras dirigido
 * automaticamente al portal... recibiras un correo con tus credenciales"):
 *
 *   1. index()     -> muestra el componente array-account-enroll (KBA).
 *   2. saveToken() -> recibe userId/userToken del evento "success" y los
 *                     deja en sesion de forma temporal (pendientes de cuenta).
 *   3. finish()    -> el cliente crea su nombre/correo/contrasena; con eso
 *                     se crea su fila en `users` ligada al array_user_id.
 *                     A partir de aqui puede volver a entrar por Auth::login.
 */
class Enroll extends BaseController
{
    /**
     * Paso 1: muestra el componente de enrolamiento (array-account-enroll)
     * dentro del diseno del sitio.
     */
    public function index(string $language = ''): string
    {
        /** @var ArrayIo $config */
        $config = config('ArrayIo');
        $base   = $this->currentBaseUrl();

        return $this->renderComponent('enroll', $language, [
            'en' => 'Sign up | Safe Credit Score',
            'es' => 'Registro | Safe Credit Score',
        ], [
            'appKey'       => $config->appKey,
            'embedUrl'     => $config->embedUrl,
            'sandbox'      => $config->sandbox ? 'true' : 'false',
            'saveTokenUrl' => $base . ($language === 'es' ? 'es/' : '') . 'enroll/save-token',
            'finishUrl'    => $base . ($language === 'es' ? 'es/' : '') . 'enroll/finish',
        ]);
    }

    /**
     * Paso 2: recibe el userId y userToken emitidos por el componente tras
     * un evento "success" y los deja en sesion, pendientes de que el
     * cliente cree su cuenta local en finish(). Responde JSON.
     */
    public function saveToken(): ResponseInterface
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response
                ->setStatusCode(405)
                ->setJSON(['success' => false, 'message' => 'Metodo no permitido. Usa POST.']);
        }

        try {
            $payload   = $this->request->getJSON(true);
            $userToken = '';
            $userId    = '';

            if (is_array($payload)) {
                $userToken = (string) ($payload['user_token'] ?? '');
                $userId    = (string) ($payload['user_id'] ?? '');
            } else {
                $userToken = (string) ($this->request->getPost('user_token') ?? '');
                $userId    = (string) ($this->request->getPost('user_id') ?? '');
            }

            $userToken = trim($userToken);
            $userId    = trim($userId);

            if ($userToken === '' || $userId === '') {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => 'Falta user_token o user_id.']);
            }

            // Guardamos solo en sesion: son datos temporales hasta que el
            // cliente complete finish() y quede persistido en la tabla users.
            session()->set([
                'pending_array_user_id'    => $userId,
                'pending_array_user_token' => $userToken,
            ]);

            $uri = trim((string) $this->request->getUri()->getPath(), '/');
            $es  = str_starts_with($uri, 'es/');

            return $this->response->setJSON([
                'success'  => true,
                'redirect' => $this->currentBaseUrl() . ($es ? 'es/enroll/finish' : 'enroll/finish'),
            ]);
        } catch (\Throwable $e) {
            // Nunca dejamos que un error no controlado devuelva HTML: el
            // fetch() del front-end espera JSON siempre, incluso al fallar.
            log_message('error', 'Enroll::saveToken fallo: {msg}', ['msg' => $e->getMessage()]);

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'No se pudo guardar tu sesion en el servidor.',
                    'detail'  => ENVIRONMENT !== 'production' ? $e->getMessage() : null,
                ]);
        }
    }

    /**
     * Paso 3: el cliente crea su contrasena y con ella su cuenta local,
     * ligada al array_user_id que acaba de generar Array. Si ese
     * array_user_id ya tenia una cuenta (re-enrolamiento), simplemente lo
     * autenticamos en lugar de duplicar el registro.
     */
    public function finish(string $language = ''): string|RedirectResponse
    {
        $idioma          = $language === 'es' ? 'es' : '';
        $es              = $idioma === 'es';
        $MY_CURRENT_PATH = $this->currentBaseUrl();
        $title_page      = $es ? 'Crea tu contrasena | Safe Credit Score' : 'Create your password | Safe Credit Score';

        require APPPATH . 'Views/site/partials/traduccion.php';

        $arrayUserId = (string) session('pending_array_user_id');

        if ($arrayUserId === '') {
            return redirect()->to(base_url($es ? 'es/enroll' : 'enroll'));
        }

        $userModel = new UserModel();
        $existing  = $userModel->findByArrayUserId($arrayUserId);

        // Re-enrolamiento de alguien que ya tenia cuenta: lo dejamos pasar
        // directo a su portal sin pedirle que vuelva a crear contrasena.
        if ($existing !== null) {
            session()->remove(['pending_array_user_id', 'pending_array_user_token']);
            session()->regenerate();
            session()->set([
                'user_id'    => (int) $existing['id'],
                'user_name'  => $existing['full_name'],
                'user_email' => $existing['email'],
            ]);
            $userModel->touchLastLogin((int) $existing['id']);

            return redirect()->to(base_url($es ? 'es/portal' : 'portal'));
        }

        if (strtoupper($this->request->getMethod()) === 'POST') {
            return $this->createAccount($es, $arrayUserId, get_defined_vars());
        }

        return view('site/pages/enroll_finish', array_merge(get_defined_vars(), [
            'errors' => session()->getFlashdata('errors') ?? [],
            'old'    => session()->getFlashdata('old') ?? [],
        ]));
    }

    /**
     * @param array<string,mixed> $viewData
     */
    private function createAccount(bool $es, string $arrayUserId, array $viewData): string|RedirectResponse
    {
        $fullName        = trim((string) $this->request->getPost('full_name'));
        $email           = trim((string) $this->request->getPost('email'));
        $password        = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        $errors = [];
        if ($fullName === '' || mb_strlen($fullName) < 2) {
            $errors[] = $es ? 'Ingresa tu nombre completo.' : 'Enter your full name.';
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = $es ? 'Ingresa un correo valido.' : 'Enter a valid email address.';
        }
        if (mb_strlen($password) < 8) {
            $errors[] = $es
                ? 'La contrasena debe tener al menos 8 caracteres.'
                : 'Password must be at least 8 characters.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = $es ? 'Las contrasenas no coinciden.' : 'Passwords do not match.';
        }

        $userModel = new UserModel();
        if ($errors === [] && $userModel->findByEmail($email) !== null) {
            $errors[] = $es
                ? 'Ya existe una cuenta con ese correo. Inicia sesion en su lugar.'
                : 'An account with that email already exists. Please log in instead.';
        }

        if ($errors !== []) {
            session()->setFlashdata('errors', $errors);
            session()->setFlashdata('old', ['full_name' => $fullName, 'email' => $email]);

            return view('site/pages/enroll_finish', array_merge($viewData, [
                'errors' => $errors,
                'old'    => ['full_name' => $fullName, 'email' => $email],
            ]));
        }

        $userId = $userModel->createWithPassword([
            'full_name'         => $fullName,
            'email'             => $email,
            'password'          => $password,
            'array_user_id'     => $arrayUserId,
            'array_enrolled_at' => date('Y-m-d H:i:s'),
            'status'            => 'active',
        ]);

        if ($userId === false) {
            session()->setFlashdata('errors', [
                $es ? 'No se pudo crear tu cuenta. Intenta de nuevo.' : 'Could not create your account. Please try again.',
            ]);

            return view('site/pages/enroll_finish', array_merge($viewData, [
                'errors' => session()->getFlashdata('errors'),
                'old'    => ['full_name' => $fullName, 'email' => $email],
            ]));
        }

        session()->remove(['pending_array_user_id', 'pending_array_user_token']);
        session()->regenerate();
        session()->set([
            'user_id'    => $userId,
            'user_name'  => $fullName,
            'user_email' => $email,
        ]);

        return redirect()->to(base_url($es ? 'es/portal' : 'portal'));
    }

    /**
     * Prepara el contexto del sitio (traducciones, ruta base, titulo) igual que
     * Site::renderPage y renderiza la vista con los datos del componente.
     *
     * @param array<string,string> $titles
     * @param array<string,mixed>  $extra
     */
    private function renderComponent(string $view, string $language, array $titles, array $extra = []): string
    {
        $idioma          = $language === 'es' ? 'es' : '';
        $MY_CURRENT_PATH = $this->currentBaseUrl();
        $title_page      = $titles[$idioma === 'es' ? 'es' : 'en'];

        require APPPATH . 'Views/site/partials/traduccion.php';

        $data = array_merge(get_defined_vars(), $extra);
        unset($data['view'], $data['language'], $data['titles'], $data['extra'], $data['data']);

        return view('site/pages/' . $view, $data);
    }

    private function currentBaseUrl(): string
    {
        $https  = (string) $this->request->getServer('HTTPS');
        $scheme = $https !== '' && strtolower($https) !== 'off' ? 'https' : 'http';
        $host   = (string) ($this->request->getServer('HTTP_HOST') ?: $this->request->getServer('SERVER_NAME'));
        $scriptName = str_replace('\\', '/', (string) $this->request->getServer('SCRIPT_NAME'));
        $basePath   = rtrim(str_replace('/index.php', '', $scriptName), '/');

        return $scheme . '://' . $host . $basePath . '/';
    }
}
