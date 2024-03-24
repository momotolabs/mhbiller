<?php

use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;

test('create schema type FE', function () {
    $dte = new \Momotolabs\Mhbiller\FE(DTESchemas::FE->value);
    $testJson = $dte->generateJson([]);
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

test('create schema type FE with documents related', function () {
    $dte = new \Momotolabs\Mhbiller\FE(DTESchemas::FE->value);
    $data = [
        'documentsRelated' => [
           [
               'typeDocument' => '01',
                'generationType' => '1',
                'documentNumber' => 'd8502ef9-2bb0-4f18-902e-f92bb05f1894',
                'date' => '2024-02-01'
           ],
            [
                'typeDocument' => '02',
                'generationType' => '1',
                'documentNumber' => 'e50e1a05-3159-405c-8e1a-053159b05cb7',
                'date' => '2024-02-01'],
            ],
    ];
    $testJson = $dte->generateJson($data);
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
