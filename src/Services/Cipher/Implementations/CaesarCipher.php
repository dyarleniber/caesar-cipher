<?php

namespace CaesarCipher\Services\Cipher\Implementations;

use CaesarCipher\Services\Cipher\Interfaces\ICipher;
use CaesarCipher\Services\Service;

class CaesarCipher extends Service implements ICipher
{
    protected $shift;

    public function setShift(string $shift)
    {
        $this->shift = $shift;
    }

    protected function calculateCipher(string $text): string
    {
        if (!ctype_alpha($text)) {
            return $text;
        }

        $offset = ord(ctype_upper($text) ? 'A' : 'a');
        return chr(fmod(((ord($text) + $this->shift) - $offset), 26) + $offset);
    }

    public function encipher(string $input): string
    {
        $output = '';

        $inputArr = str_split($input);
        foreach ($inputArr as $text) {
            $output .= $this->calculateCipher($text, $this->shift);
        }

        return $output;
    }

    public function decipher(string $input): string
    {
        return $this->encipher($input, 26 - $this->shift);
    }
}
