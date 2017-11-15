<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use Prophecy\Argument;
use Illuminate\Routing\Router;
use PHPUnit\Framework\TestCase;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request as HttpRequest;
use Arcesilas\ActiveState\Tests\Unit\Mocks\ActiveChecksMock as Active;

class IfTest extends TestCase
{
    protected $active;

    public function setUp()
    {
        $this->active = new Active;
    }

    protected function setBool($boolean)
    {
        $this->active->expectedBoolean = $boolean;
    }

    public function defaultStatesProvider()
    {
        // [$boolean, $expected]
        return [
            [true, 'active'],
            [false, '']
        ];
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfUrlIs($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifUrlIs('foo/bar'));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfUrlHas($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifUrlHas('foo/bar'));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfRouteIs($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifRouteIs('foo.bar'));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfRouteIn($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifRouteIn('foo.bar'));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfQueryIs($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifQueryIs(['arg1' => 'val1']));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfQueryHas($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifQueryHas(['arg1']));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfQueryHasOnly($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifQueryHasOnly(['arg1']));
    }

    /**
     * @dataProvider defaultStatesProvider
     */
    public function testIfQueryContains($boolean, $expected)
    {
        $this->setBool($boolean);
        $this->assertSame($expected, $this->active->ifQueryContains(['arg1' => 'val1']));
    }
}
