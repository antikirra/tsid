# TSID | TimeStampable IDentifier

![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/antikirra/tsid/php)
![Packagist Version](https://img.shields.io/packagist/v/antikirra/tsid)
![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen)

**Ultra-fast, lightweight PHP library for generating unique timestamp-based identifiers with nanosecond precision.** Perfect for distributed systems, high-throughput applications, and scenarios requiring guaranteed unique ID generation without external dependencies.

## Install

```console
composer require antikirra/tsid:^3.0
```

## Why TSID?

- ✨ **Blazing Fast Performance** - Zero dependencies, minimal overhead, optimized for speed
- 🔧 **Universal Compatibility** - Works seamlessly from PHP 5.6 to PHP 8.4+
- ⚡ **Nanosecond Precision** - Guaranteed uniqueness even in high-frequency generation
- 🎯 **Snowflake Alternative** - Simple, efficient replacement for complex ID generators
- 📦 **Lightweight** - Compact, pure PHP implementation with no bloat
- 🚀 **Production Ready** - Battle-tested in high-load distributed environments

## Features

- **High-Performance ID Generation**: Up to 39M+ unique IDs per second (Apple M4, PHP 8.4)
- **Timestamp-Based**: IDs contain creation time information for easy sorting and analysis
- **Strictly Monotonic**: Guarantees each ID is always greater than the previous, even during clock adjustments
- **Collision-Free**: Mathematical guarantee of uniqueness within single process
- **Memory Efficient**: Minimal memory footprint, perfect for microservices
- **Legacy Support**: Compatible with ancient PHP versions (5.6+) and modern PHP 8.4
- **Zero Dependencies**: No external libraries, frameworks, or extensions required
- **Process-Safe**: Safe for use in single-threaded PHP processes with static state management
- **100% Test Coverage**: Fully tested with 42 test cases and 5,781 assertions

## Perfect for

- **Distributed Systems**: Unique ID generation across multiple servers
- **High-Frequency APIs**: REST APIs, microservices, real-time applications
- **Database Primary Keys**: Alternative to auto-increment IDs in sharded databases
- **Logging & Tracing**: Unique request IDs, transaction tracking
- **Message Queues**: Job IDs, task identifiers in queue systems
- **Legacy Systems**: Drop-in solution for old PHP applications requiring unique IDs

## Requirements

- **PHP**: 5.6 or higher
- **Extensions**: None (uses only core PHP functions)
- **Memory**: Minimal (< 1MB)
- **Dependencies**: Zero

## Basic usage

```php
<?php

use function Antikirra\tsid;
use function Antikirra\tsids;

require __DIR__ . '/vendor/autoload.php';

echo tsid(); // (int) 1752909802717089759

var_dump(tsids(2)); // array(2) { [0] => int(1752909802717089762) [1] => int(1752909802717090791) }
```

## Testing

The library is thoroughly tested with comprehensive test coverage:

- **Test Framework**: Pest
- **Total Tests**: 42 passing
- **Total Assertions**: 5,781
- **Code Coverage**: 100% (lines and functions)

### Test Categories

- **Basic Functionality**: ID generation, type validation, uniqueness
- **Monotonicity**: Strictly ascending order verification
- **Batch Generation**: Mass ID generation (up to 10,000 IDs)
- **Precision**: Nanosecond-level timestamp accuracy
- **Edge Cases**: Input validation, boundary conditions
- **Performance**: High-frequency generation tests

## Keywords

timestamp-id, unique-identifier, php-id-generator, high-performance, snowflake-alternative, distributed-systems, nanosecond-precision, php-5.6-compatible, zero-dependencies, microtime-based-id
