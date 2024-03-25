<?php

use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;

test('create schema type fe', function () {
    $data = [
        'documentsRelated' => [
            [
                'typeDocument' => '04',
                'generationType' => 1,
                'documentNumber' => 'f92bb05f1894',
                'date' => '2024-02-01'
            ],
            [
                'typeDocument' => '09',
                'generationType' => 1,
                'documentNumber' => '053159b05cb7',
                'date' => '2024-02-01'],
        ],
        'receiver'=>[
            "documentType" => "36",
            "documentNumber" => "06140603071024",
            "nrc" => null,
            "name" => "EMPRESA, S.A. DE C.V.",
            "activityCode" => "80202",
            "activityDesc" => "Actividades para la prestacion de sistemas de seguridad",
            "direction" => [
                "state" => "06",
                "city" => "06",
                "complement" => "DIRECCION"
            ],
            "phone" => "0000-0000",
            "email" => "sincorreo@nomail.com"
        ],
        'bodyBill'=>[
            [
                "itemType" => 1,
                "documentNumber" => null,
                "quantity" => 1,
                "code" => "020101004",
                "taxCode" => null,
                "unitMeasure" => 99,
                "description" => "desarrollo de web",
                "unitPrice" => 35.38,
                "discount" => 8.85,
                "nonSujSale" => 0,
                "exemptSale" => 0,
                "taxes" => [
                    "C3"
                ],
                "psv" => 0,
                "noTax" => 0,
            ],
            [
                "itemType" => 1,
                "documentNumber" => '8834uu',
                "quantity" => 1,
                "code" => "jj99334",
                "taxCode" => null,
                "unitMeasure" => 99,
                "description" => "GHDHSGD de web",
                "unitPrice" => 8.86,
                "discount" => 2.05,
                "nonSujSale" => 0,
                "exemptSale" => 0,
                "psv" => 0,
                "noTax" => 0
            ],
        ],
        'operationCondition'=>1, //1-contado,2-credito,3-mixta
        'payments'=>[
            [
                'code'=>'02',
                "reference"=> "4081151108",
                "term"=> "01",
                "period"=> null
            ]
        ]

    ];

    $dteValid = new \Momotolabs\Mhbiller\Data\DTE();
    $item = $dteValid->validate(DTESchemas::FE,$data);
    expect($item)->toBe(true);
})->repeat(1);

test('create schema wrong type DocumentBase', function () {
    $dteValid = new \Momotolabs\Mhbiller\Data\DTE();
    $item = $dteValid->validate(DTESchemas::FEXE->value);
    expect($item)->toBe(false);
})->repeat(1);


