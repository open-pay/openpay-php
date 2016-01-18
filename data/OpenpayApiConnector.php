<?php

/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
class OpenpayApiConnector
{

    private static $instance;
    private $apiKey;

    private function __construct() {
        $this->apiKey = '';
    }

    private static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // ---------------------------------------------------------
    // ------------------  PRIVATE FUNCTIONS  ------------------

    private function _request($method, $url, $params) {
        if (!class_exists('Openpay')) {
            throw new OpenpayApiError("Library install error, there are some missing classes");
        }
        OpenpayConsole::trace('OpenpayApiConnector @_request');

        $myId = Openpay::getId();
        if (!$myId) {
            throw new OpenpayApiAuthError("Empty or no Merchant ID provided");
        } else if (!preg_match('/^[a-z0-9]{20}$/i', $myId)) {
            throw new OpenpayApiAuthError("Invalid Merchant ID '".$myId."'");
        }

        $myApiKey = Openpay::getApiKey();
        if (!$myApiKey) {
            throw new OpenpayApiAuthError("Empty or no Private Key provided");
        } else if (!preg_match('/^sk_[a-z0-9]{32}$/i', $myApiKey)) {
            throw new OpenpayApiAuthError("Invalid Private Key '".$myApiKey."'");
        }

        $absUrl = Openpay::getEndpointUrl();
        if (!$absUrl) {
            throw new OpenpayApiConnectionError("No API endpoint set");
        }
        $absUrl .= '/'.$myId.$url;

        //$params = self::_encodeObjects($params);
        $headers = array('User-Agent: OpenpayPhp/v1');

        list($rbody, $rcode) = $this->_curlRequest($method, $absUrl, $headers, $params, $myApiKey);
        return $this->interpretResponse($rbody, $rcode);
    }

    private function _curlRequest($method, $absUrl, $headers, $params, $auth = null) {
        OpenpayConsole::trace('OpenpayApiConnector @_curlRequest');

        $opts = array();
        if (!is_array($headers)) {
            $headers = array();
        }

        if ($method == 'get') {
            $opts[CURLOPT_HTTPGET] = 1;
            if (count($params) > 0) {
                $encoded = $this->encodeToQueryString($params);
                $absUrl = $absUrl.'?'.$encoded;
            }
        } else if ($method == 'post') {
            $data = $this->encodeToJson($params);
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $data;
            array_push($headers, 'Content-Type: application/json');
            array_push($headers, 'Content-Length: '.strlen($data));
        } else if ($method == 'put') {
            $data = $this->encodeToJson($params);
            $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $opts[CURLOPT_POSTFIELDS] = $data;
            array_push($headers, 'Content-Type: application/json');
            array_push($headers, 'Content-Length: '.strlen($data));
        } else if ($method == 'delete') {
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            if (count($params) > 0) {
                $encoded = $this->encodeToQueryString($params);
                $absUrl = $absUrl.'?'.$encoded;
            }
        } else {
            throw new OpenpayApiError("Invalid request method '".$method."'");
        }


        $opts[CURLOPT_URL] = $absUrl;
        $opts[CURLOPT_RETURNTRANSFER] = TRUE;
        $opts[CURLOPT_CONNECTTIMEOUT] = 30;
        $opts[CURLOPT_TIMEOUT] = 80;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_SSL_VERIFYPEER] = TRUE;

        if ($auth) {
            $opts[CURLOPT_USERPWD] = $auth.':';
        }

        $curl = curl_init();
        curl_setopt_array($curl, $opts);

        OpenpayConsole::debug('Executing cURL: '.strtoupper($method).' > '.$absUrl);

        $rbody = curl_exec($curl);
        $errorCode = curl_errno($curl);

