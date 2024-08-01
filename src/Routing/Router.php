<?php

namespace App\Routing;

use App\Routing\Exception\RouteNotFoundException;
use Twig\Environment;

class Router
{
    private array $routes = [];

    public function __construct(private Environment $twig)
    {
    }

    public function addRoute(
        string $name,
        string $url,
        string $httpMethod,
        string $controllerClass,
        string $controllerMethod
    ): self {
        $this->routes[] = [
            'name'       => $name,
            'uri'        => $url,
            'httpMethod' => $httpMethod,
            'controller' => $controllerClass,
            'method'     => $controllerMethod
        ];

        return $this;
    }

    public function getRoute(string $uri, string $httpMethod): ?array
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['httpMethod'] === $httpMethod) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Executes the router against the current request URI and method
     *
     * @param string $uri URI
     * @param string $httpMethod HTTP Method
     * @throws RouteNotFoundException if no route was found
     * @return void
     */
    public function execute(string $uri, string $httpMethod): string
    {
        $route = $this->getRoute($uri, $httpMethod);

        if ($route === null) {
            throw new RouteNotFoundException();
        }

        $controllerClass = $route['controller'];
        $method = $route['method'];

        $controller = new $controllerClass($this->twig);
        return $controller->$method();
    }
}
