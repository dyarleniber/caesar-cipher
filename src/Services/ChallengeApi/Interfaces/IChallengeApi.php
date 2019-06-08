<?php

namespace CaesarCipher\Services\ChallengeApi\Interfaces;

use CaesarCipher\Services\Service;

interface IChallengeApi extends Service
{
    public function getParams(): object;

    public function submitAnswer(): bool;
}
