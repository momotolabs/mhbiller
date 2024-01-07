<?php

use Illuminate\Support\Arr;
use Momotolabs\Mhbiller\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Helpers;

test('get file ok', function () {
    $type = Arr::random(DTESchemas::cases())->value;
    $testPath = Helpers::getFile($type);
    expect($testPath)->not->toBeNull()->toBeString();
});

test('get file fail', function () {
    $type = \Illuminate\Support\Str::random();
    $testPath = Helpers::getFile($type);
    expect($testPath)->toBeNull();
});
