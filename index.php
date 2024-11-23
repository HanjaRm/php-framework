<?php

require __DIR__ . '/app/vendor/autoload.php';


use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Http\Router;

// Initialize router
$router = new Router(new Request(), new Response());
$router->run();
