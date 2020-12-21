<?php

namespace Collinped\Aimtell\Tests;

use Collinped\Aimtell\Exception\RequestException;
use InvalidArgumentException;

class ResponseTest extends TestCase
{
    /** @test */
    public function it_attempts_request_without_api_key()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid API key is required.');

        $this->aimtell->setApiKey(null);
        $this->aimtell->site()->all();
    }
}
