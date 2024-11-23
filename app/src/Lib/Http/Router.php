<?php

namespace App\Lib\Http;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

class Router
{
    private $request;
    private $response;
    private $routes;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->routes = json_decode(file_get_contents(__DIR__ . '/../../../config/routes.json'), true);
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // Transform the route pattern to a regular expression
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route['uri']);
            $routePattern = '#^' . $routePattern . '$#';

            // Check if the URI and method match
            if (preg_match($routePattern, $uri, $matches) && $route['method'] === $method) {
                array_shift($matches); // Remove the full match from the matches array

                [$controller, $action] = explode('::', $route['controller']);
                $controller = "App\\Controllers\\$controller";

                // Instantiate the controller and call the action with parameters
                $instance = new $controller($this->request, $this->response);
                return call_user_func_array([$instance, $action], $matches);
            }
        }

        // Default response if no route matches
        $this->response->jsonResponse(['error' => 'Route not found'], 404);
    }



}
