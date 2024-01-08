<?php

namespace Momotolabs\Mhbiller\Data\Concerns;

enum DTESchemas: string
{
    case CCFE = 'CCFE';
    case NDE = 'NDE';
    case NCE = 'NCE';
    case NRE = 'NRE';
    case CRE = 'CRE';
    case CLE = 'CLE';
    case DCLE = 'DCLE';
    case FSEE = 'FSEE';
    case CDE = 'CDE';
    case FE = 'FE';
    case FEXE = 'FEXE';
    case CANCEL = 'CANCEL';
    case CONTINGENCY = 'CONTINGENCY';

    public function getLabels(): string
    {
        return match ($this) {
            self::CCFE => 'Comprobante de Crédito Fiscal Electrónico',
            self::NCE => 'Nota de Crédito Electrónica',
            self::NDE => 'Nota de Débito Electrónica',
            self::NRE => 'Nota de Remisión Electrónica',
            self::CRE => 'Comprobante de Retención Electrónico',
            self::CLE => 'Comprobante de Liquidación Electrónico',
            self::DCLE => 'Documento Contable de Liquidación Electrónico',
            self::FSEE => 'Factura Sujeto Excluido Electrónico',
            self::CDE => 'Comprobante de Donación Electrónico',
            self::FE => 'Factura Electrónica',
            self::FEXE => 'Factura de Exportación Electrónica',
            self::CANCEL => 'Anulación',
            self::CONTINGENCY => 'Contingencia',
        };
    }
}
