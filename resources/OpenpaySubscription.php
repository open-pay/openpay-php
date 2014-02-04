<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

class OpenpaySubscription extends OpenpayApiResourceBase {
	protected $status;
	protected $charge_date;
	protected $creation_date;
	protected $current_period_number;
	protected $period_end_date;
	protected $plan_id;
	protected $customer_id;

	// temporal hack
	// TODO: checar porque no instancia Openpaycard al recibir el parametro
	protected $card;

	public function save() {
		return $this->_update();
	}
	public function delete() {
		$this->_delete();
	}
}
// ----------------------------------------------------------------------------
class OpenpaySubscriptionList extends OpenpayApiDerivedResource {
	public function create($params) {
		return $this->add($params);
	}
}
?>