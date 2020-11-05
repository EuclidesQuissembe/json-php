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
