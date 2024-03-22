<?php

namespace Momotolabs\Mhbiller\Data\DTO;


class AddressDTO {
    public $department;
    public $municipality;
    public $complement;

    public function __construct($addressData) {
        $this->department = $addressData["department"];
        $this->municipality = $addressData["municipality"];
        $this->complement = $addressData["complement"];
    }
}
