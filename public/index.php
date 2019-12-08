<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__.'/../src/container.php';
$routes = include __DIR__.'/../src/app.php';
$container->setParameter('routes', $routes);

$request = Request::createFromGlobals();

$response = $container->get('framework')->handle($request);

$response->send();
