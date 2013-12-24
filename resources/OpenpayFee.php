<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

class OpenpayFee extends OpenpayApiResourceBase {
	protected $authorization;
	protected $creation_date;
	protected $currency;
	protected $operation_type;
	protected $status;
	protected $transaction_type;
	protected $error_message;
	protected $method;
}
// ----------------------------------------------------------------------------
class OpenpayFeeList extends OpenpayApiDerivedResource {
	public function create($params) {
		return $this->add($params);
	}
	public function get($params) {
		// TODO: throw exception
		return null;
	}
}
?>