<?php

use Illuminate\Support\Arr;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Helpers;

test('get file path ok', function () {
    $type = Arr::random(DTESchemas::cases())->value;
    $testPath = (new Helpers($type))->getFilePath();
    expect($testPath)->not->toBeNull()->toBeString();
});

test('get file path fail', function () {
    $type = \Illuminate\Support\Str::random();
    $testPath = (new Helpers($type))->getFilePath();
    expect($testPath)->toBeNull();
});




