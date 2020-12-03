<?php

/**
 * Openpay API v1 Client for PHP (version 2.0.0)
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
    private static $userAgent = '';
    private static $country = 'MX';
    private static $apiEndpoint = '';
    private static $apiSandboxEndpoint = '';
    private static $sandboxMode = true;
    private static $classification = '';

    public function __construct() {
        
    }

    public static function getInstance($id = '', $apiKey = '', $country = 'MX') {
        if ($id != '') {
            self::setId($id);
        }
        if ($apiKey != '') {
            self::setApiKey($apiKey);
        }
        if ($country != '') {
            self::setCountry($country);
            self::setEndpointUrl($country);
        }
        $instance = OpenpayApi::getInstance(null);
        return $instance;
    }

    public static function setUserAgent($userAgent){
        if ($userAgent != '') {
            self::$userAgent = $userAgent;
        }
    }

    public static function getUserAgent(){
        $userAgent = self::$userAgent; 
        return $userAgent;
    }

    public static function setClassificationMerchant($classification){
        if ($classification != '') {
            self::$classification = $classification;
        }
    }

    public static function getClassificationMerchant(){
        $classification = self::$classification; 
        return $classification;
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

    public static function setCountry($country = ''){
        if ($country != '') {
            self::$country = $country;
        }
    }

    public static function getCountry(){
        $country = self::$country;
        return $country;
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

    public static function setEndpointUrl($country){
        if($country == 'MX'){
            if(self::getClassificationMerchant() != 'eglobal'){
                self::$apiEndpoint = 'https://api.openpay.mx/v1';
                self::$apiSandboxEndpoint = 'https://sandbox-api.openpay.mx/v1';
            }else{
                self::$apiEndpoint = 'https://api.ecommercebbva.com/v1';
                self::$apiSandboxEndpoint = 'https://sand-api.ecommercebbva.com/v1';
            }
        }elseif($country == 'CO'){
            self::$apiEndpoint = 'https://api.openpay.co/v1';
            self::$apiSandboxEndpoint = 'https://sandbox-api.openpay.co/v1';
        }
    }
    public static function getEndpointUrl() {
        return (self::getSandboxMode() ? self::$apiSandboxEndpoint : self::$apiEndpoint);
    }

}

// ----------------------------------------------------------------------------
class OpenpayApi extends OpenpayApiResourceBase
{

    protected $derivedResources = array(
        'Bine' => array(),
        'Customer' => array(),
        'Card' => array(),
        'Charge' => array(),
        'Pse' => array(),
        'Payout' => array(),
        'Fee' => array(),
        'Plan' => array(),
        'Webhook' => array(),
        'Token' => array());

    public static function getInstance($r, $p = null) {
        $resourceName = get_class();
        return parent::getInstance($resourceName);
    }

    public function getMerchantInfo(){
        return parent::getMerchantInfo();
    }

    protected function getResourceUrlName($p = true) {
        return '';
    }

    public function getFullURL() {
        return $this->getUrl();
    }

}

?>