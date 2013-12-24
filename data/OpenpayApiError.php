<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

class OpenpayApiError extends Exception {
	protected $description;
	protected $error_code;
	protected $category;
	protected $http_code;
	protected $request_id;
	
	public function __construct($message=null, $error_code=null, $category=null, $request_id=null, $http_code=null) {
	    parent::__construct($message, $error_code);
	    $this->description = $message;
	    $this->error_code  = isset($error_code) ? $error_code : 0;
	    $this->category    = isset($category) ? $category : '';
	    $this->http_code   = isset($http_code) ? $http_code : 0;
	    $this->request_id  = isset($request_id) ? $request_id : '';
	}
	public function getDescription() {
		return $this->description;
	}
	public function getErrorCode() {
		return $this->error_code;
	}
	public function getCategory() {
		return $this->category;
	}
	public function getHttpCode() {
		return $this->http_code;
	}
	public function getRequestId() {
		return $this->request_id;
	}
}

// Authentication related Errors
class OpenpayApiAuthError extends OpenpayApiError {
}

// Request related Error
class OpenpayApiRequestError extends OpenpayApiError {
}
// Transaction related Errors
class OpenpayApiTransactionError extends OpenpayApiError {
}

// Connection related Errors
class OpenpayApiConnectionError extends OpenpayApiError {
}
