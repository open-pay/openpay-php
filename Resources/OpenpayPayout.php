<?php 
/**
 * Openpay API v1 Client for PHP (version 2.2.*)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;
use Openpay\Data\OpenpayApiDerivedResource;

class OpenpayPayout extends OpenpayApiResourceBase {
	protected $authorization;
	protected $creation_date;
	protected $currency;
	protected $operation_type;
	protected $status;
	protected $transaction_type;
	protected $error_message;
	protected $method;

	// temporal hack
	// TODO: checar porque no instancia Openpaycard al recibir el parametro
	protected $card;
}
// ----------------------------------------------------------------------------
class OpenpayPayoutList extends OpenpayApiDerivedResource {
	public function create($params) {
		return $this->add($params);
	}
}
?>