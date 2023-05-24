<?php

namespace Antikirra;

if (!function_exists('Antikirra\tsid')) {
    /**
     * @return int
     */
    function tsid()
    {
        return \Antikirra\TSID\TSID::one();
    }
}

if (!function_exists('Antikirra\tsid_array')) {
    /**
     * @param int $count
     * @return int[]
     */
    function tsid_array($count)
    {
        return \Antikirra\TSID\TSID::many($count);
    }
}
