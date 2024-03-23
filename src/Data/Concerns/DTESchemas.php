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
    case FE = 'DocumentBase';
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
    public static function fromString(string $value): ?DTESchemas
    {
        return match ($value) {
            'CCFE' => self::CCFE,
            'NDE' => self::NDE,
            'NCE' => self::NCE,
            'NRE' => self::NRE,
            'CRE' => self::CRE,
            'CLE' => self::CLE,
            'DCLE' => self::DCLE,
            'FSEE' => self::FSEE,
            'CDE' => self::CDE,
            'DocumentBase' => self::FE,
            'FEXE' => self::FEXE,
            'CANCEL' => self::CANCEL,
            'CONTINGENCY' => self::CONTINGENCY,
        };
    }

    public function getCode(): string
    {
        return match ($this) {
            self::CCFE => '03',
            self::NCE => '05',
            self::NDE => '06',
            self::NRE => '04',
            self::CRE => '07',
            self::CLE => '08',
            self::DCLE => '09',
            self::FSEE => '14',
            self::CDE => '15',
            self::FE => '01',
            self::FEXE => '11',
        };
    }
}
