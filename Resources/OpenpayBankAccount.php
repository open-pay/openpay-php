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

class OpenpayBankAccount extends OpenpayApiResourceBase {
	protected $bank_code;
	protected $bank_name;
	protected $creation_date;

	public function delete() {
		$this->_delete();
	}
}
