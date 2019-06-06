<?php
return [
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERROR_DETAILS'), // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => getenv('APP_NAME'),
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Challenge file
        'uploadFilesPath' => __DIR__ . '/../tmp/uploads/',
        'challengeFileName' => 'answer.json',
    ],
];
