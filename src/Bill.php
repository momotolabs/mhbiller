<?php

namespace Momotolabs\Mhbiller;

class Bill
{
    public function generate()
    {



        $documentationRelated = null;
        $otherDocs = null;
        $thirdSale = null;
        $extension = null;
        $append = null;

        return  json_encode([
        "identificacion"=> $this->getIdentification(),
        "documentoRelacionado"=>$documentationRelated,
        "emisor"=> $this->getEmitter(),
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
    public function getIdentification(): array
    {
        return  [
            "version" => 1,
            "ambiente" => "00",
            "tipoDte" => "01",
            "numeroControl" => "DTE-01-00000000-000000000000226",
            "codigoGeneracion" => "905973D8-7786-448B-852E-597D5734D126",
            "tipoModelo" => 1,
            "tipoOperacion" => 1,
            "tipoContingencia" => null,
            "motivoContin" => null,
            "fecEmi" => "2023-11-10",
            "horEmi" => "20:02:15",
            "tipoMoneda" => "USD"
        ];
    }

    /**
     * @return array
     */
    public function getEmitter(): array
    {
       return [
            "nit" => "06142507221034",
            "nrc" => "3176570",
            "nombre" => "MOMOTOLABS, SOCIEDAD ANONIMA DE CAPITAL VARIABLE",
            "codActividad" => "62010",
            "descActividad" => "Programacion informatica",
            "nombreComercial" => "Momotolabs",
            "tipoEstablecimiento" => "02",
            "direccion" => [
                "departamento" => "06",
                "municipio" => "14",
                "complemento" => "3DIRECCIONa"
            ],
            "telefono" => "59639-8203",
            "codEstableMH" => null,
            "codEstable" => "0001",
            "codPuntoVentaMH" => null,
            "codPuntoVenta" => "01",
            "correo" => "CORREO@gmail.com"
        ];
    }

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
