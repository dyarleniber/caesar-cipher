<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

function Cipher($ch, $key)
{
	if (!ctype_alpha($ch))
		return $ch;

	$offset = ord(ctype_upper($ch) ? 'A' : 'a');
	return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
}

function Encipher($input, $key)
{
	$output = "";

	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
		$output .= Cipher($ch, $key);

	return $output;
}

function Decipher($input, $key)
{
	return Encipher($input, 26 - $key);
}
return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {

        $httpClient = new GuzzleHttp\Client(['base_uri' => getenv('CHALLENGE_BASE_URI')]);
        
        $httpResponse = $httpClient->request('GET', getenv('CHALLENGE_GENERATE_URL') . getenv('CHALLENGE_TOKEN'));
        $httpResponseBody = $httpResponse->getBody();

        $baseUploadFiles = __DIR__ . '/../tmp/uploads/';
        $fileName = 'answer.json';
  
        $objResponse = json_decode($httpResponseBody);

        $formattedResponse = json_encode($objResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents($baseUploadFiles . $fileName, $formattedResponse);

        $objResponse->decifrado = Decipher($objResponse->cifrado, $objResponse->numero_casas);

        $formattedResponse = json_encode($objResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents($baseUploadFiles . $fileName, $formattedResponse);

        $objResponse->resumo_criptografico = sha1($objResponse->decifrado);

        $formattedResponse = json_encode($objResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents($baseUploadFiles . $fileName, $formattedResponse);

        $httpResponse = $httpClient->request('POST', getenv('CHALLENGE_SUBMIT_URL') . getenv('CHALLENGE_TOKEN'), [
            'multipart' => [
                [
                    'name'     => 'answer',
                    'contents' => fopen($baseUploadFiles . $fileName, 'r'),
                    'filename' => $fileName
                ],
            ]
        ]);
        $httpResponseBody = $httpResponse->getBody();

        $objResponse = json_decode($httpResponseBody);

        return $response->withJson($objResponse, 200);
    });
};
