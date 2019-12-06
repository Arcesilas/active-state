<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\Active;

use Arcesilas\ActiveState\{
    Active,
    Tests\TestCase
};
use Illuminate\Http\Request as HttpRequest;

/** @covers Arcesilas\ActiveState\Active::__call */
class IfTest extends TestCase
{
    protected function getActiveMock($method, $mockReturn, $arguments)
    {
        $active = $this->getMockBuilder(Active::class)
            ->disableOriginalConstructor()
            ->setMethods([$method])
            ->getMock();

        $active->expects($this->once())
            ->method($method)
            ->with($arguments)
            ->willReturn($mockReturn);

        $active->setValues('on', 'off');

        return $active;
    }

    /** @dataProvider getMethods */
    public function testIfMethodsReturnOnWithTrue($method, $mockMethod, $arguments)
    {
        $active = $this->getActiveMock($mockMethod, true, $arguments);
        $this->assertSame('on', $active->$method($arguments));
    }

    /** @dataProvider getMethods */
    public function testIfMethodsReturnOffWithFalse($method, $mockMethod, $arguments)
    {
        $active = $this->getActiveMock($mockMethod, false, $arguments);
        $this->assertSame('off', $active->$method($arguments));
    }

    public function getMethods()
    {
        return [
            ['ifPathHas',       'checkPathHas',      'foo'],
            ['ifPathIs',        'checkPathIs',       'foo'],
            ['ifRouteIs',       'checkRouteIs',      'foo'],
            ['ifRouteIn',       'checkRouteIn',      'foo'],
            ['ifQueryIs',       'checkQueryIs',       ['arg1' => 'val1']],
            ['ifQueryHas',      'checkQueryHas',      ['arg1']],
            ['ifQueryHasOnly',  'checkQueryHasOnly',  ['arg1']],
            ['ifQueryContains', 'checkQueryContains', ['arg1' => 'val1']],
        ];
    }
}
