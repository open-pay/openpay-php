![Openpay PHP](http://www.openpay.mx/img/github/php.jpg)

PHP client for Openpay API services (version 1.1.1)

This is a client implementing the payment services for Openpay at openpay.mx

What's new?
-----------

02/06/2014 - Fixed: tried to add an optional derived resource when the object was null 
04/02/2014 - Added: support for Captures on charges
31/01/2014 - Fixed: Added classes and configs to avoid errors on PHP class autoload feature. Now 
the autoload is turned off by default
23/01/2014 - Added: the Sandbox Mode is the default now. Added a method to activate the Production
Mode explicitly.


Compatibility
-------------

PHP 5.2 or later 

Requirements
------------
PHP 5.2 or later 
cURL extension for PHP
JSON extension for PHP
Multibyte String extension for PHP

Installation
------------
### Composer
The preferred method is via [composer](https://getcomposer.org). Follow the
[installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have
composer installed.

Once composer is installed, execute the following command in your project root to install this library:

```sh
composer require openpay/sdk
```
Finally, be sure to include the autoloader:

```php
require_once '/path/to/your-project/vendor/autoload.php';
```

### Manual installation

To install, just:

  - Clone the repository or download the library and copy/create a folder named
    **'Openpay'** inside your project folder structure. If you downloaded the 
    client library as a compressed file, uncompress it and create the proper 
    folder structure.
  - At the top of the PHP script in which the client library will be used (or 
    in the section you include other libraries), add the client's library main
    script:
    
```php
require(dirname(__FILE__) . '/Openpay/Openpay.php');
```

> NOTE: In the example above, the library is located in the directory named 
> Openpay, located inside the same directory that the PHP file which is 
> including the cliente. Make sure to adjust the paths inside your project,
> otherwise the library will not work.

 
Implementation
--------------

#### Configuration #####

Before use the library will be necessary to set up your Merchant ID and
Private key. There are three options:

  - Use the methods **Openpay::setId()** and **Openpay::setApiKey()**. Just 
    pass the proper parameters to each function:
    
```php
Openpay::setId('moiep6umtcnanql3jrxp');
Openpay::setApiKey('sk_3433941e467c4875b178ce26348b0fac');
```
	
  - Pass Merchant ID and Private Key as parameters to the method **Openpay::getInstance()**,
    which is the instance generator:
    
```php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c4875b178ce26348b0fac');
```

  - Configure the Marchant ID and the Private Key as well, as environment 
    variables. This method has its own advantages as this sensitive data is not
    exposed directly in any script.
    
> NOTE: please, refer to PHP documentation for further information about this method.


##### Sandbox/Production Mode #####

By convenience and security, the sandbox mode is activated by default in the
client library. This allows you to test your own code when implementing
Openpay, before charging any credit card in production environment. Once you
have finished your integration, use the method **OpenPay::setProductionMode(FLAG)** which
will allow you to active/inactivate the sandbox mode.

````php
Openpay::setProductionMode(true);
````
Also you can use environment variables for this purpose:
````
SetEnv OPENPAY_PRODUCTION_MODE true
````

If its necessary, you can use the method **Openpay::getProductionMode()** to 
determine anytime, which is the sandbox mode status:

````php
// will return TRUE/FALSE, depending on if sandbox mode is activated or not.
Openpay::getProductionMode(); 
````

#### PHP client library intro #####

Once configured the library, you can use it to interact with Openpay API 
services. The first step is get an instance with the generator:

````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');
````

In this example **$openpay** will be an instance of a merchant (root), wich 
will be used to call any derived child resource. According to the current version 
of the Openpay API, these resources are:

  - customers
  - cards
  - charges
  - payouts
  - fees
  - plans

You can access all of these resources as public variables of the root instance, 
so, if you want to add a new customer you will be able to do it as follows:

````php
$openpay->customers->add(PARAMETERS);
````

Every call to any resource will return an instance of that resource. In the 
example above, calling the method **add()** in the resource **customers** will 
return an instance of Customer, calling the method **add()** in the resource **cards**
will return an instance of Card, and so on. The only exception occurs when you retrieve
a list of resources using the method **getList()**, in which case an array of 
instances will be returned:

````
// a SINGLE instance of Customer will be returned
$customer = $openpay->customers->add(PARAMETERS);


// an ARRAY of instances of Customers will be returned
customerList = $openpay->customers->getList(PARAMETERS);
````

On the other hand, the resources derived from Customer, according to Openpay 
API documentation, are:

  - cards
  - bankaccounts
  - charges
  - transfers
  - payouts
  - suscriptions

#### Parameters ####

Those methods which receive more than one parameter (for example, when trying 
to add a new customer or a new customer's card), must be passed
as associatives arrays:

````php
array('PARAMETER_INTEGER' => VALUE,
      'PARAMETER_STRING'  => 'VALUE');
      'PARAMETER_DERIVED' => array('PARAMETER_INTEGER' => VALUE), 
                                   'PARAMETER_STRING'  => 'VALUE'));
````

> NOTE: Please refer to Openpay API docuemntation to determine wich parameters 
> are accepted, wich required and which of those are optional, in every case. 


#### Error handling ####

The Openpay API generates several types of errors depending on the situation,
to handle this, the PHP client has implemented five type of exceptions:

  - **OpenpayApiTransactionError**. This category includes those errors ocurred when 
    the transaction does not complete successfully: declined card, insufficient
    funds, inactive destination account, etc.
  - **OpenpayApiRequestError**. It refers to errors generated when a request to the
    API fail. Examples: invalid format in data request, incorrect parameters in
    the request, Openpay internal servers errors, etc.
  - **OpenpayApiConnectionError**. These exceptions are generated when the library 
    try to connect to the API but fails in the attempt. For example: timeouts, 
    domain name servers, etc.
  - **OpenpayApiAuthError**. Errors which are generated when the authentication 
    data are specified in an invalid format or, if are not fully validated on
    the Openpay server (Merchant ID or Private Key).
  - **OpenpayApiError**. This category includes all generic errors when processing
    with the client library.

All these error exceptions make available all the information returned by the 
Openpay API, with the following methods:

  - **getDescription()**: Error description generated by Openpay server.
  - **getErrorCode()**: Error code generated by Openpay server. When the error
    is generated before the request, this value is equal to zero.
  - **getCategory()**: Error category generated and determined by Openpay server.
    When the error is generated before or during the request, this value is an 
    empty string.
  - **getHttpCode()**: HTTP error code generated when request the Openpay
    server. When the error is generated before or during the request, this 
    value is equal to zero.
  - **getRequestId()**: ID generated by the Openpay server when process a 
    request. When the error is generated before the request, this value is
    an empty string.

The following is an more complete example of error catching:

````php
try {
	Openpay::setProductionMode(true);
	
	// the following line will generate an error because the
	// private key is empty. The exception generated will be
	// a OpenpayApiAuthError
	$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', '');

	$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
 	$customer->name = 'Juan';
 	$customer->last_name = 'Godinez';
 	$customer->save();

} catch (OpenpayApiTransactionError $e) {
	error_log('ERROR on the transaction: ' . $e->getMessage() . 
	      ' [error code: ' . $e->getErrorCode() . 
	      ', error category: ' . $e->getCategory() . 
	      ', HTTP code: '. $e->getHttpCode() . 
	      ', request ID: ' . $e->getRequestId() . ']', 0);

} catch (OpenpayApiRequestError $e) {
	error_log('ERROR on the request: ' . $e->getMessage(), 0);

} catch (OpenpayApiConnectionError $e) {
	error_log('ERROR while connecting to the API: ' . $e->getMessage(), 0);

} catch (OpenpayApiAuthError $e) {
	error_log('ERROR on the authentication: ' . $e->getMessage(), 0);
	
} catch (OpenpayApiError $e) {
	error_log('ERROR on the API: ' . $e->getMessage(), 0);
	
} catch (Exception $e) {
	error_log('Error on the script: ' . $e->getMessage(), 0);
}
````

Examples
--------

#### Customers ####

Add a new customer to a merchant:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customerData = array(
	'name' => 'Teofilo',
	'last_name' => 'Velazco',
	'email' => 'teofilo@payments.com',
	'phone_number' => '4421112233',
	'address' => array(
			'line1' => 'Privada Rio No. 12',
			'line2' => 'Co. El Tintero',
			'line3' => '',
			'postal_code' => '76920',
			'state' => 'Querétaro',
			'city' => 'Querétaro.',
			'country_code' => 'MX'));

$customer = $openpay->customers->add($customerData);
````

Get a customer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
````

Get the list of customers:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customerList = $openpay->customers->getList($findData);
````

Update a customer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$customer->name = 'Juan';
$customer->last_name = 'Godinez';
$customer->save();
````

Delete a customer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$customer->delete();
````


#### Cards ####

**On a merchant:**

Add a card:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$cardData = array(
	'holder_name' => 'Luis Pérez',
	'card_number' => '4111111111111111',
	'cvv2' => '123',
	'expiration_month' => '12',
	'expiration_year' => '15',
	'address' => array(
		'line1' => 'Av. 5 de Febrero No. 1',
		'line2' => 'Col. Felipe Carrillo Puerto',
		'line3' => 'Zona industrial Carrillo Puerto',
		'postal_code' => '76920',
		'state' => 'Querétaro',
		'city' => 'Querétaro',
		'country_code' => 'MX'));

$card = $openpay->cards->add($cardData);
````

Get a card:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$card = $openpay->cards->get('k9pn8qtsvr7k7gxoq1r5');
````

Get the list of cards:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$cardList = $openpay->cards->getList($findData);
````

Delete a card:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$card = $openpay->cards->get('k9pn8qtsvr7k7gxoq1r5');
$card->delete();
````

**On a customer:**

Add a card:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$cardData = array(
	'holder_name' => 'Teofilo Velazco',
	'card_number' => '4916394462033681',
	'cvv2' => '123',
	'expiration_month' => '12',
	'expiration_year' => '15',
	'address' => array(
			'line1' => 'Privada Rio No. 12',
			'line2' => 'Co. El Tintero',
			'line3' => '',
			'postal_code' => '76920',
			'state' => 'Querétaro',
			'city' => 'Querétaro.',
			'country_code' => 'MX'));

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$card = $customer->cards->add($cardData);
````

Get a card:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$card = $customer->cards->get('k9pn8qtsvr7k7gxoq1r5');
````

Get the list of cards:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$cardList = $customer->cards->getList($findData);
````

Delete a card
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$card = $customer->cards->get('k9pn8qtsvr7k7gxoq1r5');
$card->delete();
````

	
#### Bank Accounts ####

Add a bank account to a customer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$bankData = array(
	'clabe' => '072910007380090615',
	'alias' => 'Cuenta principal',
	'holder_name' => 'Teofilo Velazco');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$bankaccount = $customer->bankaccounts->add($bankData);
````

Get a banck account
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$bankaccount = $customer->bankaccounts->get('b4vcouaavwuvkpufh0so');
````

Get the list of bank accounts:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$bankaccountList = $customer->bankaccounts->getList($findData);
````

Delete a bank account:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$bankaccount = $customer->bankaccounts->get('b4vcouaavwuvkpufh0so');
$bankaccount->delete();
````

	
#### Charges ####

**On a Merchant:**

Make a charge on a merchant:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$chargeData = array(
	'method' => 'card',
	'source_id' => 'krfkkmbvdk3hewatruem',
	'amount' => 100,
	'description' => 'Cargo inicial a mi merchant',
	'order_id' => 'ORDEN-00071');

$charge = $openpay->charges->create($chargeData);
````
	
Get a charge:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$charge = $openpay->charges->get('tvyfwyfooqsmfnaprsuk');
````
	
Get list of charges:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$chargeList = $openpay->charges->getList($findData);
````
	
Make a capture:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$captureData = array('amount' => 150.00 );

$charge = $openpay->charges->get('tvyfwyfooqsmfnaprsuk');
$charge->capture($captureData);
````
	
Make a refund:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$refundData = array('description' => 'Devolución' );

$charge = $openpay->charges->get('tvyfwyfooqsmfnaprsuk');
$charge->refund($refundData);
````

**On a Customer:**

Make a charge on a customer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$chargeData = array(
	'source_id' => 'tvyfwyfooqsmfnaprsuk',
	'method' => 'card',
	'amount' => 100,
	'description' => 'Cargo inicial a mi cuenta',
	'order_id' => 'ORDEN-00070');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$charge = $customer->charges->create($chargeData);
````

Get a charge:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$charge = $customer->charges->get('tvyfwyfooqsmfnaprsuk');
````

Get list of charges:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$chargeList = $customer->charges->getList($findData);
````

Make a capture:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$captureData = array('amount' => 150.00 );

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$charge = $customer->charges->get('tvyfwyfooqsmfnaprsuk');
$charge->capture($captureData);
````

Make a refund:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$refundData = array('description' => 'Reembolso' );

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$charge = $customer->charges->get('tvyfwyfooqsmfnaprsuk');
$charge->refund($refundData);
````


#### Transfers ####

Make a transfer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$transferData = array(
	'customer_id' => 'aqedin0owpu0kexr2eor',
	'amount' => 12.50,
	'description' => 'Cobro de Comisión',
	'order_id' => 'ORDEN-00061');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$transfer = $customer->transfers->create($transferData);
````
	
Get a transfer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$transfer = $customer->transfers->get('tyxesptjtx1bodfdjmlb');
````

Get list of transfers:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$transferList = $customer->transfers->getList($findData);
````


#### Payouts ####

**On a Merchant:**

Make a payout on a merchant:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$payoutData = array(
	'method' => 'card',
	'destination_id' => 'krfkkmbvdk3hewatruem',
	'amount' => 500,
	'description' => 'Retiro de saldo semanal',
	'order_id' => 'ORDEN-00072');

$payout = $openpay->payouts->create($payoutData);
````

Get a payout:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$payout = $openpay->payouts->get('t4tzkjspndtj9bnsop2i');
````
	
Get list of payouts:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$payoutList = $openpay->payouts->getList($findData);
````

**On a Customer:**

Make a payout on a customer:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$payoutData = array(
	'method' => 'card',
	'destination_id' => 'k9pn8qtsvr7k7gxoq1r5',
	'amount' => 1000,
	'description' => 'Retiro de saldo semanal',
	'order_id' => 'ORDEN-00062');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$payout = $customer->payouts->create($payoutData);
````
	
Get a payout:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$payout = $customer->payouts->get('tysznlyigrkwnks6eq2c');
````
	
Get list pf payouts:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$payoutList = $customer->payouts->getList($findData);
````


#### Fees ####

Make a fee charge
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$feeData = array(
	'customer_id' => 'a9ualumwnrcxkl42l6mh',
	'amount' => 12.50,
	'description' => 'Cobro de Comisión',
	'order_id' => 'ORDEN-00063');

$fee = $openpay->fees->create($feeData);
````
	
Get list of fees charged:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$feeList = $openpay->fees->getList($findData);
````
	

#### Plans ####

Add a plan:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$planData = array(
	'amount' => 150.00,
	'status_after_retry' => 'cancelled',
	'retry_times' => 2,
	'name' => 'Plan Curso Verano',
	'repeat_unit' => 'month',
	'trial_days' => '30',
	'repeat_every' => '1',
	'currency' => 'MXN');

$plan = $openpay->plans->add($planData);
````
	
Get a plan:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$plan = $openpay->plans->get('pduar9iitv4enjftuwyl');
````
	
Get list of plans: 
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$planList = $openpay->plans->getList($findData);
````

Update a plan:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$plan = $openpay->plans->get('pduar9iitv4enjftuwyl');
$plan->name = 'Plan Curso de Verano 2014';
$plan->save();
````
	
Delete a plan:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$plan = $openpay->plans->get('pduar9iitv4enjftuwyl');
$plan->delete();
````

Get list of subscriptors of a plan: 
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$plan = $openpay->plans->get($planId);
$subscriptionList = $plan->subscriptions->getList($findData);
````


#### Subscriptions ####

Add a subscription:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$subscriptionData = array(
	"trial_end_date":"2014-01-01", 
	'plan_id' => 'pduar9iitv4enjftuwyl',
	'card_id' => 'konvkvcd5ih8ta65umie');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$subscription = $customer->subscriptions->add($subscriptionData);
````
See [documetation](http://docs.openpay.mx/#suscripciones$agregar-con-registrada) for more detail, creating subscriptions. 

Get a subscription:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$subscription = $customer->subscriptions->get('s7ri24srbldoqqlfo4vp');
````

Get list of subscriptions:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$findData = array(
	'creation[gte]' => '2013-01-01',
	'creation[lte]' => '2013-12-31',
	'offset' => 0,
	'limit' => 5);

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$subscriptionList = $customer->subscriptions->getList($findData);
````
	
Update a subscription:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$subscription = $customer->subscriptions->get('s7ri24srbldoqqlfo4vp');
$subscription->trial_end_date = '2014-12-31';
$subscription->save();
````
	
Delete a subscription:
````php
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$customer = $openpay->customers->get('a9ualumwnrcxkl42l6mh');
$subscription = $customer->subscriptions->get('s7ri24srbldoqqlfo4vp');
$subscription->delete();
````
