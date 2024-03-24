<?php

namespace Momotolabs\Mhbiller\DTE;

use Carbon\Carbon;
use Momotolabs\Mhbiller\Adapters\UUID;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Data\Constants;

class DocumentBase
{
    private DTESchemas $type;
    public function __construct(string $type)
    {
        $this->type = DTESchemas::fromString($type);
    }

    public function getIdentification(array $data): array
    {

        $contingency =  [
            "tipoContingencia" => $data['typeModel'] === '2' ? $data['typeContingency'] : null,
            "motivoContin" => $data['typeModel'] === '2' ? $data['reasonContingency'] : null,
        ];


        $code = $this->getCodeDocument($this->type);

        return  [
            "version" => $this->getVersion($this->type),
            "ambiente" => config('environment', "00"),
            "tipoDte" => $code,
            "numeroControl" => $this->generateControlNumber($code, 1),
            "codigoGeneracion" => $this->generationCode(),
            "tipoModelo" => $data['typeModel'], // 1 norma, 2 contingency
            "tipoOperacion" => $data['typeOperation'], //1 normal, 2 contingency
            "fecEmi" => Carbon::now()->format('Y-m-d'),
            "horEmi" => Carbon::now()->format('H:i:s'),
            "tipoMoneda" => Constants::CURRENCY,
            ...$contingency
        ];
    }

    public function documentRelated(array $data)
    {
        $documents = [];
        if(isset($data['documentsRelated'])) {
            foreach ($data['documentsRelated'] as $document) {
                $documents[] = [
                    'tipoDocumento' => $document['typeDocument'] ?? null,
                    'tipoGeneracion' => $document['generationType'] ?? null,
                    'numeroDocumento' => $document['documentNumber'] ?? null,
                    'fechaEmision' => $document['date'] ?? null,
                ];
            }

            return $documents;
        }

        return null;

    }

    public function getEmitter(array $data): array
    {
        return [
            "nit" => config('emitter.nit', Constants::MHBILL_NIT),
            "nrc" => config('emitter.nrc', Constants::MHBILL_NRC),
            "nombre" => config('emitter.name', Constants::MHBILL_NAME),
            "codActividad" => config('emitter.cod_activity', Constants::MHBILL_COD_ACTIVITY),
            "descActividad" => config('emitter.des_activity', Constants::MHBILL_DESC_ACTIVITY),
            "nombreComercial" => config('emitter.commercial', Constants::MHBILL_COMMERCIAL_NAME),
            "tipoEstablecimiento" => config('emitter.type_establishment', Constants::MHBILL_TYPE_ESTABLISHMENT),
            "direccion" => [
                "departamento" => config('emitter.direction.state', Constants::MHBILL_DIR_STATE),
                "municipio" => config('emitter.direction.city', Constants::MHBILL_DIR_CITY),
                "complemento" => config('emitter.direction.complement', Constants::MHBILL_DIR_COMPLEMENT),
                ],
            "telefono" => config('emitter.phone', Constants::MHBILL_PHONE),
            "codEstableMH" => $data['mhCodLocal'] ?? config('emitter.cod_mh_stablishment'),
            "codEstable" => $data['codLocal'] ?? config('emitter.cod_stablishment', Constants::MHBILL_COD_STA),
            "codPuntoVentaMH" => $data['mhCodPOS'] ?? config('emitter.cod_mh_pos'),
            "codPuntoVenta" => $data['codPOS'] ?? config('emitter.cod_pos', Constants::MHBILL_COD_POS),
            "correo" => config('emitter.email', Constants::MHBILL_EMAIL),
            ];
    }


    private function getVersion(DTESchemas $type): int
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

    private function getCodeDocument(DTESchemas $type): string
    {
        return $type->getCode();
    }

    private function generateControlNumber(
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

    private function generationCode(): string
    {
        return strtoupper(UUID::make());
    }


}
