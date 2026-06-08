<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

// ── Contact ──
$routes->options('api/contact', static function () {
    return service('response')->setStatusCode(200);
});
$routes->post('api/contact', 'ContactController::store');

// ── Consultation ──
$routes->options('api/consultation', static function () {
    return service('response')->setStatusCode(200);
});
$routes->post('api/consultation', 'ConsultationController::store');

// ── Service Enquiry ──
$routes->options('api/service-enquiry', static function () {
    return service('response')->setStatusCode(200);
});
$routes->post('api/service-enquiry', 'ServiceEnquiryController::store');

// ── Admin Login ──
$routes->options('api/admin/login', static function () {
    return service('response')->setStatusCode(200);
});
$routes->post('api/admin/login', 'Admin\AuthController::login');

// ── Partners ──
$routes->options('api/partners', static function () {
    return service('response')->setStatusCode(200);
});
$routes->options('api/partners/(:num)', static function () {
    return service('response')->setStatusCode(200);
});
$routes->get('api/partners',             'Admin\PartnerController::index');
$routes->post('api/partners',            'Admin\PartnerController::store');
$routes->delete('api/partners/(:num)',   'Admin\PartnerController::delete/$1');

// ── Team ──
$routes->options('api/team', static function () {
    return service('response')->setStatusCode(200);
});
$routes->options('api/team/(:num)', static function () {
    return service('response')->setStatusCode(200);
});
$routes->get('api/team',             'Admin\TeamController::index');
$routes->post('api/team',            'Admin\TeamController::create');
$routes->put('api/team/(:num)',      'Admin\TeamController::update/$1');
$routes->delete('api/team/(:num)',   'Admin\TeamController::delete/$1');
$routes->get('api/team/(:num)',      'Admin\TeamController::show/$1');