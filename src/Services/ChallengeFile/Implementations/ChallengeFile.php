<?php

namespace CaesarCipher\Services\Implementations;

use CaesarCipher\Services\Interfaces\IChallengeFile;

class ChallengeFile extends Service implements IChallengeFile
{
    public function save(object $fileContent): bool
    {
        global $settings;

        $formattedFileContent = json_encode($fileContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return (bool) file_put_contents($settings['uploadFilesPath'] . $settings['challengeFileName'], $formattedFileContent);
    }
}
