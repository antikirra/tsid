# TSID | TimeStampable IDentifier

Generates unique-guaranteed identifiers, based on current timestamp.

## Install

```console
composer require antikirra/tsid
```

## Basic usage

```php
<?php

use function Antikirra\tsid;
use function Antikirra\tsids;

require __DIR__ . '/vendor/autoload.php';

echo tsid(); // 1706568434352340992

var_dump(tsids(2)); // array(2) { [0] => int(1706568434352360960) [1] => int(1706568434352361984) }
```
