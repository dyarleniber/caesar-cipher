<?php

namespace CaesarCipher\Services\ChallengeApi\Mocks;

use CaesarCipher\Services\ChallengeApi\Interfaces\IChallengeApi;

class ChallengeApi implements IChallengeApi
{
    public function getParams(): object
    {
        $httpResponseBody = '
            {
                "numero_casas": 12,
                "token": "",
                "cifrado": "ur kagd bmdqzfe zqhqd tmp otuxpdqz, otmzoqe mdq kag iaz’f, quftqd. puow omhqff",
                "decifrado": "",
                "resumo_criptografico": ""
            }
        ';

        return json_decode($httpResponseBody);
    }

    public function submitAnswer(): bool
    {
        return true;
    }
}
