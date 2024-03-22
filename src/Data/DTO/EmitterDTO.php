<?php

namespace Momotolabs\Mhbiller\Data\DTO;

class EmitterDTO
{
    public $nit;
    public $nrc;
    public $name;
    public $activityCode;
    public $activityDescription;
    public $tradeName;
    public $establishmentType;
    public $address;
    public $phone;
    public $establishmentCodeMH;
    public $establishmentCode;
    public $pointOfSaleCodeMH;
    public $pointOfSaleCode;
    public $email;

    public function __construct($data) {
        $this->nit = $data["nit"];
        $this->nrc = $data["nrc"];
        $this->name = $data["name"];
        $this->activityCode = $data["activityCode"];
        $this->activityDescription = $data["activityDescription"];
        $this->tradeName = $data["tradeName"];
        $this->establishmentType = $data["establishmentType"];
        $this->address = new AddressDTO($data["address"]);
        $this->phone = $data["phone"];
        $this->establishmentCodeMH = $data["establishmentCodeMH"];
        $this->establishmentCode = $data["establishmentCode"];
        $this->pointOfSaleCodeMH = $data["pointOfSaleCodeMH"];
        $this->pointOfSaleCode = $data["pointOfSaleCode"];
        $this->email = $data["email"];
    }

}
