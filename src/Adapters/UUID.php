<?php

namespace Momotolabs\Mhbiller\Adapters;

final class UUID
{
    public static function make(): string
    {
        return \Ramsey\Uuid\Uuid::uuid4();
    }

}
