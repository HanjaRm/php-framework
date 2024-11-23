<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

abstract class AbstractController
{
    public function __construct(protected Request $request, protected Response $response)
    {
    }
}
