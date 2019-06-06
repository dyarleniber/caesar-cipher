<?php

namespace CaesarCipher\Controllers\CaesarCipherController;

use CaesarCipher\Actions\ChallengeFile;
use CaesarCipher\Actions\Cipher;
use CaesarCipher\Services\ChallengeApi;

class CaesarCipherController
{
    protected $cipher;
    protected $challengeFile;
    protected $challengeApi;

    public function __construct()
    {
        $this->cipher = new Cipher();
        $this->challengeFile = new ChallengeFile();
        $this->challengeApi = new ChallengeApi();
    }

    public function submitNewChallengeAnswer(): bool
    {
        try {
            $challengeResponseObj = $this->getChallengeParams();
            $challengeResponseObj->decifrado = $this->caesarDecipher($challengeResponseObj->cifrado, (int) $challengeResponseObj->numero_casas);
            $challengeResponseObj->resumo_criptografico = $this->calculateHash($challengeResponseObj->decifrado);

            $saveFileResult = $this->saveChallengeFile();
            if (!$saveFileResult) {
                return false;
            }

            $submitAnswer = $this->submitChallengeAnswer();
            if (!$submitAnswer) {
                return false;
            }
        } catch (\Throwable $t) {
            return false;
        }

        return true;
    }

    protected function getChallengeParams(): object
    {
        return $this->challengeApi->getParams();
    }

    protected function caesarDecipher(string $text, int $shift): string
    {
        return $this->cipher->Decipher($text, $shift);
    }

    protected function calculateHash(string $text): string
    {
        return sha1($text);
    }

    protected function saveChallengeFile(): bool
    {
        return $this->challengeFile->save();
    }

    protected function submitChallengeAnswer(): bool
    {
        return $this->challengeApi->submitAnswer();
    }
}
