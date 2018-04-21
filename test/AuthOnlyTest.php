<?php

namespace RocketGate\Sdk\Test;

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;

class AuthOnlyTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
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
    public function performAuthOnlyTest()
    {
        $test = $this->service->performAuthOnly($this->request, $this->response);

        $this->assertTrue($test);
        $this->assertEquals(0, $this->response->get(GatewayResponse::reasonCode()));
    }
}