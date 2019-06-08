<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // DI configuration
    $isTest = getenv('TEST');
    if ($isTest !== false) {

        $container['CaesarCipherController'] = function ($c) {
            $caesarCipher = new \CaesarCipher\Services\Implementations\CaesarCipher();
            $challengeFile = new \CaesarCipher\Services\Implementations\ChallengeFile();
            $challengeApi = new \CaesarCipher\Services\Implementations\ChallengeApi();

            $controller = new \CaesarCipher\Controllers\CaesarCipherController(
                $caesarCipher,
                $challengeFile,
                $challengeApi
            );

            return $controller;
        };

    } else {

        $container['CaesarCipherController'] = function ($c) {
            $caesarCipher = new \CaesarCipher\Services\Implementations\CaesarCipher();
            $challengeFile = new \CaesarCipher\Services\Implementations\ChallengeFile();
            $challengeApi = new \CaesarCipher\Services\Mocks\ChallengeApi();

            $controller = new \CaesarCipher\Controllers\CaesarCipherController(
                $caesarCipher,
                $challengeFile,
                $challengeApi
            );

            return $controller;
        };

    }
};
