<?php

namespace Arcesilas\ActiveState\Tests\Unit\Mocks;

class ActiveGetValuesMock extends ActiveMock
{
    public function getActiveValue()
    {
        return 'active';
    }

    public function getInactiveValue()
    {
        return '';
    }
}
