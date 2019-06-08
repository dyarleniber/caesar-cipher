<?php

namespace Tests\Controllers;

use Tests\BaseTestCase;

class CaesarCipherControllerTest extends BaseTestCase
{
    public function testSubmitNewChallengeAnswerWithSuccess()
    {
        $this->slimAppConfigure();

        $container = $this->slimApp->getContainer();

        $caesarCipherController = $container->get('caesarCipherController');

        $challengeSubmitResponse = $caesarCipherController->submitNewChallengeAnswer();

        $this->assertTrue($challengeSubmitResponse);

        $lastChallengeAnswer = $caesarCipherController->getLastChallengeAnswer();
        $lastChallengeAnswerObj = json_decode($lastChallengeAnswer);

        $numero_casas = 12;
        $cifrado = 'ur kagd bmdqzfe zqhqd tmp otuxpdqz, otmzoqe mdq kag iaz’f, quftqd. puow omhqff';
        $decifrado = 'if your parents never had children, chances are you won’t, either. dick cavett';
        $resumo_criptografico = 'da226b4fa0a07d187a8753a0db5c048f9da4a958';
        $this->assertEquals($numero_casas, $lastChallengeAnswerObj->numero_casas);
        $this->assertEquals($cifrado, $lastChallengeAnswerObj->cifrado);
        $this->assertEquals($decifrado, $lastChallengeAnswerObj->decifrado);
        $this->assertEquals($resumo_criptografico, $lastChallengeAnswerObj->resumo_criptografico);
    }
}
