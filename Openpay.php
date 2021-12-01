<?php
/**
 * Openpay API v1 Client for PHP (version 2.1.0)
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

require(dirname(__FILE__) . '/Openpay/Data/Openpay.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApi.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiAuthError.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiConnectionError.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiConnector.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiConsole.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiDerivedResource.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiError.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiRequestError.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiResourceBase.php');
require(dirname(__FILE__) . '/Openpay/Data/OpenpayApiTransactionError.php');


require(dirname(__FILE__) . '/Openpay/Resources/OpenpayBankAccount.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayBankAccountList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayBine.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayCapture.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayCard.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayCardList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayCharge.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayChargeList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayCustomer.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayCustomerList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayFee.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayFeeList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayPayout.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayPayoutList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayPlan.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayPlanList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayPse.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayPseList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayRefund.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpaySubscription.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpaySubscriptionList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayToken.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayTransfer.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayTransferList.php');
require(dirname(__FILE__) . '/Openpay/Resources/OpenpayWebhook.php');
?>
