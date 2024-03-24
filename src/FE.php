<?php

namespace Momotolabs\Mhbiller;

use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\DTE\DocumentBase;
use Momotolabs\Mhbiller\DTE\TaxDocument;

class FE extends DocumentBase implements TaxDocument
{
    public function generateJson(array $data) :string
    {
        $otherDocs = null;
        $thirdSale = null;
        $extension = null;
        $append = null;
        $baseData =[
            'typeModel'=>1,
            'typeOperation'=>1
        ];
        return  json_encode([
        "identificacion"=> $this->getIdentification($baseData),
        "documentoRelacionado"=>$this->documentRelated($data),
        "emisor"=> $this->getEmitter($data),
        "receptor"=>$this->setReceiver(),
        "otrosDocumentos"=>$otherDocs,
        "ventaTercero"=>$thirdSale,
        "cuerpoDocumento"=>$this->setBodyBill(),
        "resumen"=>$this->generateResume(),
        "extension"=>$extension,
        "apendice"=>$append
    ]);



    }


    /**
     * @return array
     */


    /**
     * @return array
     */
    public function setReceiver(): array
    {
         return [
            "tipoDocumento" => "36",
            "numDocumento" => "06140603071024",
            "nrc" => null,
            "nombre" => "EMPRESA, S.A. DE C.V.",
            "codActividad" => "80202",
            "descActividad" => "Actividades para la prestacion de sistemas de seguridad",
            "direccion" => [
                "departamento" => "06",
                "municipio" => "06",
                "complemento" => "DIRECCION"
            ],
            "telefono" => "0000-0000",
            "correo" => "sincorreo@nomail.com"
        ];
    }

    /**
     * @return array
     */
    public function setBodyBill(): array
    {
        return [[
            "numItem" => 1,
            "tipoItem" => 1,
            "numeroDocumento" => null,
            "cantidad" => 2,
            "codigo" => "020101004",
            "codTributo" => null,
            "uniMedida" => 99,
            "descripcion" => "desarrollo de web",
            "precioUni" => 175.00310000,
            "montoDescu" => 0,
            "ventaNoSuj" => 0,
            "ventaExenta" => 0,
            "ventaGravada" => 350.00620000,
            "tributos" => null,
            "psv" => 0,
            "noGravado" => 0,
            "ivaItem" => 40.26620000
        ]];
    }

    /**
     * @return array
     */
    public function generateResume(): array
    {
        return [
            "totalNoSuj"=> 0.0,
    "totalExenta"=> 0.0,
    "totalGravada"=> 104.22,
    "subTotalVentas"=> 104.22,
    "descuNoSuj"=> 0.0,
    "descuExenta"=> 0.0,
    "descuGravada"=> 0.0,
    "porcentajeDescuento"=> 0.0,
    "totalDescu"=> 28.47,
    "tributos"=> null,
    "subTotal"=> 104.22,
    "ivaRete1"=> 0.0,
    "reteRenta"=> 0.0,
    "montoTotalOperacion"=> 104.22,
    "totalNoGravado"=> 0.0,
    "totalPagar"=> 104.22,
    "totalLetras"=> "CIENTO CUATRO CON 22/100 DOLARES",
    "totalIva"=> 11.99,
    "saldoFavor"=> 0.0,
    "condicionOperacion"=> 1,
    "pagos"=> [
      [
          "codigo"=> "03",
        "montoPago"=> 104.22,
        "referencia"=> "4034170195",
        "plazo"=> "01",
        "periodo"=> null
      ]
    ],
    "numPagoElectronico"=> null
        ];
    }

}
