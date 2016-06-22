<?php 
/**
 * Openpay API v1 Client for PHP (version 1.0.0)
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

require(dirname(__FILE__) . '/data/OpenpayApiError.php');
require(dirname(__FILE__) . '/data/OpenpayApiConsole.php');
require(dirname(__FILE__) . '/data/OpenpayApiResourceBase.php');
require(dirname(__FILE__) . '/data/OpenpayApiConnector.php');
require(dirname(__FILE__) . '/data/OpenpayApiDerivedResource.php');
require(dirname(__FILE__) . '/data/OpenpayApi.php');

require(dirname(__FILE__) . '/resources/OpenpayBankAccount.php');
require(dirname(__FILE__) . '/resources/OpenpayCapture.php');
require(dirname(__FILE__) . '/resources/OpenpayCard.php');
require(dirname(__FILE__) . '/resources/OpenpayCharge.php');
require(dirname(__FILE__) . '/resources/OpenpayCustomer.php');
require(dirname(__FILE__) . '/resources/OpenpayFee.php');
require(dirname(__FILE__) . '/resources/OpenpayPayout.php');
require(dirname(__FILE__) . '/resources/OpenpayPlan.php');
require(dirname(__FILE__) . '/resources/OpenpayRefund.php');
require(dirname(__FILE__) . '/resources/OpenpaySubscription.php');
require(dirname(__FILE__) . '/resources/OpenpayTransfer.php');
require(dirname(__FILE__) . '/resources/OpenpayWebhook.php');
require(dirname(__FILE__) . '/resources/OpenpayToken.php');
?>
