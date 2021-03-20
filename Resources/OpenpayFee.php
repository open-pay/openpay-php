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

class OpenpayFee extends OpenpayApiResourceBase
{
    protected $authorization;
    protected $creation_date;
    protected $currency;
    protected $operation_type;
    protected $status;
    protected $transaction_type;
    protected $error_message;
    protected $method;    
    protected $derivedResources = array('Refund' => null);

    public function refund($params) {
        $resource = $this->derivedResources['refunds'];
        if ($resource) {
            return parent::_create($resource->resourceName, $params, array('parent' => $this));
        }
        return null;
    }
}
