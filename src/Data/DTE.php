<?php

namespace Momotolabs\Mhbiller\Data;

use Exception;
use Illuminate\Support\Facades\Log;
use Momotolabs\Mhbiller\Data\Concerns\DTESchemas;
use Momotolabs\Mhbiller\DTE\FE;
use Momotolabs\Mhbiller\Helpers\FileHelpers;
use Swaggest\JsonSchema\Schema;

class DTE
{
    public function validate(DTESchemas $type, array $data)
    {
        try {
            $bill = json_decode((new FE($type->value))->generateJson($data));
            $file = (new FileHelpers($type->value))->getFile();
            $schema = Schema::import(json_decode($file));
            $schema->in($bill);
            return true;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }

    }
}
