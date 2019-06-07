<?php

namespace CaesarCipher\Services\Interfaces;

use CaesarCipher\Services\Service;

interface IChallengeFile extends Service
{
    public function save(object $fileContent): bool;
}
