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
                \CaesarCipher\Log\Logger::error('Save challenge file error');
                return false;
            }

            $submitAnswer = $this->challengeApi->submitAnswer();
            if (!$submitAnswer) {
                \CaesarCipher\Log\Logger::error('Submit challenge answer error');
                return false;
            }
        } catch (\Throwable $t) {
            \CaesarCipher\Log\Logger::error(__METHOD__ . ' Error: ' . $t->getMessage());
            return false;
        }

        return true;
    }

    public function getLastChallengeAnswer(): ?string
    {
        if ($this->challengeFile->exists()) {
            return $this->challengeFile->get();
        }

        return null;
    }
}
