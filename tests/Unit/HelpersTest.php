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

        $this->active = $this->prophesize(Active::class);

        $this->app['active-state'] = $this->active->reveal();
    }

    protected function predict($helper, $argument)
    {
        $this->active->$helper(Argument::exact($argument))->shouldBecalledTimes(1);
    }

    public function predictionsProvider()
    {
        // [$helper, $activeMethod, $arguments, $argsInArray]
        return [
            ['active_url_is', 'ifUrlIs', 'foo/bar', false],
            ['active_url_has', 'ifUrlHas', 'foo/bar', false],
            ['active_route_is', 'ifRouteIs', ['foo.bar', []], true],
            ['active_route_in', 'ifRouteIn', 'foo.bar', false],
            ['active_query_is', 'ifQueryIs', ['arg1' => 'val1'], false],
            ['active_query_has', 'ifQueryHas', ['arg1'], false],
            ['active_query_has_only', 'ifQueryHasOnly', ['arg1'], false],
            ['active_query_contains', 'ifQueryContains', ['arg1' => 'val1'], false]
        ];
    }

    /**
     * @dataProvider predictionsProvider
     */
    public function testHelpers($helper, $activeMethod, $argument, $argsInArray)
    {
        // PHPUnit cannot handle variable number of arguments in dataProviders, we have to do it ourselves
        $predictionArguments = [];
        if ($argsInArray) {
            foreach ($argument as $arg) {
                $predictionArguments[] = Argument::exact($arg);
            }
        } else {
            $predictionArguments = [Argument::exact($argument)];
        }

        $this->active->$activeMethod(...$predictionArguments)->shouldBeCalledTimes(1);
        if ($argsInArray) {
            call_user_func_array($helper, $argument);
        } else {
            call_user_func($helper, $argument);
        }
    }
}
