<?php

use function Antikirra\tsid;
use function Antikirra\tsids;

require __DIR__ . '/vendor/autoload.php';

echo "\n";
echo "==============================================\n";
echo "TSID Performance Benchmark\n";
echo "==============================================\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Platform: " . PHP_OS . "\n";
echo "Architecture: " . php_uname('m') . "\n";
echo "==============================================\n\n";

/**
 * @param callable $callback
 * @param int $iterations
 * @return array
 */
function benchmark($callback, $iterations)
{
    $memoryBefore = memory_get_usage();
    $start = microtime(true);

    $result = call_user_func($callback, $iterations);

    $end = microtime(true);
    $memoryAfter = memory_get_usage();

    $duration = $end - $start;
    $memoryUsed = $memoryAfter - $memoryBefore;

    return array(
        'duration' => $duration,
        'memory' => $memoryUsed,
        'result' => $result
    );
}

/**
 * @param int $bytes
 * @return string
 */
function formatBytes($bytes)
{
    if ($bytes < 1024) {
        return $bytes . ' B';
    } elseif ($bytes < 1048576) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return round($bytes / 1048576, 2) . ' MB';
    }
}

/**
 * @param int $number
 * @return string
 */
function formatNumber($number)
{
    if ($number >= 1000000) {
        return round($number / 1000000, 2) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 2) . 'K';
    }
    return (string)$number;
}

// Test 1: Single ID generation
echo "Test 1: Single ID Generation (tsid)\n";
echo "--------------------------------------------\n";
$iterations = 1000000;
$stats = benchmark(function($n) {
    $ids = array();
    for ($i = 0; $i < $n; $i++) {
        $ids[] = tsid();
    }
    return $ids;
}, $iterations);

$idsPerSecond = $iterations / $stats['duration'];
echo sprintf("Iterations: %s\n", formatNumber($iterations));
echo sprintf("Duration: %.4f seconds\n", $stats['duration']);
echo sprintf("Performance: %s IDs/second\n", formatNumber($idsPerSecond));
echo sprintf("Memory: %s\n", formatBytes($stats['memory']));
echo sprintf("Avg per ID: %.2f bytes\n\n", $stats['memory'] / $iterations);

// Test 2: Batch generation with different sizes
echo "Test 2: Batch Generation (tsids)\n";
echo "--------------------------------------------\n";

$batchSizes = array(10, 100, 1000, 10000, 100000);

foreach ($batchSizes as $batchSize) {
    $batchCount = (int)(1000000 / $batchSize);

    $stats = benchmark(function($count) use ($batchSize) {
        $allIds = array();
        for ($i = 0; $i < $count; $i++) {
            $batch = tsids($batchSize);
            $allIds = array_merge($allIds, $batch);
        }
        return $allIds;
    }, $batchCount);

    $totalIds = $batchCount * $batchSize;
    $idsPerSecond = $totalIds / $stats['duration'];

    echo sprintf("Batch size: %s | Batches: %s | Total IDs: %s\n",
        formatNumber($batchSize),
        formatNumber($batchCount),
        formatNumber($totalIds)
    );
    echo sprintf("  Performance: %s IDs/second\n", formatNumber($idsPerSecond));
    echo sprintf("  Duration: %.4f seconds\n", $stats['duration']);
    echo sprintf("  Memory: %s (%.2f bytes/ID)\n\n",
        formatBytes($stats['memory']),
        $stats['memory'] / $totalIds
    );
}

// Test 3: Uniqueness validation
echo "Test 3: Uniqueness Validation\n";
echo "--------------------------------------------\n";
$testCount = 100000;
$ids = tsids($testCount);
$unique = array_unique($ids);
$uniqueCount = count($unique);
$duplicates = $testCount - $uniqueCount;

echo sprintf("Generated: %s IDs\n", formatNumber($testCount));
echo sprintf("Unique: %s IDs\n", formatNumber($uniqueCount));
echo sprintf("Duplicates: %d\n", $duplicates);
echo sprintf("Uniqueness: %.4f%%\n\n", ($uniqueCount / $testCount) * 100);

// Test 4: Monotonicity validation
echo "Test 4: Monotonicity Validation\n";
echo "--------------------------------------------\n";
$testCount = 100000;
$ids = tsids($testCount);
$violations = 0;

for ($i = 1; $i < count($ids); $i++) {
    if ($ids[$i] <= $ids[$i - 1]) {
        $violations++;
    }
}

echo sprintf("Generated: %s IDs\n", formatNumber($testCount));
echo sprintf("Monotonicity violations: %d\n", $violations);
echo sprintf("Monotonic: %s\n\n", $violations === 0 ? 'YES' : 'NO');

// Test 5: Maximum throughput test
echo "Test 5: Maximum Throughput (Large Batch)\n";
echo "--------------------------------------------\n";
$largeCount = 1000000; // 1 million
$stats = benchmark(function($n) {
    return tsids($n);
}, $largeCount);

$idsPerSecond = $largeCount / $stats['duration'];
echo sprintf("Generated: %s IDs\n", formatNumber($largeCount));
echo sprintf("Duration: %.4f seconds\n", $stats['duration']);
echo sprintf("Performance: %s IDs/second\n", formatNumber($idsPerSecond));
echo sprintf("Memory: %s\n", formatBytes($stats['memory']));
echo sprintf("Avg per ID: %.2f bytes\n\n", $stats['memory'] / $largeCount);

echo "==============================================\n";
echo "Benchmark Complete\n";
echo "==============================================\n\n";
