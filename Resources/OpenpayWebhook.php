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

class OpenpayWebhook extends OpenpayApiResourceBase
{

    protected $url;
    protected $event_types;

    public function save() {
        return $this->_update();
    }

    public function delete() {
        $this->_delete();
    }

}

?>