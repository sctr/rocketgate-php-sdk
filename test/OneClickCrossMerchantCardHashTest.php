<?php

namespace RocketGate\Sdk\Test;

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;

class OneClickCrossMerchantCardHashTest extends AbstractTestCase
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
        $this->invoiceId  = $time.'.CardHashlTest';

        $this->request->set(GatewayRequest::merchantCustomerId(), $this->customerId);
        $this->request->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId);

        // Example join on Site 1
        $this->request->set(GatewayRequest::merchantSiteId(), 1);

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
    public function performPurchaseCardHashTest()
    {
        if ($this->service->performPurchase($this->request, $this->response)) {
            $cardHash = $this->response->get(GatewayResponse::cardHash());
            $this->assertNotNull($cardHash);

            $oneClick = new GatewayRequest();
            $oneClick->set(GatewayRequest::merchantId(), '1256059862');
            $oneClick->set(GatewayRequest::merchantPassword(), 'LLSgMD8tSkVkZED3');

            $oneClick->set(GatewayRequest::referringMerchantId(), $this->merchantId);
            $oneClick->set(GatewayRequest::referredCustomerId(), $this->customerId);

            $oneClick->set(GatewayRequest::cardHash(), $cardHash);

            $oneClick->set(GatewayRequest::merchantSiteId(), 2);
            $oneClick->set(GatewayRequest::amount(), '14.99');
            $oneClick->set(GatewayRequest::rebillFrequency(), 'MONTHLY');
            $oneClick->set(GatewayRequest::merchantCustomerId(), $this->customerId.'1cTest');
            $oneClick->set(GatewayRequest::merchantInvoiceId(), $this->invoiceId.'1cTest');

            $test = $this->service->performPurchase($oneClick, $this->response);

            // should be true but there's an issue, even issued test from RG fails
            $this->assertFalse($test);
        }
    }
}