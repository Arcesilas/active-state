<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use PHPUnit\Framework\TestCase;

class OtherTest extends TestCase
{
    public function testGetState()
    {
        $active = new Mocks\ActiveGetValuesMock;
        $this->assertSame('active', $active->getState(true));
        $this->assertSame('', $active->getState(false));
    }

    public function testGetActiveValue()
    {
        $active = new Mocks\ActiveChecksMock;
        $this->assertSame('active', $active->getActiveValue());

        $active->setActiveValue('on');
        $this->assertSame('on', $active->getActiveValue());
    }

    public function testGetActiveValueUsingPersistency()
    {
        $active = new Mocks\ActiveChecksMock;
        $active->setActiveValue('on', false);
        $this->assertSame('on', $active->getActiveValue());
        $active->ifRouteIs('foo');
        // ActiveValue should be reset after a check when persistency is off
        $this->assertSame('active', $active->getActiveValue());

        // Activate persistency
        $active->setActiveValue('on', true);
        $this->assertSame('on', $active->getActiveValue());
        $active->ifRouteIs('foo');
        // ActiveValue should be the same
        $this->assertSame('on', $active->getActiveValue());
    }

    public function testGetInactiveValue()
    {
        $active = new Mocks\ActiveChecksMock;
        $this->assertSame('', $active->getInactiveValue());

        $active->setInactiveValue('off');
        $this->assertSame('off', $active->getInactiveValue());
    }

    public function testGetInactiveValueUsingPersistency()
    {
        $active = new Mocks\ActiveChecksMock;
        $active->setInactiveValue('off', false);
        $this->assertSame('off', $active->getInactiveValue());
        $active->ifRouteIs('foo');
        // ActiveValue should be reset after a check when persistency is off
        $this->assertSame('', $active->getInactiveValue());

        // Activate persistency
        $active->setInactiveValue('off', true);
        $this->assertSame('off', $active->getInactiveValue());
        $active->ifRouteIs('foo');
        // Inactive value should be the same
        $this->assertSame('off', $active->getInactiveValue());
    }

    public function testResetValues()
    {
        $active = new Mocks\ActiveChecksMock;
        $active->setActiveValue('on', true);
        $active->setInactiveValue('off', true);

        $this->assertSame('on', $active->getActiveValue());
        $this->assertSame('off', $active->getInactiveValue());

        $active->resetValues();

        $this->assertSame('active', $active->getActiveValue());
        $this->assertSame('', $active->getInactiveValue());
    }
}
