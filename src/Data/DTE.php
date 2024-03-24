<?php

namespace Momotolabs\Mhbiller\Data;

use Exception;
use Illuminate\Support\Facades\Log;
use Momotolabs\Mhbiller\FE;
use Momotolabs\Mhbiller\Helpers;
use Swaggest\JsonSchema\Schema;

class DTE
{
    public function validate(string $type)
    {
        try {
            $bill = json_decode((new FE())->generate());
            $file = (new Helpers($type))->getFile();
            $schema = Schema::import(json_decode($file));
            $schema->in($bill);
            return true;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }

    }
}
