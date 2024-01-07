<?php

namespace Momotolabs\Mhbiller;


use Illuminate\Support\Facades\Log;
use Momotolabs\Mhbiller\Exceptions\NotFoundFileException;

class Helpers
{

    public static function getFile(string $type): string|null
    {
    try{
        $fileName =  [
            'CCFE'=>'fe-ccf-v3.json',
            'CDE'=>'fe-cd-v1.json',
            'CLE'=>'fe-cl-v1.json',
            'CRE'=>'fe-cr-v1.json',
            'DCLE'=>'fe-dcl-v1.json',
            'FE'=>'fe-fc-v1.json',
            'FEXE'=>'fe-fex-v1.json',
            'FSEE'=>'fe-fse-v1.json',
            'NCE'=>'fe-nc-v3.json',
            'NDE'=>'fe-nd-v3.json',
            'NRE'=>'fe-nr-v3.json',
            'CANCEL'=>'anulacion-schema-v2.json',
            'CONTINGENCY'=>'contingencia-schema-v3.json'
        ][$type];

        $path=__DIR__."/resources/schemas/".$fileName;
        if(!file_exists($path)){
            throw new NotFoundFileException();
        }
        return $path;
    }catch (\Exception $exception){
        Log::error($exception->getMessage());
        return null;
    }

    }

}
