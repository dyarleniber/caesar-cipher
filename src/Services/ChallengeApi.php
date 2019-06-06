<?php

namespace CaesarCipher\Services;

class ChallengeApi
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new GuzzleHttp\Client(['base_uri' => getenv('CHALLENGE_BASE_URI')]);
    }

    public function getParams(): object
    {
        $httpResponse = $this->httpClient->request('GET', getenv('CHALLENGE_GENERATE_URL') . getenv('CHALLENGE_TOKEN'));
        $httpResponseBody = $httpResponse->getBody();
        return json_decode($httpResponseBody);
    }

    public function submitAnswer(): bool
    {
        global $settings;

        $httpResponse = $this->httpClient->request('POST', getenv('CHALLENGE_SUBMIT_URL') . getenv('CHALLENGE_TOKEN'), [
            'multipart' => [
                [
                    'name' => 'answer',
                    'contents' => fopen($settings['uploadFilesPath'] . $settings['challengeFileName'], 'r'),
                    'filename' => $settings['challengeFileName'],
                ],
            ],
        ]);
        $httpResponseBody = $httpResponse->getBody();
        $httpResponseObj = json_decode($httpResponseBody);
        return true;
    }
}
