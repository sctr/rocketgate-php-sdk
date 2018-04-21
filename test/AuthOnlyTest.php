<?php

namespace RocketGate\Sdk\Test;

use PHPUnit\Framework\TestCase;
use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

class AuthOnlyTest extends TestCase
{
    /**
     * @var GatewayService
     */
    protected $service;

    /**
     * @var GatewayRequest
     */
    protected $request;

    /**
     * @var GatewayResponse
     */
    protected $response;

    public function setUp()
    {
        $this->service  = new GatewayService(true);
        $this->request  = new GatewayRequest();
        $this->response = new GatewayResponse();

        $this->request->set(GatewayRequest::merchantId(), '1');
        $this->request->set(GatewayRequest::merchantPassword(), 'testpassword');

        $time = time();
        $this->request->set(GatewayRequest::merchantCustomerId(), $time . '.PHPTest');
        $this->request->set(GatewayRequest::merchantInvoiceId(), $time . '.AuthOnlyTest');

        $this->request->set(GatewayRequest::amount(), '9.99');
        $this->request->set(GatewayRequest::currency(), 'USD');
        $this->request->set(GatewayRequest::cardNo(), '4111111111111111');
        $this->request->set(GatewayRequest::expireMonth(), '02');
        $this->request->set(GatewayRequest::expireYear(), '2010');
        $this->request->set(GatewayRequest::cvv2(), '999');

        $this->request->set(GatewayRequest::customerFirstName(), 'Joe');
        $this->request->set(GatewayRequest::customerLastName(), 'PHPTester');
        $this->request->set(GatewayRequest::email(), 'phptest@fakedomain.com');
        $this->request->set(GatewayRequest::ipAddress(), '11.11.11.11');

        $this->request->set(GatewayRequest::billingAddress(), '123 Main St');
        $this->request->set(GatewayRequest::billingCity(), 'Las Vegas');
        $this->request->set(GatewayRequest::billingState(), 'NV');
        $this->request->set(GatewayRequest::billingZipCode(), '89141');
        $this->request->set(GatewayRequest::billingCountry(), 'US');

        $this->request->set(GatewayRequest::scrub(), 'IGNORE');
        $this->request->set(GatewayRequest::cvv2Check(), 'IGNORE');
        $this->request->set(GatewayRequest::avsCheck(), 'IGNORE');
    }

    /**
     * @test
     */
    public function performAuthOnly()
    {
        $test = $this->service->performAuthOnly($this->request, $this->response);

        $this->assertTrue($test);
    }
}