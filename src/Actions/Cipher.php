<?php

namespace CaesarCipher\Actions;

class Cipher
{
    protected function calculateCipher(string $text, int $shift): string
    {
        if (!ctype_alpha($text)) {
            return $text;
        }

        $offset = ord(ctype_upper($text) ? 'A' : 'a');
        return chr(fmod(((ord($text) + $shift) - $offset), 26) + $offset);
    }

    public function encipher(string $input, int $shift): string
    {
        $output = '';

        $inputArr = str_split($input);
        foreach ($inputArr as $text) {
            $output .= $this->calculateCipher($text, $shift);
        }

        return $output;
    }

    public function decipher(string $input, int $shift): string
    {
        return $this->encipher($input, 26 - $shift);
    }
}
