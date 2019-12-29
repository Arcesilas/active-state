<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\BladeDirectives;

use Arcesilas\ActiveState\Tests\TestCase;
use Illuminate\Http\Request as HttpRequest;

class QueryTest extends BladeDirectivesTestCase
{
    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryIsProvider */
    public function testQueryIs($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_is', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryIsProvider */
    public function testNotQueryIs($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_is', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryHasProvider */
    public function testQueryHas($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_has', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryHasProvider */
    public function testNotQueryHas($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_has', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryHasOnlyProvider */
    public function testQueryHasOnly($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_has_only', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryHasOnlyProvider */
    public function testNotQueryHasOnly($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_has_only', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryContainsProvider */
    public function testQueryContains($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_contains', ['params' => $params])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckQueryTest::queryContainsProvider */
    public function testNotQueryContains($requestUrl, $expected, array $params)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_contains', ['params' => $params])->render()
        );
    }
}
