<?php

namespace Collinped\Aimtell\Tests;

use Collinped\Aimtell\Aimtell;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * @var Aimtell
     */
    protected Aimtell $aimtell;

    public function setUp(): void
    {
        parent::setUp();
        $this->aimtell = new Aimtell();
    }
}
