<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        //$container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        //return $container->get('renderer')->render($response, 'index.phtml', $args);

        $httpClient = new GuzzleHttp\Client(['base_uri' => getenv('CHALLENGE_BASE_URI')]);
        $httpResponse = $httpClient->request('GET', getenv('CHALLENGE_GENERATE_URL') . getenv('CHALLENGE_TOKEN'));
        $httpResponseBody = $httpResponse->getBody();

        $baseUploadFiles = __DIR__ . '/../tmp/uploads/';
        $fileName = 'answer.json';
  




// Open the file to get existing content
//$current = file_get_contents($file);
// Append a new person to the file
//$current .= "John Smith\n";
// Write the contents back to the file
file_put_contents($baseUploadFiles . $fileName, $httpResponseBody);

        $responseArr = json_decode($httpResponseBody, true);

        return $response->withJson($responseArr, 200);
    });
};
