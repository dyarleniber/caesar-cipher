<?php

namespace CaesarCipher\Services\ChallengeFile\Implementations;

use CaesarCipher\Services\ChallengeFile\Interfaces\IChallengeFile;

class ChallengeFile implements IChallengeFile
{
    protected $uploadFilesPath;
    protected $challengeFileName;

    public function __construct(string $uploadFilesPath, string $challengeFileName)
    {
        $this->uploadFilesPath = $uploadFilesPath;
        $this->challengeFileName = $challengeFileName;
    }

    public function save(object $fileContent): bool
    {
        \CaesarCipher\Log\Logger::debug(__METHOD__ . ' Object: ' . print_r($fileContent, true));

        $formattedFileContent = json_encode($fileContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return (bool) file_put_contents($this->uploadFilesPath . $this->challengeFileName, $formattedFileContent);
    }

    public function get(): string
    {
        return file_get_contents($this->uploadFilesPath . $this->challengeFileName);
    }

    public function exists(): bool
    {
        return file_exists($this->uploadFilesPath . $this->challengeFileName);
    }
}
