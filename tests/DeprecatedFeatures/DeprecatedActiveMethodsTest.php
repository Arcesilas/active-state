<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\DeprecatedFeatures;

use Arcesilas\ActiveState\{
    Active,
    Tests\TestCase
};
use Illuminate\Http\Request as HttpRequest;

/** @coversDefaultClass Arcesilas\ActiveState\Active */
class DeprecatedActiveMethodsTest extends TestCase
{
    protected function getActiveMock(?array $methods)
    {
        $active = $this->getMockBuilder(Active::class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();

        return $active;
    }

    public function aliasesProvider()
    {
        return [
            ['ifPathIs', 'ifUrlIs', ''],
            ['ifPathHas', 'ifUrlHas', ''],
            ['checkPathIs', 'checkUrlIs', true],
            ['checkPathHas', 'checkUrlHas', true]
        ];
    }

    /**
     * @dataProvider aliasesProvider
     * @covers ::ifUrlIs
     * @covers ::ifUrlHas
     * @covers ::checkUrlIs
     * @covers ::checkUrlHas
     */
    public function testPathAliases($actual, $alias, $return)
    {
        $active = $this->getActiveMock([$actual]);
        $active->expects($this->once())
            ->method($actual)
            ->with('foo')
            ->willReturn($return);
        $active->$alias('foo');
    }

    public function testState()
    {
        $active = $this->getActiveMock(null);

        $this->assertSame($active, $active->state('on', 'off'));
        $this->assertSame('on', $active->getActiveValue());
        $this->assertSame('off', $active->getInactiveValue());

        // Persistency should be off
        $this->assertSame('active', $active->getActiveValue());
        $this->assertSame('', $active->getInactiveValue());
    }
}
