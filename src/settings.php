<?php
return [
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERROR_DETAILS'), // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Challenge file
        'uploadFilesPath' => __DIR__ . '/../tmp/uploads/',
        'challengeFileName' => 'answer.json',
    ],
];
