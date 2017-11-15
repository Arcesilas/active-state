<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Arcesilas\ActiveState\Active;
use Illuminate\Http\Request as HttpRequest;
use Arcesilas\ActiveState\Tests\DataProviders;

class CheckQueryTest extends TestCase
{

    protected $request;

    protected function init($requestUrl)
    {
        $this->request = HttpRequest::create('http://example.com'.$requestUrl);
        return new Active($this->request);
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryIs::getData()
     */
    public function testCheckQueryIs($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);

        $this->assertSame($expected, $active->checkQueryIs(...$params));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryHas::getData()
     */
    public function testCheckQueryHas($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);

        $this->assertSame($expected, $active->checkQueryHas(...$params));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryHasOnly::getData()
     */
    public function testCheckQueryHasOnly($requestUrl, $expected, array $params)
    {
        $active = $this->init($requestUrl);

        $this->assertSame($expected, $active->checkQueryHasOnly(...$params));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\QueryContains::getData()
     */
    public function testCheckQueryContains($requestUrl, $expected, $params)
    {
        $active = $this->init($requestUrl);

        $this->assertSame($expected, $active->checkQueryContains($params));
    }
}
