# TSID | TimeStampable IDentifier

Generates unique-guaranteed identifiers, based on current timestamp.

## Install

```console
composer require antikirra/tsid
```

## Basic usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// only if the function has not been defined in the global scope
tsid();
tsid_array(5);

// if the function could not be defined globally
\Antikirra\tsid();
\Antikirra\tsid_array(5);

// under the hood
\Antikirra\TSID\TSID::one();
\Antikirra\TSID\TSID::many(5);
```

## Demo

```php
<?php

require __DIR__ . '/vendor/autoload.php';

echo tsid(); // 1676137835118956032

var_dump(tsid_array(2)); // array(2) { [0] => int(1676137921379890944) [1] => int(1676137921379892224) }
```
