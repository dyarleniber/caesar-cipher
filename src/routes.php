<?php

use CaesarCipher\Controllers\CaesarCipherController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        $submitResponse = (new CaesarCipherController())->submitChallengeAnswer();

        if (!$submitResponse) {
            return $response
                ->withJson(['message' => 'Internal Server Error'])
                ->withStatus(500);
        }

        return $response
            ->withJson(['message' => 'OK'])
            ->withStatus(200);
    });
};
