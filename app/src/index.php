<?php

use App\Lib\Http\Request;
use App\Lib\Http\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$request = new Request();

$router = new Router();

$response = $router->route($request);

header($response->getHeadersAsString());
http_response_code($response->getStatus());
echo $response->getContent();
exit();