<?php

namespace Openpay\Resources;


use Openpay\Data\OpenpayApiResourceBase;
use Openpay\Data\OpenpayApiDerivedResource;

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

	public function __set($key, $value) {

		if ($key == 'source_id') {
			if (!array_key_exists($key, $this->serializableData)) {
				$this->serializableData['source_id'] = $value;
			}
		} else {
			parent::__set($key, $value);
		}
	}
}
?>
