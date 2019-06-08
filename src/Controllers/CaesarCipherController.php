<?php

namespace CaesarCipher\Controllers;

use CaesarCipher\Services\ChallengeApi\Interfaces\IChallengeApi;
use CaesarCipher\Services\ChallengeFile\Interfaces\IChallengeFile;
use CaesarCipher\Services\Cipher\Interfaces\ICipher;

class CaesarCipherController extends BaseController
{
    protected $cipher;
    protected $challengeFile;
    protected $challengeApi;

    public function __construct(ICipher $cipher, IChallengeFile $challengeFile, IChallengeApi $challengeApi)
    {
        $this->cipher = $cipher;
        $this->challengeFile = $challengeFile;
        $this->challengeApi = $challengeApi;
    }

    protected function calculateHash(string $text): string
    {
        return sha1($text);
    }

    public function submitNewChallengeAnswer(): bool
    {
        try {
            $challengeResponseObj = $this->challengeApi->getParams();

            $this->cipher->setShift((int) $challengeResponseObj->numero_casas);

            $challengeResponseObj->decifrado = $this->cipher->decipher($challengeResponseObj->cifrado);
            $challengeResponseObj->resumo_criptografico = $this->calculateHash($challengeResponseObj->decifrado);

            $saveFileResult = $this->challengeFile->save($challengeResponseObj);
            if (!$saveFileResult) {
                return false;
            }

            $submitAnswer = $this->challengeApi->submitAnswer();
            if (!$submitAnswer) {
                return false;
            }
        } catch (\Throwable $t) {
            return false;
        }

        return true;
    }
}
