<?php

namespace Momotolabs\Mhbiller\Data;

use Exception;
use Illuminate\Support\Facades\Log;
use Momotolabs\Mhbiller\Bill;
use Momotolabs\Mhbiller\Helpers;
use Swaggest\JsonSchema\Schema;

class DTE
{
    public function validate(string $type)
    {
        try {
            $bill = json_decode((new Bill())->generate());
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
