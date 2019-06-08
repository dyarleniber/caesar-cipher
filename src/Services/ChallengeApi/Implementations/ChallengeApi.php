<?php

namespace CaesarCipher\Services\ChallengeApi\Implementations;

use CaesarCipher\Services\ChallengeApi\Interfaces\IChallengeApi;

class ChallengeApi implements IChallengeApi
{
    protected $httpClient;
    protected $uploadFilesPath;
    protected $challengeFileName;

    public function __construct(string $uploadFilesPath, string $challengeFileName)
    {
        $this->httpClient = new \GuzzleHttp\Client(['base_uri' => getenv('CHALLENGE_BASE_URI')]);

        $this->uploadFilesPath = $uploadFilesPath;
        $this->challengeFileName = $challengeFileName;
    }

    public function getParams(): object
    {
        $httpResponse = $this->httpClient->request('GET', getenv('CHALLENGE_GENERATE_URL') . getenv('CHALLENGE_TOKEN'));
        $httpResponseBody = $httpResponse->getBody();

        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Response: ' . $httpResponseBody);

        return json_decode($httpResponseBody);
    }

    public function submitAnswer(): bool
    {
        $httpResponse = $this->httpClient->request('POST', getenv('CHALLENGE_SUBMIT_URL') . getenv('CHALLENGE_TOKEN'), [
            'multipart' => [
                [
                    'name' => 'answer',
                    'contents' => fopen($this->uploadFilesPath . $this->challengeFileName, 'r'),
                    'filename' => $this->challengeFileName,
                ],
            ],
        ]);
        $httpResponseBody = $httpResponse->getBody();

        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Response: ' . $httpResponseBody);

        return true;
    }
}
