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
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathIs::getData()
     */
    public function testCheckUrlIs($expected, $checkPath)
    {
        $active = $this->init();

        $this->assertSame($expected, $active->checkUrlIs($checkPath));
        $this->assertSame($active->checkPathIs($checkPath), $active->checkUrlIs($checkPath));
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathHas::getData()
     */
    public function testCheckUrlHas($expected, $checkPath)
    {
        $active = $this->init();

        $this->assertSame($expected, $active->checkUrlHas(...$checkPath));
        $this->assertSame($active->checkPathHas(...$checkPath), $active->checkUrlHas(...$checkPath));
    }
}
