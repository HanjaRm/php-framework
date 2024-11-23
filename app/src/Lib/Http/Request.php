<?php

namespace App\Lib\Http;

class Request
{
    public function getBody()
    {
        return file_get_contents('php://input');
    }

    public function getHeader($header)
    {
        $headers = getallheaders();
        return $headers[$header] ?? null;
    }
}
