<?php

namespace CaesarCipher\Services\Implementations;

use CaesarCipher\Services\Interfaces\ICipher;

class CaesarCipher extends Service implements ICipher
{
    protected $shift;

    public function __construct(string $shift)
    {
        parent::__construct();

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
