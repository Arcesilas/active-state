<?php

namespace Arcesilas\ActiveState;

use Request;
use Illuminate\Support\Str;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Exceptions\UrlGenerationException;

class Active
{
    /**
     * Value returned when state is "active"
     * @var string
     */
    protected $activeValue;

    /**
     * Whether $activeValue should be reset after a check or not
     * @var boolean
     */
    protected $activeValuePersistent = false;

    /**
     * Value returned when state is "inactive"
     * @var string
     */
    protected $inactiveValue;

    /**
     * Whether $inactiveValue should be reset after a check or not
     * @var [type]
     */
    protected $inactiveValuePersistent = false;

    /**
     * The Request instance
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Obviously: the constructor
     * @method __construct
     * @param  \Illuminate\Http\Request  $request The HTTP Request handled by Laravel
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Check whether url matches the given patterns
     * @param  string $patterns Patterns to match
     * @return boolean
     */
    public function checkUrlIs(...$patterns)
    {
        return $this->request->is(...$patterns);
    }

    /**
     * Check whether url contains given strings
     * @param  string  $patterns
     * @return boolean
     */
    public function checkUrlHas(...$patterns)
    {
        return $this->request->is(array_map(
            function ($item) {
                return "*{$item}*";
            },
            $patterns
        ));
    }

    /**
     * Check if the current route name is the one given and the parameters match the current url
     * @param  string  $route       The route name to check
     * @param  array  $routeparameters The route parameters, used to build the url
     * @return boolean
     */
    public function checkRouteIs($route, array $routeParameters = [])
    {
        if (!is_array($route)) {
            $route = [$route => $routeParameters];
        }
        foreach ($route as $r => $parameters) {
            try {
                $routeUri = route($r, $parameters, true);
                if ($this->request->fullUrlIs($routeUri)) {
                    return true;
                }
            } catch (\Exception $e) {
                // Just ignore the exception: route does not exist
            }
        }
        return false;
    }

    /**
     * Check whether the current route is one of the given routes
     * @method checkRouteIn
     * @param  string  $routes
     * @return boolean
     */
    public function checkRouteIn(...$routes)
    {
        return $this->request->routeIs(...$routes);
    }

