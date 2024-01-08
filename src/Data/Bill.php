<?php

namespace Momotolabs\Mhbiller\Data;

class Bill
{
    public function generate()
    {
        $this->getIdentification();
        $this->getEmitter();
        $this->setReceiver();
        $this->setBodyBill();
        $this->generateResume();

        $documentationRelated = [];
        $otherDocs = [];
        $thirdSale = [];


    }

    /**
     * @return void
     */
    public function getIdentification(): void
    {
        $identification = [
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
     * @return void
     */
    public function getEmitter(): void
    {
        $emiter = [
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
     * @return void
     */
    public function setReceiver(): void
    {
        $reciver = [
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
     * @return void
     */
    public function setBodyBill(): void
    {
        $documentBody = [
            "numItem" => 1,
            "tipoItem" => 1,
            "numeroDocumento" => null,
            "cantidad" => 2,
            "codigo" => "020101004",
            "codTributo" => null,
            "uniMedida" => 99,
            "descripcion" => "ContaPortable Avanzado 15 empresas",
            "precioUni" => 175.00310000,
            "montoDescu" => 0,
            "ventaNoSuj" => 0,
            "ventaExenta" => 0,
            "ventaGravada" => 350.00620000,
            "tributos" => null,
            "psv" => 0,
            "noGravado" => 0,
            "ivaItem" => 40.26620000
        ];
    }

    /**
     * @return void
     */
    public function generateResume(): void
    {
        $resume = [
            "totalNoSuj" => 0,
            "totalExenta" => 0,
            "totalGravada" => 350.01,
            "subTotalVentas" => 350.01,
            "descuNoSuj" => 0,
            "descuExenta" => 0,
            "descuGravada" => 0,
            "porcentajeDescuento" => 0,
            "totalDescu" => 0,
            "tributos" => null,
            "subTotal" => 350.01,
            "ivaRete1" => 0,
            "reteRenta" => 0,
            "montoTotalOperacion" => 350.01,
            "totalNoGravado" => 0,
            "totalPagar" => 350.01,
            "totalLetras" => "TRESCIENTOS CINCUENTA DOLARES CON 01/100 CENTAVOS.",
            "totalIva" => 40.27,
            "saldoFavor" => 0,
            "condicionOperacion" => 1,
            "pagos" => null,
            "numPagoElectronico" => null
        ];
    }

}
