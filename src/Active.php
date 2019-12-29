<?php

namespace Arcesilas\ActiveState;

use Request;
use Illuminate\Http\Request as HttpRequest;
use BadMethodCallException;

/**
 * @method checkNotPathIs(...$patterns) Check whether the path of the url does not match the given patterns
 * @method checkNotPathHas(...$patterns) Check whether the path of the url does not contain given strings
 * @method checkNotQueryContains($parameters) Check if query does not have the given parameters,
 *         with their given values
 * @method checkNotQueryHas(...$parameters) Check if query has none of the given parameters,
 *         not taking their values into account
 * @method checkNotQueryHasOnly(... $parameters) Check if query parameters names are exactly not the ones
 *         given in argument
 * @method checkNotQueryIs(array ...$parameters) Check that the parameters of the query string are exactly
 *         not the ones given in argument
 * @method checkNotRouteIn(...$routes) Check whether the current route is none of the given routes
 * @method checkNotRouteIs($route, array $routeParameters) Check if the current route name is not the one given
 *         and the parameters match the current url
 * @method ifPathIs(...$patterns) Returns activeValue or inactiveValue for checkPathIs test
 * @method ifPathHas(...$patterns) Returns activeValue or inactiveValue for checkPathHas test
 * @method ifQueryContains($parameters) Returns activeValue or inactiveValue for checkQueryContains test
 * @method ifQueryHas(...$parameters) Returns activeValue or inactiveValue for checkQueryHas test
 * @method ifQueryHasOnly(...$parameters) Returns activeValue or inactiveValue for checkQueryHasOnly test
 * @method ifQueryIs(array ...$parameters) Returns activeValue or inactiveValue for checkQuery test
 * @method ifRouteIn(...$routes) Returns activeValue or inactiveValue for checkRouteIn test
 * @method ifRouteIs($route, array $parameters = []) Returns activeValue or inactiveValue for checkRouteIs test
 * @method ifNotPathIs(...$patterns) Returns activeValue or inactiveValue for checkNotPathIs test
 * @method ifNotPathHas(...$patterns) Returns activeValue or inactiveValue for checkNotPathHas test
 * @method ifNotQueryContains($parameters) Returns activeValue or inactiveValue for checkNotQueryContains test
 * @method ifNotQueryHas(...$parameters) Returns activeValue or inactiveValue for checkNotQueryHas test
 * @method ifNotQueryHasOnly(...$parameters) Returns activeValue or inactiveValue for checkNotQueryHasOnly test
 * @method ifNotQueryIs(array ...$parameters) Returns activeValue or inactiveValue for checkNotQueryIs test
 * @method ifNotRouteIn(...$routes) Returns activeValue or inactiveValue for checkNotRouteIn test
 * @method ifNotRouteIs($route, array $parameters = []) Returns activeValue or inactiveValue for checkNotRouteIs test
 */
class Active
{
    /**
     * Value returned when state is "active"
     * @var string
     */
    protected $activeValue;

    /**
     * Whether $activeValue should be reset after a check or not
     * @var bool
     */
    protected $activeValuePersistent = false;

    /**
     * Value returned when state is "inactive"
     * @var string
     */
    protected $inactiveValue;

    /**
     * Whether $inactiveValue should be reset after a check or not
     * @var bool
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
     * Check whether the path of the url matches the given patterns
     * @param  string[] $patterns Patterns to match
     * @return bool
     */
    public function checkPathIs(...$patterns): bool
    {
        return $this->request->is(...$patterns);
    }

    /**
     * Check whether the path of the url contains given strings
     * @param  string[]  $patterns
     * @return bool
     */
    public function checkPathHas(...$patterns): bool
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
     * @param  string|array  $route           The route name to check
     * @param  array         $routeParameters The route parameters, used to build the url
     * @return bool
     */
    public function checkRouteIs($route, array $routeParameters = []): bool
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
     * @param  string[]  $routes
     * @return bool
     */
    public function checkRouteIn(...$routes): bool
    {
        return $this->request->routeIs(...$routes);
    }

    /**
     * Check that the parameters of the query string are exactly the ones given
     * The test returns true if at least one given array matches the query string parameters (keys and values)
     * @param  array  $parameters
     * @return bool
     */
    public function checkQueryIs(array ...$parameters): bool
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
     * @return bool
     */
    public function checkQueryHas(...$parameters): bool
    {
        $queryKeys = array_keys($this->request->query->all());
        return empty(
            array_diff($parameters, $queryKeys)
        );
    }

