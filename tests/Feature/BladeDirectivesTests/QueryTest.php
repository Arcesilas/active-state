<?php

namespace Arcesilas\ActiveState\Tests\Feature\BladeDirectivesTests;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request as HttpRequest;
use Arcesilas\ActiveState\ActiveFacade as Active;

class QueryTest extends BladeDirectivesTestCase
{
    public function setUp()
    {
        $this->app = new Application(__DIR__);

        $this->initBlade();
        $this->loadActiveStateServiceProvider();

        if (!class_exists('Active')) {
            class_alias(Active::class, 'Active');
        }
    }

    protected function init($requestUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryIs::getData()
     */
    public function testQueryIs($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_is', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryIs::getData()
     */
    public function testNotQueryIs($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_is', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryHas::getData()
     */
    public function testQueryHas($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_has', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryHas::getData()
     */
    public function testNotQueryHas($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_has', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryHasOnly::getData()
     */
    public function testQueryHasOnly($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);

        $this->assertEquals(
            $this->expected($expected),
            view('query_has_only', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryHasOnly::getData()
     */
    public function testNotQueryHasOnly($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);

        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_has_only', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryContains::getData()
     */
    public function testQueryContains($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);
        $this->assertEquals(
            $this->expected($expected),
            view('query_contains', ['params' => $params])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryContains::getData()
     */
    public function testNotQueryContains($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);

        $this->assertEquals(
            $this->expected(! $expected),
            view('not_query_contains', ['params' => $params])->render()
        );
    }
}
