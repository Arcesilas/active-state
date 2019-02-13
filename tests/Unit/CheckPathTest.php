<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Arcesilas\ActiveState\Active;
use Arcesilas\ActiveState\ActiveFacade;
use Illuminate\Http\Request as HttpRequest;

class CheckPathTest extends TestCase
{

    protected function init()
    {
        $request = HttpRequest::create('http://example.com/foo/bar');
        return new Active($request);
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathIs::getData()
     */
    public function testCheckPathIs($expected, $checkPath)
    {
        $active = $this->init();

        $this->assertSame($expected, $active->checkPathIs($checkPath));
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathHas::getData()
     */
    public function testCheckPathHas($expected, $checkPath)
    {
        $active = $this->init();

        $this->assertSame($expected, $active->checkPathHas(...$checkPath));
    }
}
