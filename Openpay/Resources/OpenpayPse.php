<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;

class OpenpayPse extends OpenpayApiResourceBase
{

    protected $authorization;
    protected $creation_date;
    protected $currency;
    protected $customer_id;
    protected $operation_type;
    protected $status;
    protected $transaction_type;
    protected $derivedResources = array();

}

?>
