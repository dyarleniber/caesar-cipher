<?php

namespace CaesarCipher\Services\ChallengeFile\Interfaces;

use CaesarCipher\Services\Service;

interface IChallengeFile extends Service
{
    public function save(object $fileContent): bool;

    public function get(): string;

    public function exists(): bool;
}
