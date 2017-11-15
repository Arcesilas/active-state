<?php

namespace Arcesilas\ActiveState\Tests\Unit\Mocks;

/**
 * This class is used to test the if*() methods
 * Its check*() methods always return an expected value, allowing us to only test the check*() methods
 */
class ActiveChecksMock extends ActiveMock
{
    public $expectedBoolean = true;

    public function checkUrlIs(...$patterns)
    {
        return $this->expectedBoolean;
    }

    public function checkUrlHas(...$patterns)
    {
        return $this->expectedBoolean;
    }

    public function checkRouteIs($route, array $routeparameters = [])
    {
        return $this->expectedBoolean;
    }

    public function checkRouteIn(...$routes)
    {
        return $this->expectedBoolean;
    }

    public function checkQueryIs(array ...$parameters)
    {
        return $this->expectedBoolean;
    }

    public function checkQueryHas(...$parameters)
    {
        return $this->expectedBoolean;
    }

    public function checkQueryHasOnly(...$parameters)
    {
        return $this->expectedBoolean;
    }

    public function checkQueryContains($parameters)
    {
        return $this->expectedBoolean;
    }

    public function getState($active)
    {
        return $active ? 'active' : '';
    }
}
