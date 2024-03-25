<?php

namespace Momotolabs\Mhbiller\DTE;

use Momotolabs\Mhbiller\Helpers\DTEHelper;

class FE extends DocumentBase implements TaxDocument
{
    protected $helper;

    public function __construct(string $type)
    {
        parent::__construct($type);
        $this->helper = new DTEHelper();
    }

    public function generateJson(array $data): string
    {
        $baseData = [
            'typeModel' => 1,
            'typeOperation' => 1
        ];
        return json_encode([
            "identificacion" => $this->getIdentification($baseData),
            "documentoRelacionado" => $this->documentRelated($data),
            "emisor" => $this->getEmitter($data),
            "receptor" => $this->setReceiver($data['receiver']),
            "otrosDocumentos" => $this->helper->otherDocs($data),
            "ventaTercero" => $this->helper->thirdSale($data),
            "cuerpoDocumento" => $this->setBodyBill($data),
            "resumen" => $this->generateResume($data),
            "extension" => $this->generateExtension($data),
            "apendice" => null
        ]);


    }

}
