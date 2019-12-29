<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\BladeDirectives;

use Arcesilas\ActiveState\Tests\TestCase;
use Illuminate\Http\Request as HttpRequest;

class BladeDirectivesTestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        app('view')->addLocation(__DIR__.'/views');
    }

    protected function expected(bool $expected)
    {
        return $expected ? "TEST OK\n" : "";
    }

}
