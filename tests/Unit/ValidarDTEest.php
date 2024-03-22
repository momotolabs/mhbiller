<?php

use Illuminate\Support\Arr;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Helpers;

test('create schema type FE', function () {
    $dteValid = new \Momotolabs\Mhbiller\Data\DTE();
    $item = $dteValid->validate(DTESchemas::FE->value);
    expect($item)->toBe(true);
})->repeat(1);

test('create schema wrong type FE', function () {
    $dteValid = new \Momotolabs\Mhbiller\Data\DTE();
    $item = $dteValid->validate(DTESchemas::FEXE->value);
    expect($item)->toBe(false);
})->repeat(1);


