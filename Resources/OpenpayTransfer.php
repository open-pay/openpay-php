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

class OpenpayTransfer extends OpenpayApiResourceBase {
	protected $authorization;
	protected $creation_date;
	protected $currency;
	protected $operation_type;
	protected $status;
	protected $transaction_type;
	protected $error_message;
	protected $method;
}