        // if request fails because bad certificate verification, then
        // retry the request by using the CA certificates bundle
        // CURLE_SSL_CACERT || CURLE_SSL_CACERT_BADFILE
        if ($errorCode == 60 || $errorCode == 77) {
            curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__).'/cacert.pem');
            $rbody = curl_exec($curl);
        }

        if ($rbody === false) {
            OpenpayConsole::error('cURL request error: '.curl_errno($curl));
            $message = curl_error($curl);
            $errorCode = curl_errno($curl);
            curl_close($curl);

            $this->handleCurlError($errorCode, $message);
        }
        $rcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (mb_detect_encoding($rbody, 'UTF-8', true) != 'UTF-8') {
            OpenpayConsole::warn('Response body is not an UTF-8 string');
        }

        OpenpayConsole::debug('cURL body: '.$rbody);
        OpenpayConsole::debug('cURL code: '.$rcode);

        return array($rbody, $rcode);
    }

    private function encodeToQueryString($arr, $prefix = null) {
        if (!is_array($arr))
            return $arr;

        $r = array();
        foreach ($arr as $k => $v) {
            if (is_null($v))
                continue;

            if ($prefix && $k && !is_int($k))
                $k = $prefix."[".$k."]";
            else if ($prefix)
                $k = $prefix."[]";

            if (is_array($v)) {
                $r[] = $this->encodeToQueryString($v, $k, true);
            } else {
                $r[] = urlencode($k)."=".urlencode($v);
            }
        }
        $string = implode("&", $r);
        OpenpayConsole::debug('Query string: '.$string);
        return $string;
    }

    private function encodeToJson($arr) {
        $encoded = json_encode($arr);
        if (mb_detect_encoding($encoded, 'UTF-8', true) != 'UTF-8') {
            $encoded = utf8_encode($encoded);
        }
        OpenpayConsole::debug('JSON UTF8 string: '.$encoded);
        return $encoded;
    }

    private function interpretResponse($responseBody, $responseCode) {
        OpenpayConsole::trace('OpenpayApiConnector @interpretResponse');
        try {
            // return json as an array NOT an object
            if (!empty($responseBody)) {
                $traslatedResponse = json_decode($responseBody, true);
            } else {
                $traslatedResponse = array();
            }
        } catch (Exception $e) {
            throw new OpenpayApiRequestError("Invalid response: ".$responseBody, $responseCode);
        }

        if ($responseCode < 200 || $responseCode >= 300) {
            OpenpayConsole::error('Request finished with HTTP code '.$responseCode);
            $this->handleRequestError($responseBody, $responseCode, $traslatedResponse);
            return array();
        }
        return $traslatedResponse;
    }

    private function handleRequestError($responseBody, $responseCode, $traslatedResponse) {
        if (!is_array($traslatedResponse) || !isset($traslatedResponse['error_code'])) {
            throw new OpenpayApiRequestError("Invalid response body received from Openpay API Server");
        }

        $message = isset($traslatedResponse['description']) ? $traslatedResponse['description'] : 'No description';
        $error = $traslatedResponse['error_code'];
        $category = isset($traslatedResponse['category']) ? $traslatedResponse['category'] : null;
        $request_id = isset($traslatedResponse['request_id']) ? $traslatedResponse['request_id'] : null;

        switch ($responseCode) {

            // Unauthorized - Forbidden
            case 401:
            case 403:
                throw new OpenpayApiAuthError($message, $error, $category, $request_id, $responseCode);
                break;

            // Bad Request - Request Entity too large - Request Entity too large - Internal Server Error - Service Unavailable
            case 400:
            case 404:
            case 413:
            case 422:
            case 500:
            case 503:
                throw new OpenpayApiRequestError($message, $error, $category, $request_id, $responseCode);
                break;

            // Payment Required - Conflict - Preconditon Failed - Unprocessable Entity - Locked
            case 402:
            case 409:
            case 412:
            case 423:
                throw new OpenpayApiTransactionError($message, $error, $category, $request_id, $responseCode);
                break;

            // Not Found
            default:
                throw new OpenpayApiError($message, $error, $category, $request_id, $responseCode);
        }
    }

    private function handleCurlError($errorCode, $message) {
        switch ($errorCode) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = "Could not connect to Openpay.  Please check your internet connection and try again";
                break;
            default:
                $msg = "Unexpected error connecting to Openpay";
        }

        $msg .= " (Network error ".$errorCode.")";
        throw new OpenpayApiConnectionError($msg);
    }

    // ---------------------------------------------------------
    // ------------------  PUBLIC FUNCTIONS  -------------------

    public static function request($method, $url, $params = null) {
        OpenpayConsole::trace('OpenpayApiConnector @request '.$url);

        if (!$params) {
            $params = array();
        }

        $method = strtolower($method);
        if (!in_array($method, array('get', 'post', 'delete', 'put'))) {
            throw new OpenpayApiError("Invalid request method '".$method."'");
        }

        $connector = self::getInstance();
        return $connector->_request($method, $url, $params);
    }

}

?>