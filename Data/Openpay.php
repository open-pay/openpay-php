<?php

namespace Openpay\Data;

class Openpay
{
    private static $id = '';
    private static $apiKey = '';
    private static $userAgent = '';
    private static $apiEndpoint = 'https://api.openpay.mx/v1';
    private static $apiSandboxEndpoint = 'https://sandbox-api.openpay.mx/v1';
    private static $sandboxMode = true;

    public function __construct()
    {
    }

    public static function getInstance($id = '', $apiKey = '')
    {
        if ($id != '') {
            self::setId($id);
        }
        if ($apiKey != '') {
            self::setApiKey($apiKey);
        }
        return OpenpayApi::getInstance(null);
    }

    public static function setUserAgent($userAgent)
    {
        if ($userAgent != '') {
            self::$userAgent = $userAgent;
        }
    }

    public static function getUserAgent()
    {
        return self::$userAgent;
    }

    public static function setApiKey($key = '')
    {
        if ($key != '') {
            self::$apiKey = $key;
        }
    }

    public static function getApiKey()
    {
        $key = self::$apiKey;
        if (!$key) {
            $key = getenv('OPENPAY_API_KEY');
        }
        return $key;
    }

    public static function setId($id = '')
    {
        if ($id != '') {
            self::$id = $id;
        }
    }

    public static function getId()
    {
        $id = self::$id;
        if (!$id) {
            $id = getenv('OPENPAY_MERCHANT_ID');
        }
        return $id;
    }

    public static function getSandboxMode()
    {
        $sandbox = self::$sandboxMode;
        if (getenv('OPENPAY_PRODUCTION_MODE')) {
            $sandbox = (strtoupper(getenv('OPENPAY_PRODUCTION_MODE')) == 'FALSE');
        }
        return $sandbox;
    }

    public static function setSandboxMode($mode)
    {
        self::$sandboxMode = $mode ? true : false;
    }

    public static function getProductionMode()
    {
        $sandbox = self::$sandboxMode;
        if (getenv('OPENPAY_PRODUCTION_MODE')) {
            $sandbox = (strtoupper(getenv('OPENPAY_PRODUCTION_MODE')) == 'FALSE');
        }
        return !$sandbox;
    }

    public static function setProductionMode($mode)
    {
        self::$sandboxMode = $mode ? false : true;
    }

    public static function getEndpointUrl()
    {
        return (self::getSandboxMode() ? self::$apiSandboxEndpoint : self::$apiEndpoint);
    }
}
