<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // DI configuration
    $isTest = getenv('TEST');
    if ($isTest === false) {

        $container['caesarCipherController'] = function ($c) {
            $uploadFilesPath = $c->get('settings')['uploadFilesPath'];
            $challengeFileName = $c->get('settings')['challengeFileName'];

            $caesarCipher = new CaesarCipher\Services\Cipher\Implementations\CaesarCipher();
            $challengeFile = new CaesarCipher\Services\ChallengeFile\Implementations\ChallengeFile(
                $uploadFilesPath,
                $challengeFileName
            );
            $challengeApi = new CaesarCipher\Services\ChallengeApi\Implementations\ChallengeApi(
                $uploadFilesPath,
                $challengeFileName
            );

            $controller = new CaesarCipher\Controllers\CaesarCipherController(
                $caesarCipher,
                $challengeFile,
                $challengeApi
            );

            return $controller;
        };

    } else {

        $container['caesarCipherController'] = function ($c) {
            $uploadFilesPath = $c->get('settings')['uploadFilesPath'];
            $challengeFileName = $c->get('settings')['challengeFileName'];

            $caesarCipher = new CaesarCipher\Services\Cipher\Implementations\CaesarCipher();
            $challengeFile = new CaesarCipher\Services\ChallengeFile\Implementations\ChallengeFile(
                $uploadFilesPath,
                $challengeFileName
            );
            $challengeApi = new CaesarCipher\Services\ChallengeApi\Mocks\ChallengeApi();

            $controller = new CaesarCipher\Controllers\CaesarCipherController(
                $caesarCipher,
                $challengeFile,
                $challengeApi
            );

            return $controller;
        };

    }
};
