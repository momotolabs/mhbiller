<?php

use Illuminate\Support\Arr;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Helpers;

test('create schema type FE', function () {
    $dte = new \Momotolabs\Mhbiller\Bill();
    $testJson = $dte->generate();
    expect($testJson)->not->toBeNull()->toBeJson();
    expect($testJson)->json()
    ->toHaveKey('identificacion')
    ->toHaveKey('documentoRelacionado')
    ->toHaveKey('emisor')
    ->toHaveKey('receptor')
    ->toHaveKey('otrosDocumentos')
    ->toHaveKey('ventaTercero')
    ->toHaveKey('cuerpoDocumento')
    ->toHaveKey('cuerpoDocumento')
    ->toHaveKey('resumen')
    ->toHaveKey('extension')
    ->toHaveKey('apendice');
});