    /**
     * Check that the parameters of the query string are exactly the ones given
     * The test returns true if at least one given array matches the query string parameters (keys and values)
     * @param  array  $parameters
     * @return boolean
     */
    public function checkQueryIs(array ...$parameters)
    {
        foreach ($parameters as $params) {
            if ($this->request->query->all() == $params) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if query has all of the given parameters, not taking their values into account
     * @param  array  $parameters
     * @return boolean
     */
    public function checkQueryHas(...$parameters)
    {
        $queryKeys = array_keys($this->request->query->all());
        return empty(
            array_diff($parameters, $queryKeys)
        );
    }

    /**
     * Check if query parameters names are exactly the ones given in argument
     * The order of the parameters does not matter
     * @param  string  $parameters string
     * @return boolean
     */
    public function checkQueryHasOnly(...$parameters)
    {
        $queryKeys = array_keys($this->request->query->all());
        sort($queryKeys);
        sort($parameters);

        return $parameters === $queryKeys;
    }

    /**
     * Check if query has the given parameters, with their given values
     * @param  array  $parameters  The parameters to check for
     * @return boolean
     */
    public function checkQueryContains($parameters)
    {
        return empty(
            array_diff($parameters, $this->request->query->all())
        );
    }

    /**
     * Common check function
     * @param  string  $check  The check method to use
     * @param  array  $arguments  Arguments to check with
     * @return string
     */
    protected function check($check, array $arguments)
    {
        return $this->getState(call_user_func_array([$this, $check], $arguments));
    }

    /**
     * Returns activeValue or inactiveValue for checkUrlIs test
     * @param  string  $patterns
     * @return string  Active state string
     * @see Active::checkUrl
     */
    public function ifUrlIs(...$patterns)
    {
        return $this->check('checkUrlIs', $patterns);
    }

    /**
     * Returns activeValue or inactiveValue for checkUrlHas test
     * @param  string  $patterns
     * @return string  Active state string
     * @see Active::checkUrlHas()
     */
    public function ifUrlHas(...$patterns)
    {
        return $this->check('checkUrlHas', $patterns);
    }

    /**
     * Returns activeValue or inactiveValue for checkRouteIs test
     * @param  string  $route
     * @param  array  $parameters
     * @return string  Active state string
     * @see Active::checkRouteIs()
     */
    public function ifRouteIs($route, array $parameters = [])
    {
        return $this->check('checkRouteIs', [$route, $parameters]);
    }

    /**
     * Return activeValue or inactiveValue for checkRouteIn test
     * @param  string  $routes
     * @return boolean
     * @see Active::checkRouteIn()
     */
    public function ifRouteIn(...$routes)
    {
        return $this->check('checkRouteIn', $routes);
    }

    /**
     * Returns activeValue or inactiveValue for checkQuery test
     * @param  string  $patterns
     * @return string               Active state string
     * @see Active::checkQueryIs()
     */
    public function ifQueryIs(array ...$parameters)
    {
        return $this->check('checkQueryIs', $parameters);
    }

    /**
     * Returns activeValue or inactiveValue for checkQueryHas test
     * @param  string  $patterns
     * @return string  Active state string
     * @see Active::checkQueryHas()
     */
    public function ifQueryHas(...$parameters)
    {
        return $this->check('checkQueryHas', $parameters);
    }

    /**
     * Returns activeValue or inactiveValue for checkQueryHasOnly test
     * @param  string  $patterns
     * @return string  Active state string
     * @see Active::checkQueryHasOnly()
     */
    public function ifQueryHasOnly(...$parameters)
    {
        return $this->check('checkQueryHasOnly', $parameters);
    }

    /**
     * Returns activeValue or inactiveValue for checkQueryContains test
     * @param  string  $parameters
     * @return string  Active state string
     * @see Active::checkQueryContains()
     */
    public function ifQueryContains($parameters)
    {
        return $this->check('checkQueryContains', $parameters);
    }

    /**
     * Returns the active state string depending on the actual state
     * @param  boolean  $active
     * @return string
     */
    public function getState($active)
    {
        return $active ? $this->getActiveValue() : $this->getInactiveValue();
    }

    /**
     * Returns the active state string
     * @return string
     */
    public function getActiveValue()
    {
        $return = $this->activeValue ?? config('active.active_state', 'active');
        if (! $this->activeValuePersistent) {
            $this->setActiveValue();
        }
        return $return;
    }

    /**
     * Return the inactive state string
     * @return string
     */
    public function getInactiveValue()
    {
        $return = $this->inactiveValue ?? config('active.inactive_state', '');
        if (! $this->inactiveValuePersistent) {
            $this->setInactiveValue();
        }
        return $return;
    }

    /**
     * Set the active state string
     * @param  string  $value  The string value
     * @param  boolean|null  $persistent Whether to reset the value after the next check
     */
    public function setActiveValue($value = null, $persistent = null)
    {
        $this->activeValue = $value;
        if (null !== $persistent) {
            $this->activeValuePersistent = (bool) $persistent;
        }
    }

    /**
     * Set the inactive state string
     * @param  string  $value      The string value
     * @param  boolean|null  $persistent Whether to reset the value after the next check
     */
    public function setInactiveValue($value = null, $persistent = null)
    {
        $this->inactiveValue = $value;
        if (null !== $persistent) {
            $this->inactiveValuePersistent = (bool) $persistent;
        }
    }

    /**
     * Reset both active and inactive state strings
     */
    public function resetValues()
    {
        $this->activeValue = null;
        $this->inactiveValue = null;
    }
}
