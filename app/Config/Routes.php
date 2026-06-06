<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->options('api/contact', static function () {
    return service('response')->setStatusCode(200);
});

$routes->post('api/contact', 'ContactController::store');
$routes->get('test', function () {
    return 'Route Working';
    
});
$routes->options('api/consultation', static function () {
    return service('response')->setStatusCode(200);
});
$routes->post('api/consultation', 'ConsultationController::store');
$routes->options('api/service-enquiry', static function () {
    return service('response')->setStatusCode(200);
});
$routes->post('api/service-enquiry', 'ServiceEnquiryController::store');