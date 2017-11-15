<?php

namespace Arcesilas\ActiveState;

/**
 * This function is used to override the Laravel config() helper
 * It always returns an expected value
 */
function config($name, $default = null)
{
    $values = require __DIR__.'/../../../src/config/active.php';

    return $values[$name] ?? $default;
}
