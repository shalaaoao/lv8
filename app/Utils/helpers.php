<?php

/**
 * 耗时
 */
if (!function_exists('execTime')) {
    function execTime(\Closure $closure, string $name = 'flag')
    {
        $start    = microtime(true);
        $res      = $closure();
        $duration = microtime(true) - $start;

        dump("{$name}: {$duration}s");

        return $res;
    }
}
