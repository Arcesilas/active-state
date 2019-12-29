<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests;

use Arcesilas\ActiveState\{
    ActiveFacade,
    ActiveStateServiceProvider
};

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ActiveStateServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Active' => ActiveFacade::class,
        ];
    }

}
