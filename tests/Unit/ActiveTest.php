<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit;

use Arcesilas\ActiveState\Tests\TestCase;
use Arcesilas\ActiveState\Active as ActiveClass;
use Active;

/** @covers Arcesilas\ActiveState\ActiveFacade */
class ActiveTest extends TestCase
{
    protected $active;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @covers Arcesilas\ActiveState\Active::getState
     */
    public function testGetState()
    {
        $this->assertSame('active', Active::getState(true));
        $this->assertSame('', Active::getState(false));
    }

    /**
     * @covers Arcesilas\ActiveState\Active::getActiveValue
     * @covers Arcesilas\ActiveState\Active::setActiveValue
     */
    public function testGetActiveValue()
    {
        $this->assertSame('active', Active::getActiveValue());

        $return = Active::setActiveValue('on');
        $this->assertInstanceOf(ActiveClass::class, $return);
        $this->assertSame('on', Active::getActiveValue());

    }

    /**
     * @covers Arcesilas\ActiveState\Active::getActiveValue
     * @covers Arcesilas\ActiveState\Active::setActiveValue
     */
    public function testGetActiveValueUsingPersistency()
    {
        Active::setActiveValue('on', false);
        $this->assertSame('on', Active::getActiveValue());
        // ActiveValue should be reset after a check when persistency is off
        $this->assertSame('active', Active::getActiveValue());

        // Activate persistency
        Active::setActiveValue('on', true);
        $this->assertSame('on', Active::getActiveValue());
        // ActiveValue should be the same
        $this->assertSame('on', Active::getActiveValue());
    }

    /**
     * @covers Arcesilas\ActiveState\Active::getInactiveValue
     * @covers Arcesilas\ActiveState\Active::setInactiveValue
     */
    public function testGetInactiveValue()
    {
        $this->assertSame('', Active::getInactiveValue());

        $return = Active::setInactiveValue('off');
        $this->assertInstanceOf(ActiveClass::class, $return);
        $this->assertSame('off', Active::getInactiveValue());
    }

    /**
     * @covers Arcesilas\ActiveState\Active::getInactiveValue
     * @covers Arcesilas\ActiveState\Active::setInactiveValue
     */
    public function testGetInactiveValueUsingPersistency()
    {
        Active::setInactiveValue('off', false);
        $this->assertSame('off', Active::getInactiveValue());
        // ActiveValue should be reset after a check when persistency is off
        $this->assertSame('', Active::getInactiveValue());

        // Activate persistency
        Active::setInactiveValue('off', true);
        $this->assertSame('off', Active::getInactiveValue());
        // Inactive value should be the same
        $this->assertSame('off', Active::getInactiveValue());
    }

    /**
     * @covers Arcesilas\ActiveState\Active::resetValues
     */
    public function testResetValues()
    {
        Active::setActiveValue('on', true);
        Active::setInactiveValue('off', true);

        $this->assertSame('on', Active::getActiveValue());
        $this->assertSame('off', Active::getInactiveValue());

        Active::resetValues();

        $this->assertSame('active', Active::getActiveValue());
        $this->assertSame('', Active::getInactiveValue());
    }

    /**
     * @covers Arcesilas\ActiveState\Active::setValues
     */
    public function testSetValues()
    {
        $this->assertInstanceOf(\Arcesilas\ActiveState\Active::class, Active::setValues('on', 'off'));
        $this->assertSame('on', Active::getActiveValue());
        $this->assertSame('off', Active::getInactiveValue());

        $this->assertSame('active', Active::getActiveValue());
        $this->assertSame('', Active::getInactiveValue());
    }
}
