# TSID | TimeStampable IDentifier

Generates unique-guaranteed identifiers, based on current timestamp.

## Install

```bash
composer require antikirra/tsid
```

## Basic usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Antikirra\TSID\TSID;

echo TSID::one(); // 1676137835118956032

var_dump(TSID::many(2)); // array(2) { [0] => int(1676137921379890944) [1] => int(1676137921379892224) }
```

