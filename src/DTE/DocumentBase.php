<?php

namespace Momotolabs\Mhbiller\DTE;

use Carbon\Carbon;
use Momotolabs\Mhbiller\Adapters\NumberToLetter;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\Data\Constants;
use Momotolabs\Mhbiller\Helpers\DTEHelper;

class DocumentBase
{
    private DTESchemas $type;
    protected $helper;
    public function __construct(string $type)
    {
        $this->type = DTESchemas::fromString($type);
        $this->helper = new DTEHelper();
    }

    public function getIdentification(array $data): array
    {

        $contingency =  [
            "tipoContingencia" => $data['typeModel'] === '2' ? $data['typeContingency'] : null,
            "motivoContin" => $data['typeModel'] === '2' ? $data['reasonContingency'] : null,
        ];


        $code = $this->helper->getCodeDocument($this->type);

        return  [
            "version" => $this->helper->getVersion($this->type),
            "ambiente" => config('environment', "00"),
            "tipoDte" => $code,
            "numeroControl" => $this->helper->generateControlNumber(
                $code,
                1,
                Constants::MHBILL_COD_STA,
                Constants::MHBILL_COD_POS
            ),
            "codigoGeneracion" => $this->helper->generationCode(),
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


    public function setReceiver(array $data): array
    {
        return [
            "tipoDocumento" => $data['documentType'] ?? null,
            "numDocumento" => $data['documentNumber'] ?? null,
            "nrc" => $data['nrc'] ?? null,
            "nombre" => $data['name'] ?? null,
            "codActividad" => $data['activityCode'] ?? null,
            "descActividad" => $data['activityDesc'] ?? null,
            "direccion" => [
                "departamento" => $data['direction']['state'] ?? null,
                "municipio" => $data['direction']['city'] ?? null,
                "complemento" => $data['direction']['complement'] ?? null
            ],
            "telefono" => $data['phone'] ?? null,
            "correo" => $data['email'] ?? null,
        ];
    }

    public function setBodyBill(array$data): array
    {
        $items = [];
        foreach ($data['bodyBill'] as $key => $value) {

            $calcs = $this->helper->calculateTax($value['quantity'], $value['unitPrice'], $value['discount']);

            $items[] = [
                "numItem" => $key + 1,
                "tipoItem" => $value['itemType'],
                "numeroDocumento" => $value['documentNumber'] ?? null,
                "cantidad" => $value['quantity'],
                "codigo" => $value['code'],
                "codTributo" => $value['taxCode'] ?? null,
                "uniMedida" => $value['unitMeasure'],
                "descripcion" => $value['description'],
                "precioUni" => $this->helper->valueSlack($value['unitPrice'],1.0E-8),
                "montoDescu" => $this->helper->valueSlack($value['discount'],1.0E-8),
                "ventaNoSuj" => $value['noSuj'] ?? 0,
                "ventaExenta" => $value['exemptSale'] ?? 0,
                "ventaGravada" => $this->helper->valueSlack($calcs['taxSale'],1.0E-8),
                "tributos" => $value['taxes'] ?? null,
                "psv" => $value['psv'] ?? 0, //precio de venta sugerido
                "noGravado" => $value['noTax'] ?? 0,
                "ivaItem" => $this->helper->valueSlack($calcs['iva'],1.0E-8)
            ];

        }

        return $items;
    }

    public function generateResume($data): array
    {
        $resume = $this->helper->resumeData($this->setBodyBill($data));

        $discountNoTax = $data['descuNoSuj'] ?? 0.0;
        $discountExempt = $data['descuExenta'] ?? 0.0;
        $discountTax = $data['descuGravada'] ?? 0.0;
        $total = $resume['subtotal'] + $discountExempt + $discountNoTax + $discountTax;
        return [
            "totalNoSuj" => $resume['noTaxSale'],
            "totalExenta" => $resume['exemptSale'],
            "totalGravada" =>$resume['saleTax'],
            "subTotalVentas" => $resume['subtotal'],
            "descuNoSuj" => $discountNoTax,
            "descuExenta" => $discountExempt,
            "descuGravada" => $discountTax,
            "porcentajeDescuento" => 0.0,
            "totalDescu" => round($resume['discount'] + $discountExempt + $discountNoTax + $discountTax, 3),
            "tributos" => null,
            "subTotal" => round($total, 2),
            "ivaRete1" => 0.0,
            "reteRenta" => 0.0,
            "montoTotalOperacion" => round($total, 2),
            "totalNoGravado" => 0.0,
            "totalPagar" => round($total, 2),
            "totalLetras" => mb_strtoupper(NumberToLetter::make(($total * 100)), 'UTF-8'),
            "totalIva" => round($resume['iva'], 2),
            "saldoFavor" => 0.0,
            "condicionOperacion" => $data['operationCondition'],
            "pagos" => $this->helper->payments($data['payments'], $total),
            "numPagoElectronico" => null
        ];
    }

    public function generateExtension($data)
    {
        return[
            "nombEntrega" => $data['nameDelivery'] ?? null,
            "docuEntrega" => $data['docDelivery'] ?? null,
            "nombRecibe" => $data['nameReceiver'] ?? null,
            "docuRecibe" => $data['nameReceiver'] ?? null,
            "observaciones" => $data['observations'] ?? null,
            "placaVehiculo" => $data['plate'] ?? null
        ];
    }


}
