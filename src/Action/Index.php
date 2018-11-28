<?php

namespace App\Action;

use Symfony\Component\HttpFoundation\Response;

class Index{

    public function __invoke()
    {
        $response = ['api' => 'available'];

        return new Response(json_encode($response), Response::HTTP_OK);
    }
}