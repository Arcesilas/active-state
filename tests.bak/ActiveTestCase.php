<?php

namespace Arcesilas\ActiveState\Tests;

use PHPUnit\Framework\TestCase;

class ActiveTestCase extends TestCase
{
    protected function expected($expected)
    {
        return $expected ? "TEST OK\n" : "";
    }
}
