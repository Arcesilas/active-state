<?php

namespace Arcesilas\ActiveState\Tests\Feature\Mocks;

use Arcesilas\ActiveState\ActiveStateServiceProvider;

class ActiveStateServiceProviderMock extends ActiveStateServiceProvider
{
    // We need the function to exist, not to do anything
    protected function mergeConfigFrom($path, $key)
    {
        //
    }
}
