<?php

namespace App\Controllers;

use App\Libraries\ArrayApi;
use App\Models\UserModel;
use Config\ArrayIo;
use Throwable;

/**
 * Portal de miembros (protegido por el filtro `auth`, ver app/Config/Routes.php).
 *
 * El userToken de Array nunca se guarda en la base de datos: expira a los
 * 60 minutos, asi que se renueva en cada visita usando el array_user_id
 * persistido en `users` (ver guia de Array: "Regenerate a UserToken").
 */
class Portal extends BaseController
{
    /**
     * Secciones del menu lateral. 'enabled' => false se muestra como
     * "proximamente" en vez de cargar el componente real de Array.
     *
     * @return array<string,array<string,mixed>>
     */
    private function tools(): array
    {
        return [
            'credit-report' => [
                'enabled' => true,
                'icon'    => 'fa-solid fa-file-invoice',
                'en'      => 'Credit Report (3B)',
                'es'      => 'Reporte de credito (3B)',
            ],
            'score-tracker' => [
                'enabled' => false,
                'icon'    => 'fa-solid fa-chart-line',
                'en'      => 'Score Tracker',
                'es'      => 'Rastreador de puntuacion',
            ],
            'debt-analysis' => [
                'enabled' => false,
                'icon'    => 'fa-solid fa-scale-balanced',
                'en'      => 'Debt Analysis',
                'es'      => 'Analisis de deuda',
            ],
            'score-simulator' => [
                'enabled' => false,
                'icon'    => 'fa-solid fa-sliders',
                'en'      => 'Score Simulator',
                'es'      => 'Simulador de puntuacion',
            ],
        ];
    }

    /**
     * Home del portal: renueva el userToken del cliente y muestra el
     * componente array-credit-report (3B).
     */
    public function dashboard(string $language = ''): string
    {
        /** @var ArrayIo $config */
        $config = config('ArrayIo');

        $user   = $this->currentUser();
        $error  = '';
        $userToken = '';

        if (! empty($user['array_user_id'])) {
            try {
                $userToken = (new ArrayApi())->setUserId($user['array_user_id'])->renewUserTokenValue();
            } catch (Throwable $e) {
                log_message('error', 'No se pudo renovar el userToken del portal: {msg}', ['msg' => $e->getMessage()]);
                $error = $language === 'es'
                    ? 'No se pudo conectar con tu reporte en este momento. Intenta de nuevo en unos minutos.'
                    : 'We could not connect to your report right now. Please try again in a few minutes.';
            }
        } else {
            $error = $language === 'es'
                ? 'Tu cuenta todavia no tiene una verificacion de identidad completa.'
                : 'Your account does not have a completed identity verification yet.';
        }

        return $this->renderPortalPage('dashboard', 'credit-report', $language, [
            'appKey'          => $config->appKey,
            'embedUrl'        => $config->embedUrl,
            'componentApiUrl' => $config->componentApiUrl,
            'sandbox'         => $config->sandbox ? 'true' : 'false',
            'userToken'       => $userToken,
            'error'           => $error,
        ]);
    }

    public function scoreTracker(string $language = ''): string
    {
        return $this->comingSoon('score-tracker', $language);
    }

    public function debtAnalysis(string $language = ''): string
    {
        return $this->comingSoon('debt-analysis', $language);
    }

    public function scoreSimulator(string $language = ''): string
    {
        return $this->comingSoon('score-simulator', $language);
    }

    private function comingSoon(string $tool, string $language = ''): string
    {
        return $this->renderPortalPage('coming_soon', $tool, $language, []);
    }

    /**
     * @param array<string,mixed> $extra
     */
    private function renderPortalPage(string $view, string $activeTool, string $language, array $extra): string
    {
        $idioma          = $language === 'es' ? 'es' : '';
        $es              = $idioma === 'es';
        $MY_CURRENT_PATH = $this->currentBaseUrl();
        $tools           = $this->tools();
        $activeToolData  = $tools[$activeTool] ?? reset($tools);
        $title_page      = ($activeToolData[$idioma === 'es' ? 'es' : 'en'] ?? 'Portal') . ' | Safe Credit Score';
        $user            = $this->currentUser();

        $data = array_merge(compact(
            'idioma',
            'es',
            'MY_CURRENT_PATH',
            'tools',
            'activeTool',
            'title_page',
            'user'
        ), $extra);

        return view('portal/pages/' . $view, $data);
    }

    /**
     * @return array<string,mixed>
     */
    private function currentUser(): array
    {
        $userModel = new UserModel();
        $user      = $userModel->find((int) session('user_id'));

        return $user ?? [];
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
