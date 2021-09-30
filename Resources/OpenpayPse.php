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
use Openpay\Data\OpenpayApiDerivedResource;

class OpenpayPse extends OpenpayApiResourceBase {

    protected $authorization;
    protected $creation_date;
    protected $currency;
    protected $customer_id;
    protected $operation_type;
    protected $status;
    protected $transaction_type;
    protected $derivedResources = array();    

}

// ----------------------------------------------------------------------------
class OpenpayPseList extends OpenpayApiDerivedResource {

    public function create($params) {
        return $this->add($params);
    }

}

?>