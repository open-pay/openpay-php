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

class OpenpayPlan extends OpenpayApiResourceBase {
	protected $creation_date;
	protected $currency;
	protected $amount;
	protected $repeat_every;
	protected $repeat_unit;
	protected $retry_times;
	protected $status;
	protected $status_after_retry;

	protected $derivedResources = array('Subscription' => array());

	public function save() {
		return $this->_update();
	}
	public function delete() {
		$this->_delete();
	}
}
// ----------------------------------------------------------------------------
class OpenpayPlanList extends OpenpayApiDerivedResource {
}
?>