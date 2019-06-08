<?php

namespace CaesarCipher\Services\Interfaces;

use CaesarCipher\Services\Service;

interface ICipher extends Service
{
    public function encipher(string $input): string;

    public function decipher(string $input): string;
}
