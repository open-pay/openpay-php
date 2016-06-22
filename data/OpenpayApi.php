<?php

/**
 * Openpay API v1 Client for PHP (version 1.0.3)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
class Openpay
{

    private static $instance = null;
    private static $id = '';
    private static $apiKey = '';
    private static $apiEndpoint = 'https://api.openpay.mx/v1';
    private static $apiSandboxEndpoint = 'https://sandbox-api.openpay.mx/v1';
    private static $sandboxMode = true;

    public function __construct() {
        
    }

    public static function getInstance($id = '', $apiKey = '') {
        if ($id != '') {
            self::setId($id);
        }
        if ($apiKey != '') {
            self::setApiKey($apiKey);
        }
        $instance = OpenpayApi::getInstance(null);
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

    public static function getSandboxMode() {
        $sandbox = self::$sandboxMode;
        if (getenv('OPENPAY_PRODUCTION_MODE')) {
            $sandbox = (strtoupper(getenv('OPENPAY_PRODUCTION_MODE')) == 'FALSE');
        }
        return $sandbox;
    }

    public static function setSandboxMode($mode) {
        self::$sandboxMode = $mode ? true : false;
    }

    public static function getProductionMode() {
        $sandbox = self::$sandboxMode;
        if (getenv('OPENPAY_PRODUCTION_MODE')) {
            $sandbox = (strtoupper(getenv('OPENPAY_PRODUCTION_MODE')) == 'FALSE');
        }
        return !$sandbox;
    }

    public static function setProductionMode($mode) {
        self::$sandboxMode = $mode ? false : true;
    }

    public static function getEndpointUrl() {
        return (self::getSandboxMode() ? self::$apiSandboxEndpoint : self::$apiEndpoint);
    }

}

// ----------------------------------------------------------------------------
class OpenpayApi extends OpenpayApiResourceBase
{

    protected $derivedResources = array('Customer' => array(),
        'Card' => array(),
        'Charge' => array(),
        'Payout' => array(),
        'Fee' => array(),
        'Plan' => array(),
        'Webhook' => array(),
        'Token' => array());

    public static function getInstance($r, $p = null) {
        $resourceName = get_class();
        return parent::getInstance($resourceName);
    }

    protected function getResourceUrlName($p = true) {
        return '';
    }

    public function getFullURL() {
        return $this->getUrl();
    }

}

?>