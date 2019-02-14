<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;
use Arcesilas\ActiveState\Active;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use PHPUnit\Framework\AssertionFailedError;
use Prophecy\Prediction\CallbackPrediction;

class HelpersTest extends TestCase
{
    protected $app;

    protected $active;

    public function setUp()
    {
        $this->app = new Application(__DIR__);
        Container::setinstance($this->app);
    }

    public function predictionsProvider()
    {
        // [$helper, $activeMethod, $arguments]
        return [
            'active_path_is()'            => ['active_path_is', 'ifPathIs', ['foo/bar']],
            'active_path_has()'           => ['active_path_has', 'ifPathHas', ['foo/bar']],
            'active_route_is()'           => ['active_route_is', 'ifRouteIs', ['foo.bar', []]],
            'active_route_in()'           => ['active_route_in', 'ifRouteIn', ['foo.bar']],
            'active_query_is()'           => ['active_query_is', 'ifQueryIs', [['arg1' => 'val1']]],
            'active_query_has()'          => ['active_query_has', 'ifQueryHas', [['arg1']]],
            'active_query_has_only()'     => ['active_query_has_only', 'ifQueryHasOnly', [['arg1']]],
            'active_query_contains()'     => ['active_query_contains', 'ifQueryContains', [['arg1' => 'val1']]],
            'active_not_path_is()'        => ['active_not_path_is', 'ifNotPathIs', ['foo/bar']],
            'active_not_path_has()'       => ['active_not_path_has', 'ifNotPathHas', ['foo/bar']],
            'active_not_route_is()'       => ['active_not_route_is', 'ifNotRouteIs', ['foo.bar', []]],
            'active_not_route_in()'       => ['active_not_route_in', 'ifNotRouteIn', ['foo.bar']],
            'active_not_query_is()'       => ['active_not_query_is', 'ifNotQueryIs', [['arg1' => 'val1']]],
            'active_not_query_has()'      => ['active_not_query_has', 'ifNotQueryHas', [['arg1']]],
            'active_not_query_has_only()' => ['active_not_query_has_only', 'ifNotQueryHasOnly', [['arg1']]],
            'active_not_query_contains()' => ['active_not_query_contains', 'ifNotQueryContains', [['arg1' => 'val1']]],
        ];
    }

    /**
     * @dataProvider predictionsProvider
     */
    public function testHelpers($helper, $activeMethod, $arguments)
    {
        $active = $this->getMockBuilder(Active::class)
            ->disableOriginalConstructor()
            ->setMethods([$activeMethod])
            ->getMock();

        $this->app['active-state'] = $active;

        $mockArgs = array_map(function ($arg) {
            return $this->equalTo($arg);
        }, $arguments);

        $active->expects($this->once())
            ->method($activeMethod)
            ->with(...$mockArgs);

        call_user_func_array($helper, $arguments);
    }

    public function testDeprecatedHelpers()
    {
        $active = $this->getMockBuilder(Active::class)
            ->disableOriginalConstructor()
            ->setMethods(['ifPathIs', 'ifPathHas'])
            ->getMock();

        $this->app['active-state'] = $active;

        $argument = 'foo/bar';

        $active->expects($this->once())
            ->method('ifPathIs')
            ->with($this->equalTo($argument));

        $active->expects($this->once())
            ->method('ifPathHas')
            ->with($this->equalTo($argument));

        active_url_is($argument);
        active_url_has($argument);
    }
}
