<?php

/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
class OpenpayPse extends OpenpayApiResourceBase
{

    protected $authorization;
    protected $creation_date;
    protected $currency;
    protected $customer_id;
    protected $operation_type;
    protected $status;
    protected $transaction_type;
    protected $redirect_url;
    // temporal hack
    // TODO: checar porque no instancia Openpaycard al recibir el parametro
    protected $card;
    protected $derivedResources = array('Pse' => array());

    public function create($params) {
        $resource = $this->derivedResources['pses'];
        if ($resource) {
            return parent::_create($resource->resourceName, $params, array('parent' => $this));
        }
    }
    
}

// ----------------------------------------------------------------------------
class OpenpayPseList extends OpenpayApiDerivedResource
{

    public function create($params) {
        return $this->add($params);
    }

}

?>