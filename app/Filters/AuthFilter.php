<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Protege las rutas del portal de miembros: exige una sesion local activa
 * (creada por Auth::login o al finalizar el enrolamiento en Enroll::finish).
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('url');

        if (session('user_id')) {
            return;
        }

        $uri = trim((string) $request->getUri()->getPath(), '/');
        $es  = str_starts_with($uri, 'es/') || $uri === 'es';

        session()->setFlashdata(
            'auth_error',
            $es ? 'Debes iniciar sesion para ver tu portal.' : 'Please log in to view your portal.'
        );
        session()->set('redirect_after_login', '/' . $uri);

        return redirect()->to(base_url($es ? 'es/member-login' : 'member-login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada que hacer despues de la respuesta.
    }
}
