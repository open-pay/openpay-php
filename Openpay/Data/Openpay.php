<?php

namespace Openpay\Data;

class Openpay
{

    private static $instance = null;
    private static $id;
    private static $apiKey;
    private static $userAgent = '';
    private static $country;
    private static $apiEndpoint = '';
    private static $apiSandboxEndpoint = '';
    private static $sandboxMode = true;
    private static $classification = '';
    private static $publicIp;

    public function __construct()
    {

    }

    public static function getInstance($id, $apiKey, $country, $publicIp)
    {
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
        if(!is_null($publicIp)){
            self::setPublicIp($publicIp);
        }
        $instance = OpenpayApi::getInstance(null);
        return $instance;
    }

    public static function setUserAgent($userAgent)
    {
        if ($userAgent != '') {
            self::$userAgent = $userAgent;
        }
    }

    public static function getUserAgent()
    {
        $userAgent = self::$userAgent;
        return $userAgent;
    }

    public static function setClassificationMerchant($classification)
    {
        if ($classification != '') {
            self::$classification = $classification;
        }
    }

    public static function getClassificationMerchant()
    {
        $classification = self::$classification;
        return $classification;
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

    public static function setCountry($country = '')
    {
        if ($country != '') {
            self::$country = $country;
        }
    }

    public static function getCountry()
    {
        $country = self::$country;
        return $country;
    }

    public static function getId()
    {
        $id = self::$id;
        if (!$id) {
            $id = getenv('OPENPAY_MERCHANT_ID');
        }
        return $id;
    }

    public static function setPublicIp($publicIp = null)
    {
        if (!is_null($publicIp)) {
            self::$publicIp = $publicIp;
        }
    }

    public static function getPublicIp() {
        return self::$publicIp;

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

    public static function setEndpointUrl($country)
    {
        if ($country == 'MX') {
            if (self::getClassificationMerchant() != 'eglobal') {
                self::$apiEndpoint = 'https://api.openpay.mx/v1';
                self::$apiSandboxEndpoint = 'https://sandbox-api.openpay.mx/v1';
            } else {
                self::$apiEndpoint = 'https://api.ecommercebbva.com/v1';
                self::$apiSandboxEndpoint = 'https://sand-api.ecommercebbva.com/v1';
            }
        } elseif ($country == 'CO') {
            self::$apiEndpoint = 'https://api.openpay.co/v1';
            self::$apiSandboxEndpoint = 'https://sandbox-api.openpay.co/v1';
        } elseif ($country == 'PE') {
            self::$apiEndpoint = 'https://api.openpay.pe/v1';
            self::$apiSandboxEndpoint = 'https://sandbox-api.openpay.pe/v1';
        }
    }

    public static function getEndpointUrl()
    {
        return (self::getSandboxMode() ? self::$apiSandboxEndpoint : self::$apiEndpoint);
    }

}
