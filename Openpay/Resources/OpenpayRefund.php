<?php

namespace Openpay\Resources;

use Openpay\Data\OpenpayApiResourceBase;

class OpenpayRefund extends OpenpayApiResourceBase {
	protected function getResourceUrlName($p = true){
		return parent::getResourceUrlName(false);
	}
}
?>
