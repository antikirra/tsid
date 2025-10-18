<?php

use function Antikirra\tsid;
use function Antikirra\tsids;

describe('tsid() function', function () {
    it('generates a single ID', function () {
        $id = tsid();

        expect($id)->toBeInt();
    });

    it('generates positive integers', function () {
        $id = tsid();

        expect($id)->toBeGreaterThan(0);
    });

    it('generates unique IDs on consecutive calls', function () {
        $ids = [];

        for ($i = 0; $i < 100; $i++) {
            $ids[] = tsid();
        }

        $uniqueIds = array_unique($ids);

        // With smart offset reset, all IDs should be unique
        expect(count($uniqueIds))->toBe(100)
            ->and($ids)->each->toBeInt()
            ->and($ids)->each->toBeGreaterThan(0);
    });

    it('generates IDs in strictly ascending order', function () {
        $id1 = tsid();
        $id2 = tsid();
        $id3 = tsid();

        // With smart offset reset, IDs should always increase
        expect($id2)->toBeGreaterThan($id1)
            ->and($id3)->toBeGreaterThan($id2);
    });

    it('generates many unique IDs in sequence', function () {
        $ids = [];

        for ($i = 0; $i < 1000; $i++) {
            $ids[] = tsid();
        }

        $uniqueIds = array_unique($ids);

        // With smart offset reset, all IDs should be unique
        expect(count($uniqueIds))->toBe(1000)
            ->and($ids)->each->toBeInt()
            ->and($ids)->each->toBeGreaterThan(0);
    });
});

describe('tsids() function', function () {
    it('generates correct count of IDs', function ($count) {
        $ids = tsids($count);

        expect($ids)->toHaveCount($count)
            ->and($ids)->toBeArray();
    })->with([
        [1],
        [10],
        [100],
        [1000],
        [10000],
    ]);

    it('generates all IDs as integers', function ($count) {
        $ids = tsids($count);

        expect($ids)->each->toBeInt();
    })->with([1, 10, 100, 1000]);

    it('generates all positive IDs', function ($count) {
        $ids = tsids($count);

        expect($ids)->each->toBeGreaterThan(0);
    })->with([1, 10, 100, 1000]);

    it('generates unique IDs within single call', function ($count) {
        $ids = tsids($count);
        $uniqueIds = array_unique($ids);

        expect(count($uniqueIds))->toBe($count);
    })->with([
        [10],
        [100],
        [1000],
        [10000],
    ]);

    it('generates IDs in ascending order', function ($count) {
        $ids = tsids($count);

        for ($i = 1; $i < $count; $i++) {
            expect($ids[$i])->toBeGreaterThan($ids[$i - 1]);
        }
    })->with([10, 100, 1000]);

    it('generates unique IDs across multiple calls', function () {
        $allIds = [];

        // Generate IDs in multiple batches
        for ($i = 0; $i < 10; $i++) {
            $ids = tsids(100);
            $allIds = array_merge($allIds, $ids);
        }

        $uniqueIds = array_unique($allIds);

        expect(count($uniqueIds))->toBe(1000);
    });

    it('maintains uniqueness across multiple calls', function () {
        // First batch
        $batch1 = tsids(10);

        // Second batch - should continue with unique IDs
        $batch2 = tsids(10);

        // All IDs should be unique across batches
        $allIds = array_merge($batch1, $batch2);
        $uniqueIds = array_unique($allIds);

        expect(count($uniqueIds))->toBe(20)
            ->and($batch2[0])->toBeGreaterThan($batch1[count($batch1) - 1]);
    });

    it('handles large batch generation', function () {
        $count = 100000;
        $ids = tsids($count);

        $uniqueIds = array_unique($ids);

        expect(count($ids))->toBe($count)
            ->and(count($uniqueIds))->toBe($count);
    });
});

describe('tsids() validation', function () {
    it('throws exception for invalid type', function ($value, $type) {
        tsids($value);
    })->with([
        ['string', 'string'],
        [1.5, 'double'],
        [[], 'array'],
        [null, 'NULL'],
        [true, 'boolean'],
    ])->throws(InvalidArgumentException::class, 'Expected positive integer for count, got');

    it('throws exception for zero', function () {
        tsids(0);
    })->throws(InvalidArgumentException::class, 'Expected positive integer for count, got integer');

    it('throws exception for negative numbers', function ($count) {
        tsids($count);
    })->with([
        [-1],
        [-10],
        [-100],
    ])->throws(InvalidArgumentException::class, 'Expected positive integer for count, got integer');
});

describe('timestamp precision', function () {
    it('uses nanosecond precision', function () {
        // Generate two IDs in quick succession
        $id1 = tsid();
        $id2 = tsid();

        // The difference should be small (nanoseconds), proving high precision
        $difference = $id2 - $id1;

        // Difference should be positive (ascending) and small (nanosecond scale)
        expect($difference)->toBeGreaterThan(0)
            ->and($difference)->toBeLessThan(1000000); // Less than 1 millisecond
    });

    it('maintains precision in batch generation', function () {
        $ids = tsids(100);

        // Calculate differences between consecutive IDs
        $differences = [];
        for ($i = 1; $i < count($ids); $i++) {
            $differences[] = $ids[$i] - $ids[$i - 1];
        }

        // All differences should be exactly 1 (incremental offset within same nanosecond batch)
        // or slightly more if time progressed
        expect($differences)->each->toBeGreaterThan(0)
            ->and($differences)->each->toBeLessThan(1000000);
    });
});

describe('performance characteristics', function () {
    it('generates IDs quickly', function () {
        $start = microtime(true);
        $ids = tsids(10000);
        $elapsed = microtime(true) - $start;

        expect($elapsed)->toBeLessThan(0.1) // Should take less than 100ms
            ->and(count($ids))->toBe(10000)
            ->and(count(array_unique($ids)))->toBe(10000);
    });
});

describe('edge cases', function () {
    it('generates single ID correctly', function () {
        $ids = tsids(1);

        expect($ids)->toHaveCount(1)
            ->and($ids[0])->toBeInt()
            ->and($ids[0])->toBeGreaterThan(0);
    });

    it('tsid() returns same type as tsids(1)[0]', function () {
        $singleId = tsid();
        $batchId = tsids(1)[0];

        expect(gettype($singleId))->toBe(gettype($batchId))
            ->and($singleId)->toBeInt()
            ->and($batchId)->toBeInt();
    });
});
