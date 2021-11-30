<?php

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

?>
