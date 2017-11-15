<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Arcesilas\ActiveState\Active;
use Arcesilas\ActiveState\ActiveFacade;
use Illuminate\Http\Request as HttpRequest;

class CheckUrlTest extends TestCase
{

    protected function init()
    {
        $request = HttpRequest::create('http://example.com/foo/bar');
        return new Active($request);
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\UrlIs::getData()
     */
    public function testCheckUrlIs($expected, $checkUrl)
    {
        $active = $this->init();

        $this->assertSame($expected, $active->checkUrlIs($checkUrl));
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\UrlHas::getData()
     */
    public function testCheckUrlHas($expected, $checkUrl)
    {
        $active = $this->init();

        $this->assertSame($expected, $active->checkUrlHas(...$checkUrl));
    }
}
