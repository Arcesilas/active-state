<?php

namespace Arcesilas\ActiveState\Tests\Unit\Mocks;

use Prophecy\Prophet;
use Arcesilas\ActiveState\Active;
use Illuminate\Http\Request as HttpRequest;

class ActiveMock extends Active
{
    public function __construct()
    {
        $prophet = new Prophet;
        parent::__construct($prophet->prophesize(HttpRequest::class)->reveal());
    }
}
