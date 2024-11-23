<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;
use App\Managers\ArtistManager;

class GetArtistsController extends AbstractController {


    public function process(Request $request): Response {
        $artistManager = new ArtistManager();
        $artists = $artistManager->findAll();
        return new Response(json_encode($artists), 200, ['Content-Type' => 'application/json']);
    }
}