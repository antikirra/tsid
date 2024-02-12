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
        static $prev;

        if (!is_int($count) || $count < 1) {
            throw new InvalidArgumentException();
        }

        $tsids = [];
        for ($i = 0; $i < $count; $i++) {
            while (true) {
                $curr = (int)(microtime(true) * 1e9);
                if ($curr > $prev) {
                    break;
                }
            }
            $prev = $curr;
            $tsids[] = $curr;
        }

        return $tsids;
    }
}
