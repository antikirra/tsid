<?php

namespace Antikirra;

use InvalidArgumentException;

if (!function_exists('Antikirra\\tsid')) {
    /**
     * @return int
     */
    function tsid()
    {
        list($tsid) = tsids(1);
        return $tsid;
    }
}

if (!function_exists('Antikirra\\tsids')) {
    /**
     * @param int $count
     * @return int[]
     */
    function tsids($count)
    {
        static $offset = 0;

        if (!is_int($count) || $count < 1) {
            throw new InvalidArgumentException(
                sprintf('Expected positive integer for count, got %s', gettype($count))
            );
        }

        $tsids = [];

        for ($i = 0; $i < $count; $i++) {
            $tsids[] = (int)(microtime(true) * 1e9) + (++$offset);
        }

        $offset = 0;

        return $tsids;
    }
}
