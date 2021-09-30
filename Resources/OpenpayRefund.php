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

class OpenpayRefund extends OpenpayApiResourceBase {
	protected function getResourceUrlName($p = true){
		return parent::getResourceUrlName(false);
	}
}
?>