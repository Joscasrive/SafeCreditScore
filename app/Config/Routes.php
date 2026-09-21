<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Site::home');
$routes->get('contact-us', 'Site::contact');
$routes->get('credit-faq', 'Site::creditFaq');
$routes->get('member-faq', 'Site::memberFaq');
$routes->get('privacy-policy', 'Site::privacyPolicy');
$routes->get('terms-of-service', 'Site::termsOfService');

// Enrolamiento y reporte 3B (integracion Array.io)
$routes->get('enroll', 'Enroll::index');
$routes->post('enroll/save-token', 'Enroll::saveToken');
$routes->get('credit-report', 'Enroll::creditReport');

$routes->get('es', 'Site::home/es');
$routes->get('es/informacion-de-contacto', 'Site::contact/es');
$routes->get('es/faq-credito', 'Site::creditFaq/es');
$routes->get('es/faq-miembros', 'Site::memberFaq/es');
$routes->get('es/enroll', 'Enroll::index/es');
$routes->post('es/enroll/save-token', 'Enroll::saveToken');
$routes->get('es/credit-report', 'Enroll::creditReport/es');