    /**
     * Check if query parameters names are exactly the ones given in argument
     * The order of the parameters does not matter
     * @param  string[]  $parameters string
     * @return bool
     */
    public function checkQueryHasOnly(...$parameters): bool
    {
        $queryKeys = array_keys($this->request->query->all());
        sort($queryKeys);
        sort($parameters);

        return $parameters === $queryKeys;
    }

    /**
     * Check if query has the given parameters, with their given values
     * @param  array  $parameters  The parameters to check for
     * @return bool
     */
    public function checkQueryContains($parameters): bool
    {
        return empty(
            array_diff($parameters, $this->request->query->all())
        );
    }

    /**
     * Dynamically calls :
     *   - `if*` tests
     *   - `checkNot*` tests
     */
    public function __call($calledMethod, array $arguments)
    {
        if (0 === strpos($calledMethod, 'if')) {
            $check = 'check' . substr($calledMethod, 2);
            return $this->getState($this->$check(...$arguments));
        }

        if (0 === strpos($calledMethod, 'checkNot')) {
            $method = 'check' . substr($calledMethod, 8);
            return ! call_user_func_array([$this, $method], $arguments);
        }

        // @codeCoverageIgnoreStart
        throw new BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $calledMethod));
        // @codeCoverageIgnoreEnd
    }

    /**
     * Returns the active state string depending on the actual state
     * @param  bool  $active
     * @return string
     */
    public function getState(bool $active): string
    {
        return $active ? $this->getActiveValue() : $this->getInactiveValue();
    }

    /**
     * Returns the active state string
     * @return string
     */
    public function getActiveValue(): string
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
    public function getInactiveValue(): string
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
     * @param  bool|null  $persistent Whether to reset the value after the next check
     */
    public function setActiveValue(string $value = null, bool $persistent = null): Active
    {
        $this->activeValue = $value;
        if (null !== $persistent) {
            $this->activeValuePersistent = (bool) $persistent;
        }

        return $this;
    }

    /**
     * Set the inactive state string
     * @param  string  $value      The string value
     * @param  bool|null  $persistent Whether to reset the value after the next check
     */
    public function setInactiveValue(string $value = null, bool $persistent = null): Active
    {
        $this->inactiveValue = $value;
        if (null !== $persistent) {
            $this->inactiveValuePersistent = (bool) $persistent;
        }

        return $this;
    }

    /**
     * Change active and inactive values at runtime and allow method chaining
     * @param  string $activeValue
     * @param  string $inactiveValue
     * @return Active
     */
    public function setValues(string $activeValue = null, string $inactiveValue = null): Active
    {
        $activeValue and $this->setActiveValue($activeValue);
        $inactiveValue and $this->setInactiveValue($inactiveValue);

        return $this;
    }

    /**
     * Reset both active and inactive state strings
     */
    public function resetValues(): Active
    {
        $this->activeValue = null;
        $this->inactiveValue = null;

        return $this;
    }

    //--------------------
    // Deprecated methods
    //--------------------

    /**
    * @deprecated v4.0
    * @see self::ifPathIs()
    *
    * {@inheritdoc}
    */
    public function ifUrlIs(...$patterns): string
    {
        return $this->ifPathIs(...$patterns);
    }

    /**
    * @deprecated v4.0
    * @see self::ifPathHas()
    *
    * {@inheritdoc}
    */
    public function ifUrlHas(...$patterns): string
    {
        return $this->ifPathHas(...$patterns);
    }

    /**
    * @deprecated v4.0
    * @see self::checkPathIs()
    *
    * {@inheritdoc}
    */
    public function checkUrlIs(...$urls): bool
    {
        return $this->checkPathIs(...$urls);
    }

    /**
    * @deprecated v4.0
    * @see self::checkPathHas()
    *
    * {@inheritdoc}
    */
    public function checkUrlHas(...$urls): bool
    {
        return $this->checkPathHas(...$urls);
    }

    /**
     * @deprecated v4.0
     * @see self::setValues()
     *
     * {@inheritdoc}
     */
    public function state(string $active_state = null, string $inactive_state = null): Active
    {
        return $this->setValues($active_state, $inactive_state);
    }
}
