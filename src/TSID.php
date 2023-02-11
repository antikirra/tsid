<?php

declare(strict_types=1);

namespace Antikirra\TSID;

final class TSID
{
    private static $prev = 0;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __wakeup()
    {
    }

    /**
     * @return int
     */
    public static function one(): int
    {
        $tsids = self::get();
        return array_pop($tsids);
    }

    /**
     * @param int $count
     * @return int[]
     */
    public static function many(int $count): array
    {
        return self::get($count);
    }

    /**
     * @param int $count
     * @return int[]
     */
    private static function get(int $count = 1): array
    {
        $tsids = [];
        for ($i = 1; $i <= $count; $i++) {
            for (; ;) {
                $curr = (int)(microtime(true) * 1e9);
                if ($curr > self::$prev) {
                    break;
                }
            }
            self::$prev = $curr;
            $tsids[] = $curr;
        }

        return $tsids;
    }
}
