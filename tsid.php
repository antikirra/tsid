<?php

namespace Antikirra;

use InvalidArgumentException;

/**
 * @return int
 */
function tsid()
{
    return tsids(1)[0];
}

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
