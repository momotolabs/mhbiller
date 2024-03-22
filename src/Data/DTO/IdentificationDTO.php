<?php

namespace Momotolabs\Mhbiller\Data\DTO;

class IdentificationDTO
{

    public function __construct(
        public $version,
    public $environment,
    public $documentType,
    public $controlNumber,
    public $generationCode,
    public $modelType,
    public $operationType,
    public $contingencyType,
    public $contingencyReason,
    public $issueDate,
    public $issueTime,
    public $currencyType,
    ){
    }
}
