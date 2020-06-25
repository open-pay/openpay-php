<?php 
/**
 * Openpay API v1 Client for PHP (version 2.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */

if (!function_exists('curl_init')) {
	throw new Exception('CURL PHP extension is required to run Openpay client.');
}
if (!function_exists('json_decode')) {
	throw new Exception('JSON PHP extension is required to run Openpay client.');
}
if (!function_exists('mb_detect_encoding')) {
	throw new Exception('Multibyte String PHP extension is required to run Openpay client.');
}

?>
