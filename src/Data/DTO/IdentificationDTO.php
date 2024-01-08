<?php

namespace Momotolabs\Mhbiller\Data\DTO;

class IdentificationDTO
{

public function __construct(
    public readonly int $version,
    public readonly string $environment,
    public readonly string $DTEtype,
    public readonly string $controlNumber,
    public readonly string $generationCode,
    public readonly int $modelType,
    public readonly int $operationType,
    public readonly string $date,
    public readonly string $time,
    public readonly string $currency,
)
{
}


}
