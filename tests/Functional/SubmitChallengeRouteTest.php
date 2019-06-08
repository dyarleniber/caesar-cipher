<?php

namespace Tests\Functional;

class SubmitChallengeRouteTest extends BaseTestCase
{
    public function testSubmitChallengeRouteWithSuccess()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, (int) $response->getStatusCode());
        $this->assertStringContainsString('OK', (string) $response->getBody());
    }

    public function testSubmitChallengeRouteNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, (int) $response->getStatusCode());
        $this->assertStringContainsString('Method not allowed', (string) $response->getBody());
    }
}
