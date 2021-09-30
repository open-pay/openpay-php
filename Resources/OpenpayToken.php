<?php

/**
 * Openpay API v1 Client for PHP (version 2.2.*)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;

class OpenpayToken extends OpenpayApiResourceBase
{
    protected $card;

    public function get($param) {
        return $this->_getAttributes($param);
    }
}

?>