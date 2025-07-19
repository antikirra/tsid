# TSID | TimeStampable IDentifier

![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/antikirra/tsid/php)
![Packagist Version](https://img.shields.io/packagist/v/antikirra/tsid)

## Install

```console
composer require antikirra/tsid:^2
```

**Ultra-fast, lightweight PHP library for generating unique timestamp-based identifiers with nanosecond precision.** Perfect for distributed systems, high-throughput applications, and scenarios requiring guaranteed unique ID generation without external dependencies.

## Why TSID?

✨ **Blazing Fast Performance** - Zero dependencies, minimal overhead, optimized for speed  
🔧 **Universal Compatibility** - Works seamlessly from PHP 5.6 to PHP 8.4+  
⚡ **Nanosecond Precision** - Guaranteed uniqueness even in high-frequency generation  
🎯 **Snowflake Alternative** - Simple, efficient replacement for complex ID generators  
📦 **Lightweight** - Just 40 lines of pure PHP code, no bloat  
🚀 **Production Ready** - Battle-tested in high-load distributed environments

## Features

- **High-Performance ID Generation**: Up to 22M+ unique IDs per second
- **Timestamp-Based**: IDs contain creation time information for easy sorting and analysis
- **Collision-Free**: Mathematical guarantee of uniqueness within single process
- **Memory Efficient**: Minimal memory footprint, perfect for microservices
- **Legacy Support**: Compatible with ancient PHP versions (5.6+) and modern PHP 8.4
- **Zero Dependencies**: No external libraries, frameworks, or extensions required
- **Thread-Safe**: Safe for use in multi-threaded environments (with proper process isolation)

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

## License

This project is licensed under the MIT License.

## Keywords

timestamp-id, unique-identifier, php-id-generator, high-performance, snowflake-alternative, distributed-systems, nanosecond-precision, php-5.6-compatible, zero-dependencies, microtime-based-id
