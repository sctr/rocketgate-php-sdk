<?php

namespace RocketGate\Sdk\Test;

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;

class UploadTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $time = time();
        $this->request->set(GatewayRequest::merchantCustomerId(), $time . '.UploadTest');

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
    }

    /**
     * @test
     */
    public function performCardUploadTest()
    {
        $test = $this->service->performCardUpload($this->request, $this->response);

        $this->assertTrue($test);
        $this->assertNotNull($this->response->get(GatewayResponse::cardHash()));
    }
}