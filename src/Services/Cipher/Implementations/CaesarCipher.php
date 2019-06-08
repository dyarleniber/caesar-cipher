<?php

namespace CaesarCipher\Services\Cipher\Implementations;

use CaesarCipher\Services\Cipher\Interfaces\ICipher;

class CaesarCipher implements ICipher
{
    protected $shift;

    public function setShift(int $shift)
    {
        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Shift: ' . $shift);

        $this->shift = abs($shift);
    }

    protected function calculateCipher(string $text, int $shift): string
    {
        if (!ctype_alpha($text)) {
            return $text;
        }

        $offset = ord(ctype_upper($text) ? 'A' : 'a');
        return chr(fmod(((ord($text) + $shift) - $offset), 26) + $offset);
    }

    public function encipher(string $input): string
    {
        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Input: ' . $input);

        $output = '';

        $inputArr = str_split($input);
        foreach ($inputArr as $text) {
            $output .= $this->calculateCipher(strtolower($text), $this->shift);
        }

        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Output: ' . $output);

        return $output;
    }

    public function decipher(string $input): string
    {
        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Input: ' . $input);

        $output = '';

        $inputArr = str_split($input);
        foreach ($inputArr as $text) {
            $output .= $this->calculateCipher(strtolower($text), 26 - $this->shift);
        }

        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Output: ' . $output);

        return $output;
    }
}
