<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit;

use Arcesilas\ActiveState\{
    Active,
    Tests\TestCase
};
use Illuminate\Http\Request as HttpRequest;

class HelpersTest extends TestCase
{
    protected function getActiveMock($method, $arguments)
    {
        $active = $this->getMockBuilder(Active::class)
            ->disableOriginalConstructor()
            ->setMethods([$method])
            ->getMock();

        return $active;
    }


    /**
     * @dataProvider predictionsProvider
     * @covers ::active_path_is
     * @covers ::active_path_has
     * @covers ::active_route_is
     * @covers ::active_route_in
     * @covers ::active_query_is
     * @covers ::active_query_has
     * @covers ::active_query_has_only
     * @covers ::active_query_contains
     * @covers ::active_not_path_is
     * @covers ::active_not_path_has
     * @covers ::active_not_route_is
     * @covers ::active_not_route_in
     * @covers ::active_not_query_is
     * @covers ::active_not_query_has
     * @covers ::active_not_query_has_only
     * @covers ::active_not_query_contains
     */
    public function testHelpers($helper, $method, $arguments)
    {
        $active = $this->getActiveMock($method, $arguments);

        $active->expects($this->once())
            ->method($method)
            ->with(...$arguments);

        app()['active-state'] = $active;

        call_user_func_array($helper, $arguments);
    }

    public function predictionsProvider()
    {
        // [$helper, $method, $arguments]
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
     * @dataProvider deprecatedHelpersProvider
     * @covers ::active_url_is
     * @covers ::active_url_has
     */
    public function testDeprecatedHelpers($helper, $method)
    {
        $active = $this->getActiveMock($method, 'foo/bar');
        $active->expects($this->once())
            ->method($method)
            ->with('foo/bar');

        app()['active-state'] = $active;

        call_user_func($helper, 'foo/bar');
    }

    public function deprecatedHelpersProvider()
    {
        return [
            'active_url_is'      => ['active_url_is', 'ifPathIs'],
            'active_url_has'     => ['active_url_has', 'ifPathHas'],
        ];
    }
}
