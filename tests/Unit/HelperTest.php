<?php

use Illuminate\Support\Arr;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Helpers;

test('get file path ok', function () {
    $type = Arr::random(DTESchemas::cases())->value;
    $testPath = Helpers::getFilePath($type);
    expect($testPath)->not->toBeNull()->toBeString();
});

test('get file path fail', function () {
    $type = \Illuminate\Support\Str::random();
    $testPath = Helpers::getFilePath($type);
    expect($testPath)->toBeNull();
});




