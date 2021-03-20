<?php

/**
 * Openpay API v1 Client for PHP (version 2.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;

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
