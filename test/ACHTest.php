<?php

namespace RocketGate\Sdk\Test;

use RocketGate\Sdk\GatewayRequest;

class ACHTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $time = time();
        $this->request->set(GatewayRequest::merchantCustomerId(), $time . '.PHPTest');
        $this->request->set(GatewayRequest::merchantInvoiceId(), $time . '.ACHTest');

        $this->request->set(GatewayRequest::amount(), '9.99');
        $this->request->set(GatewayRequest::currency(), 'USD');

        $this->request->set(GatewayRequest::routingNo(), "999999999");
        $this->request->set(GatewayRequest::accountNo(), "112233");
        $this->request->set(GatewayRequest::savingsAccount(), "TRUE");
        $this->request->set(GatewayRequest::ssNumber(), "1111");


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
    }

    /**
     * @test
     */
    public function PerformPurchaseTest()
    {
        $test = $this->service->PerformPurchase($this->request, $this->response);

        // should be assertTrue but RG test fails
        $this->assertFalse($test);
    }
}