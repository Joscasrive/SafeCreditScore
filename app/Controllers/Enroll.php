<?php

namespace App\Controllers;

use App\Libraries\ArrayApi;
use CodeIgniter\HTTP\ResponseInterface;
use Config\ArrayIo;
use Throwable;

/**
 * Flujo de enrolamiento y visualizacion del reporte 3B usando Array.io.
 */
class Enroll extends BaseController
{
    /**
     * Nombre del archivo donde se persiste el ultimo token de usuario.
     */
    private function storePath(): string
    {
        return WRITEPATH . 'array_user_tokens.json';
    }

    /**
     * Paso 1: muestra el componente de enrolamiento (array-account-enroll)
     * dentro del diseno del sitio.
     */
    public function index(string $language = ''): string
    {
        /** @var ArrayIo $config */
        $config = config('ArrayIo');

        return $this->renderComponent('enroll', $language, [
            'en' => 'Sign up | Safe Credit Score',
            'es' => 'Registro | Safe Credit Score',
        ], [
            'appKey'       => $config->appKey,
            'embedUrl'     => $config->embedUrl,
            'sandbox'      => $config->sandbox ? 'true' : 'false',
            'saveTokenUrl' => base_url(($language === 'es' ? 'es/' : '') . 'enroll/save-token'),
            'reportUrl'    => base_url(($language === 'es' ? 'es/' : '') . 'credit-report'),
        ]);
    }

    /**
     * Paso 2: recibe el userId y userToken emitidos por el componente y los
     * persiste. Responde JSON (equivalente al save_token.php original).
     */
    public function saveToken(): ResponseInterface
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response
                ->setStatusCode(405)
                ->setJSON(['success' => false, 'message' => 'Metodo no permitido. Usa POST.']);
        }

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

        if ($userToken === '') {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'Falta user_token.']);
        }

        $record = [
            'user_id'    => $userId,
            'user_token' => $userToken,
            'updated_at' => date('c'),
            'created_at' => date('c'),
        ];

        $existing = $this->readStore();
        if ($existing !== null && ($existing['created_at'] ?? '') !== '') {
            $record['created_at'] = (string) $existing['created_at'];
            $action               = 'updated';
        } else {
            $action = 'created';
        }

        if (file_put_contents($this->storePath(), json_encode($record, JSON_PRETTY_PRINT)) === false) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['success' => false, 'message' => 'No se pudo guardar el token.']);
        }

        // Guardar tambien en sesion para la pagina de reporte.
        session()->set([
            'array_user_id'    => $userId,
            'array_user_token' => $userToken,
        ]);

        return $this->response->setJSON([
            'success'  => true,
            'action'   => $action,
            'redirect' => base_url('credit-report'),
        ]);
    }

    /**
     * Paso 3: renueva el userToken en el servidor y muestra el reporte 3B
     * (array-credit-report) dentro del diseno del sitio.
     */
    public function creditReport(string $language = ''): string
    {
        /** @var ArrayIo $config */
        $config = config('ArrayIo');

        $store  = $this->readStore();
        $userId = (string) (session('array_user_id') ?? $store['user_id'] ?? '');
        // Token por defecto: el emitido durante el enrolamiento.
        $userToken = (string) (session('array_user_token') ?? $store['user_token'] ?? '');
        $error     = '';

        // Si tenemos userId, renovamos el token en el servidor para asegurar
        // que sea valido al abrir el componente.
        if ($userId !== '') {
            try {
                $renewed = (new ArrayApi())->setUserId($userId)->renewUserTokenValue();
                if ($renewed !== '') {
                    $userToken = $renewed;
                }
            } catch (Throwable $e) {
                log_message('error', 'No se pudo renovar el userToken: {msg}', ['msg' => $e->getMessage()]);
                $error = $language === 'es'
                    ? 'No se pudo renovar la sesion. Mostrando el token de enrolamiento.'
                    : 'Could not refresh the session. Showing the enrollment token.';
            }
        }

        return $this->renderComponent('credit_report', $language, [
            'en' => 'Your credit report | Safe Credit Score',
            'es' => 'Tu reporte de credito | Safe Credit Score',
        ], [
            'appKey'          => $config->appKey,
            'embedUrl'        => $config->embedUrl,
            'componentApiUrl' => $config->componentApiUrl,
            'sandbox'         => $config->sandbox ? 'true' : 'false',
            'userToken'       => $userToken,
            'enrollUrl'       => base_url(($language === 'es' ? 'es/' : '') . 'enroll'),
            'error'           => $error,
        ]);
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

    /**
     * Lee el registro persistido de token, o null si no existe/valido.
     *
     * @return array<string,mixed>|null
     */
    private function readStore(): ?array
    {
        $path = $this->storePath();
        if (! is_file($path)) {
            return null;
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? $decoded : null;
    }
}
