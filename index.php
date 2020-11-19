<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;
use Source\Core\Session;

/**
 * BOOTSTRAP
 */

$session = new Session();
$route = new Router(url(), ":");

/**
 * Web ROUTES
 */
$route->namespace("Source\App");
$route->get('/', 'Web:home');

// Specialities
$route->get('/especialidade/{slug}', 'Specialities:index');
$route->get('/especialidades', 'Specialities:home');
$route->get('/especialidades/cadastrar', 'Specialities:register');
$route->post('/speciality/register', 'Specialities:register');

$route->get('/especialidades/{specialitySlug}/coberturas', 'Roofing:all');
$route->get('/especialidades/coberturas/{roofSlug}', 'Roofing:index');
$route->get('/especialidades/{specialitySlug}/coberturas/cadastrar', 'Roofing:create');
$route->post('/speciality/{specialitySlug}/roofing/create', 'Roofing:create');

$route->get('/especialidades/{specialitySlug}/atos-medicos', 'Doctors:all');
$route->get('/especialidades/{specialitySlug}/atos-medicos/cadastrar', 'Doctors:createSpeciality');
$route->get('/coberturas/{roofSlug}/atos-medicos/cadastrar', 'Doctors:createRoof');
$route->post('/speciality/{specialitySlug}/doctors/create', 'Doctors:createSpeciality');

$route->get('/especialidades/coberturas/{roofSlug}/atos-medicos', 'Doctors:allRoof');
$route->get('/especialidades/coberturas/{roofSlug}/atos-medicos/cadastrar', 'Doctors:createRoof');
$route->post('/speciality/roofing/{roofSlug}/doctors/create', 'Doctors:createRoof');



$route->get('/test/{id}', 'Specialities:test');

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errCode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
