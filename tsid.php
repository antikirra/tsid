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

