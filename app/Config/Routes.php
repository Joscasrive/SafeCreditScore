<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Site::home');
$routes->get('contact-us', 'Site::contact');
$routes->get('credit-faq', 'Site::creditFaq');
$routes->get('member-faq', 'Site::memberFaq');
$routes->get('privacy-policy', 'Site::privacyPolicy');
$routes->get('terms-of-service', 'Site::termsOfService');

// Enrolamiento con Array.io (KBA) - publico, no requiere sesion.
$routes->get('enroll', 'Enroll::index');
$routes->post('enroll/save-token', 'Enroll::saveToken');

// Paso final del enrolamiento: crea la cuenta local (email/contrasena).
$routes->match(['get', 'post'], 'enroll/finish', 'Enroll::finish');

// Login / logout del portal (filtro "guest" saca de aqui a quien ya tiene sesion).
$routes->match(['get', 'post'], 'member-login', 'Auth::login', ['filter' => 'guest']);
$routes->get('logout', 'Auth::logout');

// Redireccion de compatibilidad: la URL anterior del reporte ahora vive en /portal.
$routes->get('credit-report', static function () {
    helper('url');

    return redirect()->to(base_url('portal'));
});

// Portal de miembros - protegido, requiere sesion local (filtro "auth").
$routes->get('portal', 'Portal::dashboard', ['filter' => 'auth']);
$routes->get('portal/score-tracker', 'Portal::scoreTracker', ['filter' => 'auth']);
$routes->get('portal/debt-analysis', 'Portal::debtAnalysis', ['filter' => 'auth']);
$routes->get('portal/score-simulator', 'Portal::scoreSimulator', ['filter' => 'auth']);

// ---- Version en espanol ----
$routes->get('es', 'Site::home/es');
$routes->get('es/informacion-de-contacto', 'Site::contact/es');
$routes->get('es/faq-credito', 'Site::creditFaq/es');
$routes->get('es/faq-miembros', 'Site::memberFaq/es');
$routes->get('es/enroll', 'Enroll::index/es');
$routes->post('es/enroll/save-token', 'Enroll::saveToken');
$routes->match(['get', 'post'], 'es/enroll/finish', 'Enroll::finish/es');

$routes->match(['get', 'post'], 'es/member-login', 'Auth::login/es', ['filter' => 'guest']);
$routes->get('es/logout', 'Auth::logout');

$routes->get('es/credit-report', static function () {
    helper('url');

    return redirect()->to(base_url('es/portal'));
});

$routes->get('es/portal', 'Portal::dashboard/es', ['filter' => 'auth']);
$routes->get('es/portal/score-tracker', 'Portal::scoreTracker/es', ['filter' => 'auth']);
$routes->get('es/portal/debt-analysis', 'Portal::debtAnalysis/es', ['filter' => 'auth']);
$routes->get('es/portal/score-simulator', 'Portal::scoreSimulator/es', ['filter' => 'auth']);
