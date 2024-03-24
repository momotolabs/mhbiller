<?php

namespace Momotolabs\Mhbiller\DTE;

interface TaxDocument
{
    public function generateJson(array $data) :string ;

}
