[![Build Status](https://travis-ci.org/sctr/rocketgate-php-sdk.svg?branch=master)](https://travis-ci.org/sctr/rocketgate-php-sdk)

Rocketgate PHP SDK
===========

This library

## To Install

Install with composer:

```sh
composer require sctr/rocketgate-php-sdk
```

## To Use

For example:

```php
<?php

require_once __DIR__.'/vendor/autoload.php';

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

$service  = new GatewayService();
$request  = new GatewayRequest();
$response = new GatewayResponse();

$request->set(GatewayRequest::merchantId(), '1');
$request->set(GatewayRequest::merchantPassword(), 'testpassword');

$time = time();
$request->set(GatewayRequest::merchantCustomerId(), $time . '.PHPTest');
$request->set(GatewayRequest::merchantInvoiceId(), $time . '.AuthOnlyTest');

$request->set(GatewayRequest::amount(), '9.99');
$request->set(GatewayRequest::currency(), 'USD');
$request->set(GatewayRequest::cardNo(), '4111111111111111');
$request->set(GatewayRequest::expireMonth(), '02');
$request->set(GatewayRequest::expireYear(), '2010');
$request->set(GatewayRequest::cvv2(), '999');

$request->set(GatewayRequest::customerFirstName(), 'Joe');
$request->set(GatewayRequest::customerLastName(), 'PHPTester');
$request->set(GatewayRequest::email(), 'phptest@fakedomain.com');
$request->set(GatewayRequest::ipAddress(), '11.11.11.11');

$request->set(GatewayRequest::billingAddress(), '123 Main St');
$request->set(GatewayRequest::billingCity(), 'Las Vegas');
$request->set(GatewayRequest::billingState(), 'NV');
$request->set(GatewayRequest::billingZipCode(), '89141');
$request->set(GatewayRequest::billingCountry(), 'US');

$request->set(GatewayRequest::scrub(), 'IGNORE');
$request->set(GatewayRequest::cvv2Check(), 'IGNORE');
$request->set(GatewayRequest::avsCheck(), 'IGNORE');

if ($service->performAuthOnly($request, $response)) {
    print "Auth-Only succeeded\n";
    print "GUID: " . $response->get(GatewayResponse::transactId())."\n";
    print "Response Code: " .  $response->get(GatewayResponse::responseCode())."\n";
    print "Reason Code: " .  $response->get(GatewayResponse::reasonCode())."\n";
    print "Auth No: " .  $response->get(GatewayResponse::authNo())."\n";
    print "AVS: " .  $response->get(GatewayResponse::avsResponse())."\n";
    print "CVV2: " .  $response->get(GatewayResponse::cvv2Code())."\n";
    print "Account: " .  $response->get(GatewayResponse::merchantAccount())."\n";
    print "Scrub: " . $response->get(GatewayResponse::scrubResults())."\n";
    
} else {
    print "Auth-Only failed\n";
    print "GUID: " . $response->get(GatewayResponse::transactId())."\n";
    print "Response Code: " .  $response->get(GatewayResponse::responseCode())."\n";
    print "Reason Code: " .  $response->get(GatewayResponse::reasonCode())."\n";
    print "Exception: " . $response->get(GatewayResponse::exception())."\n";
    print "Scrub: " . $response->get(GatewayResponse::scrubResults())."\n";
}

```

## To Test

Run tests with PHP Unit in the root of the library

```sh
./vendor/bin/phpunit
```