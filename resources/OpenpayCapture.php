<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

class OpenpayCapture extends OpenpayApiResourceBase {
	protected function getResourceUrlName($p = true){
		return parent::getResourceUrlName(false);
	}
}
?>