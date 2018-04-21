<?php

namespace RocketGate\Sdk\Test;

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;

class CancelTest extends AbstractTestCase
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
        $this->invoiceId  = $time.'.CancelTest';

        $this->request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
        $this->request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

        $this->request->set(GatewayRequest::amount(), '9.99');
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
    public function performRebillCancelTest()
    {
        if ($this->service->performPurchase($this->request, $this->response)) {
            $cancel = new GatewayRequest();
            $cancel->set(GatewayRequest::merchantId(), $this->merchantId);
            $cancel->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
            $cancel->set(GatewayRequest::merchantCustomerId(), $this->customerId);
            $cancel->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

            $test = $this->service->performRebillCancel($cancel, $this->response);

            $this->assertTrue($test);
            $this->assertNotNull($this->response->get(GatewayResponse::rebillEndDate()));
        }
    }

    /**
     * @test
     */
    public function checkRebillStatusTest()
    {
        if ($this->service->performPurchase($this->request, $this->response)) {
            $cancel = new GatewayRequest();
            $cancel->set(GatewayRequest::merchantId(), $this->merchantId);
            $cancel->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
            $cancel->set(GatewayRequest::merchantCustomerId(), $this->customerId);
            $cancel->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

            if ($this->service->performRebillCancel($cancel, $this->response)) {
                $request = new GatewayRequest();
                $request->set(GatewayRequest::merchantId(), $this->merchantId);
                $request->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
                $request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
                $request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

                if ($this->service->performRebillUpdate($request, $this->response)) {
                    $this->assertNotNull($this->response->get(GatewayResponse::rebillEndDate()));
                } else {
                    $this->assertNotNull($this->response->get(GatewayResponse::reasonCode()));
                }
            }
        }
    }
}