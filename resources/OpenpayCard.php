<?php

/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
class OpenpayCard extends OpenpayApiResourceBase
{

    protected $type;
    protected $brand;
    protected $allows_charges;
    protected $allows_payouts;
    protected $creation_date;
    protected $bank_name;
    protected $bank_code;
    protected $customer_id;

    public function delete() {
        $this->_delete();
    }

    public function get($param) {
        return $this->_getAttributes($param);
    }

}

// ----------------------------------------------------------------------------
class OpenpayCardList extends OpenpayApiDerivedResource
{
    
}

?>