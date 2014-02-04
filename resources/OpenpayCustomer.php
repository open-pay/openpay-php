<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

class OpenpayCustomer extends OpenpayApiResourceBase {
	protected $status;
	protected $creation_date;
	protected $balance;
	protected $clabe;
	protected $derivedResources = array('Card' => array(), 
										'BankAccount' => array(), 
										'Charge' => array(), 
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
// ----------------------------------------------------------------------------
class OpenpayCustomerList extends OpenpayApiDerivedResource {
}
?>