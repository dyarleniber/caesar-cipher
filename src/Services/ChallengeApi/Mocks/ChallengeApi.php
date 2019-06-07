<?php

namespace CaesarCipher\Services\Mocks;

use CaesarCipher\Services\Interfaces\IChallengeApi;

class ChallengeApi extends Service implements IChallengeApi
{
    public function getParams(): object
    {
        $httpResponseBody = '';

        return json_decode($httpResponseBody);
    }

    public function submitAnswer(): bool
    {
        return true;
    }
}
