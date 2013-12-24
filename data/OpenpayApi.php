<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

class Openpay {
	private static $instance = null;
	private static $id = '';
	private static $apiKey = '';
	private static $apiEndpoint = 'https://api.openpay.mx/v1';
	private static $apiSandboxEndpoint = 'https://sandbox-api.openpay.mx/v1';
	private static $sandboxMode = false;

	private function __construct() {
	}
	public static function getInstance($id = '', $apiKey = '') {
		if ($id != '') {
			self::setId($id);
		}
		if ($apiKey != '') {
			self::setApiKey($apiKey);
		}

		$instance = OpenpayApi::getInstance();
		return $instance;
	}
	public static function setApiKey($key = '') {
		if ($key != '') {
			self::$apiKey = $key;
		}
	}
	public static function getApiKey() {
		$key = self::$apiKey;
		if (!$key) {
			$key = getenv('OPENPAY_API_KEY');
		}
		return $key;
	}
	public static function setId($id = '') {
		if ($id != '') {
			self::$id = $id;
		}
	}
	public static function getId() {
		$id = self::$id;
		if (!$id) {
			$id = getenv('OPENPAY_MERCHANT_ID');
		}
		return $id;
	}
	public static function setSandboxMode($mode) {
		self::$sandboxMode = $mode ? true : false;
	}
	public static function getSandboxMode() {
		$sandbox = self::$sandboxMode;
		if (getenv('OPENPAY_SANDBOX')) {
			$sandbox = (strtoupper(getenv('OPENPAY_SANDBOX')) == 'TRUE');
		}
		return $sandbox;
	}
	public static function getEndpointUrl() {
		return (self::getSandboxMode() ? self::$apiSandboxEndpoint : self::$apiEndpoint);
	}

}

// ----------------------------------------------------------------------------

class OpenpayApi extends OpenpayApiResourceBase {
	protected $derivedResources = array('Customer' => array(),
			'Card' => array(),
			'Charge' => array(),
			'Payout' => array(),
			'Fee' => array(),
			'Plan' => array());

	public static function getInstance() {
		$resourceName = get_class();
		return parent::getInstance($resourceName);
	}
	protected function getResourceUrlName(){
		return '';
	}
	public function getFullURL() {
		return $this->getUrl();
	}
}
?>