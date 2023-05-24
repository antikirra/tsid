<?php

if (!function_exists('tsid')) {
    /**
     * @return int
     */
    function tsid()
    {
        return \Antikirra\TSID\TSID::one();
    }
}

if (!function_exists('tsid_array')) {
    /**
     * @param int $count
     * @return int[]
     */
    function tsid_array($count)
    {
        return \Antikirra\TSID\TSID::many($count);
    }
}
