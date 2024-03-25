<?php

declare(strict_types=1);

namespace Momotolabs\Mhbiller\Helpers;

use Momotolabs\Mhbiller\Adapters\UUID;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Data\Constants;

final class DTEHelper
{
    public function getCodeDocument(DTESchemas $type): string
    {
        return $type->getCode();
    }

    public function generateControlNumber(
        string $code,
        int $series,
        string $local = '0000',
        string $pos = '0000'
    ): string {
        //this code is generate follow the next definition
        // $nomenclature is indicator of a DTE
        // $code is a param is obtained for definitions of catalog 'CAT-02'
        // $complement sets 8 digits, the first four are defined as the local and the next four as the pos
        // $sequence set a 15 digit in a sequential number this number will be reset when is a new year

        $nomenclature = Constants::NOMENCLATURE;
        $complement =  $local.$pos;
        $sequence = str_pad((string)($series + 1), 15, '0', STR_PAD_LEFT);

        return $nomenclature.'-'.$code.'-'.$complement.'-'. $sequence;
    }

    public function generationCode(): string
    {
        return strtoupper(UUID::make());
    }

    public function getVersion(DTESchemas $type): int
    {
        $version = 1;
        if($type === DTESchemas::CCFE ||
            $type === DTESchemas::NCE  ||
            $type === DTESchemas::NDE  ||
            $type === DTESchemas::NRE) {
            $version = 3;
        }

        return $version;
    }



    public function otherDocs(array $data)
    {
        $documents = [];
        if(isset($data['otherDocuments'])) {
            foreach ($data['otherDocuments'] as $document) {
                $medic = [];
                if(isset($document['otherDocuments']['medic'])) {
                    $medic = [
                        'nit' => $document['otherDocuments']['medic']['nit'] ?? null,
                        'docIdentificacion' => $document['otherDocuments']['medic']['documentIdentification'] ?? null,
                        'tipoServicio' => $document['otherDocuments']['medic']['serviceType'] ?? null,


                    ];
                }
                $documents[] = [
                    'codDocAsociado' => $document['typeDocument'] ?? null,
                    'descDocumento' => $document['generationType'] ?? null,
                    'detalleDocumento' => $document['documentNumber'] ?? null,
                    'fechaEmision' => $document['date'] ?? null,
                    ...$medic
                ];
            }

            return $documents;
        }

        return null;

    }

    public function thirdSale($data)
    {
        if(isset($data['thirdSale'])) {
            return [
                'nit' => $data['thirdSale']['nit'] ?? null,
                'name' => $data['thirdSale']['name'] ?? null,
            ];
        }
        return null;
    }

    public function calculateTax(
        float $quantity,
        float $price,
        float $discount = 0.0,
        float $tax = Constants::IVA
    ): array {
        $sale = ($quantity * $price) - $discount;
        return [
            'iva' => round(($sale / (1.0 + $tax)) * $tax, 2),
            'taxSale' => $sale
        ];
    }

    public function resumeData(array $data)
    {
        $iva = 0.0;
        $saleTax = 0.0;
        $discount = 0.0;
        $noTaxSale = 0.0;
        $exemptSale = 0.0;
        $subTotalSale = 0.0;

        foreach ($data as $item) {
            $iva += $item['ivaItem'];
            $saleTax += $item['ventaGravada'];
            $discount += $item['montoDescu'];
            $noTaxSale += $item['ventaNoSuj'];
            $exemptSale += $item['ventaExenta'];

        }

        $subTotalSale = $saleTax + $noTaxSale + $exemptSale;

        return [
            'iva' => $iva,
            'discount' => $discount,
            'subtotal' => $subTotalSale,
            'saleTax' => $saleTax,
            'noTaxSale' => $noTaxSale,
            'exemptSale' => $exemptSale,
        ];
    }

    public function payments($data, $ammount)
    {
        $payments = [];
        /**TODO se tiene que complementar las formas de pago en base al tipo de operacion por momento
 * solo se estaconsierando pago de contado con billetes y/o monedas y pagos con tarjetas
 * */

        foreach ($data as $pay) {
            $reference = null;
            if($pay['code'] === '02' || $pay['code'] === '03') {
                $reference = $pay['reference'];
            }
            $payments[] = [
                "codigo" => $pay['code'],
                "montoPago" => $ammount,
                "referencia" => $reference,
                "plazo" => $pay['term'],
                "periodo" => $pay['period']
            ];
        }

        return $payments;

    }


}
