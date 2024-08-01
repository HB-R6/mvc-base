<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\IndexController;
use App\Routing\Exception\RouteNotFoundException;
use App\Routing\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Initialisation de Twig
$loader = new FilesystemLoader([__DIR__ . '/../templates/']);
$twig = new Environment($loader, ['debug' => true]);

// Instanciation du routeur
$router = new Router($twig);

// Enregistrement des routes applicatives
$router
->addRoute(
    'home',
    '/',
    'GET',
    IndexController::class,
    'home'
)->addRoute(
    'about',
    '/about',
    'GET',
    IndexController::class,
    'about'
);

// Exécution avec la requête entrante
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

try {
    echo $router->execute($requestUri, $requestMethod);
} catch (RouteNotFoundException $e) {
    http_response_code(response_code: 404);
    echo "Page non trouvée";
}
