<?php

namespace App\Controllers;

class Site extends BaseController
{
    public function home(string $language = ''): string
    {
        return $this->renderPage('home', $language, [
            'en' => 'Safe Credit Score | Credit scores, credit monitoring and so much more.',
            'es' => 'Safe Credit Score | Puntuacion crediticia, seguimiento de credito y mucho mas.',
        ]);
    }

    public function contact(string $language = ''): string
    {
        return $this->renderPage('contact', $language, [
            'en' => 'Contact | Safe Credit Score',
            'es' => 'Informacion de contacto | Safe Credit Score',
        ]);
    }

    public function creditFaq(string $language = ''): string
    {
        return $this->renderPage('credit_faq', $language, [
            'en' => 'Credit FAQ | Safe Credit Score',
            'es' => 'Preguntas frecuentes | Safe Credit Score',
        ]);
    }

    public function memberFaq(string $language = ''): string
    {
        return $this->renderPage('member_faq', $language, [
            'en' => 'Member FAQ | Safe Credit Score',
            'es' => 'Preguntas frecuentes para miembros | Safe Credit Score',
        ]);
    }

    public function privacyPolicy(): string
    {
        return $this->renderPage('privacy_policy', '', [
            'en' => 'Privacy policy | Safe Credit Score',
        ]);
    }

    public function termsOfService(): string
    {
        return $this->renderPage('terms_of_service', '', [
            'en' => 'Terms of service | Safe Credit Score',
        ]);
    }

    private function renderPage(string $view, string $language, array $titles): string
    {
        $idioma = $language === 'es' ? 'es' : '';
        $MY_CURRENT_PATH = $this->currentBaseUrl();
        $title_page = $titles[$idioma === 'es' ? 'es' : 'en'];

        require APPPATH . 'Views/site/partials/traduccion.php';

        $data = get_defined_vars();
        unset($data['view'], $data['language'], $data['titles'], $data['data']);

        return view('site/pages/' . $view, $data);
    }

    private function currentBaseUrl(): string
    {
        $https = (string) $this->request->getServer('HTTPS');
        $scheme = $https !== '' && strtolower($https) !== 'off' ? 'https' : 'http';
        $host = (string) ($this->request->getServer('HTTP_HOST') ?: $this->request->getServer('SERVER_NAME'));
        $scriptName = str_replace('\\', '/', (string) $this->request->getServer('SCRIPT_NAME'));
        $basePath = rtrim(str_replace('/index.php', '', $scriptName), '/');

        return $scheme . '://' . $host . $basePath . '/';
    }
}
