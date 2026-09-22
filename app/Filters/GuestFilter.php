<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Evita que un usuario que ya tiene sesion local vuelva a ver el login o el
 * flujo de enrolamiento; lo manda directo a su portal.
 */
class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('url');

        if (! session('user_id')) {
            return;
        }

        $uri = trim((string) $request->getUri()->getPath(), '/');
        $es  = str_starts_with($uri, 'es/') || $uri === 'es';

        return redirect()->to(base_url($es ? 'es/portal' : 'portal'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada que hacer despues de la respuesta.
    }
}
