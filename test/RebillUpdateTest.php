<?php

namespace RocketGate\Sdk\Test;

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;

class RebillUpdateTest extends AbstractTestCase
{
    /**
     * @var string
     */
    protected $customerId;

    /**
     * @var string
     */
    protected $invoiceId;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $time = time();
        $this->customerId = $time.'.PHPTest';
        $this->invoiceId  = $time.'.UpdateStickyMidTest';

        $this->request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
        $this->request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

        $this->request->set(GatewayRequest::amount(), '1.00');
        $this->request->set(GatewayRequest::rebillFrequency(), 'MONTHLY');
        $this->request->set(GatewayRequest::currency(), 'USD');
        $this->request->set(GatewayRequest::cardNo(), '4111111111111111');
        $this->request->set(GatewayRequest::expireMonth(), '02');
        $this->request->set(GatewayRequest::expireYear(), '2010');
        $this->request->set(GatewayRequest::cvv2(), '999');

        $this->request->set(GatewayRequest::customerFirstName(), 'Joe');
        $this->request->set(GatewayRequest::customerLastName(), 'PHPTester');
        $this->request->set(GatewayRequest::email(), 'phptest@fakedomain.com');
        $this->request->set(GatewayRequest::ipAddress(), '11.11.11.11');

        $this->request->set(GatewayRequest::username(), 'phptest_user');
        $this->request->set(GatewayRequest::customerPassword(), 'phptest_pass');

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
    public function updateStickyMidTest()
    {
        if ($this->service->performPurchase($this->request, $this->response)) {
            $request = new GatewayRequest();
            $request->set(GatewayRequest::merchantId(), $this->merchantId);
            $request->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
            $request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
            $request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

            $request->set(GatewayRequest::merchantAccount(), 2);

            $test = $this->service->performRebillUpdate($request, $this->response);

            $this->assertTrue($test);
            $this->assertEquals(2, $this->response->get(GatewayResponse::merchantAccount()));
        }
    }

    /**
     * @test
     */
    public function updatePersonalInformationTest()
    {
        if ($this->service->performPurchase($this->request, $this->response)) {
            $request = new GatewayRequest();
            $request->set(GatewayRequest::merchantId(), $this->merchantId);
            $request->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
            $request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
            $request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

            $request->set(GatewayRequest::email(), 'phptest_updated@fakedomain.com');
            $request->set(GatewayRequest::username(), 'phptest_user_updated');
            $request->set(GatewayRequest::customerPassword(), 'phptest_pass_updated');

            $test = $this->service->performRebillUpdate($request, $this->response);

            $this->assertTrue($test);
        }
    }

    /**
     * @test
     */
    public function upgradeMemberTest()
    {
        if ($this->service->performPurchase($this->request, $this->response)) {
            $request = new GatewayRequest();
            $request->set(GatewayRequest::merchantId(), $this->merchantId);
            $request->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
            $request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
            $request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

            $request->set(GatewayRequest::rebillAmount(), 25.95);
            $request->set(GatewayRequest::rebillFrequency(), 'QUARTERLY');

            $test = $this->service->performRebillUpdate($request, $this->response);

            $this->assertTrue($test);
        }
    }
}