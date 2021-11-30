<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;
use Openpay\Data\OpenpayApiDerivedResource;

class OpenpayCustomer extends OpenpayApiResourceBase {

    protected $status;
    protected $creation_date;
    protected $balance;
    protected $clabe;
    protected $derivedResources = array(
        'Card' => array(),
        'BankAccount' => array(),
        'Charge' => array(),
        'Pse' => array(),
        'Transfer' => array(),
        'Payout' => array(),
        'Subscription' => array());

    public function save() {
        return $this->_update();
    }

    public function delete() {
        $this->_delete();
    }

}


?>
