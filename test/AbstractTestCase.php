<?php

namespace RocketGate\Sdk\Test;

use PHPUnit\Framework\TestCase;
use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

class AbstractTestCase extends TestCase
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

    /**
     * @var int
     */
    protected $merchantId = 1;

    /**
     * @var string
     */
    protected $merchantPassword = 'testpassword';

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->service  = new GatewayService(true);
        $this->request  = new GatewayRequest();
        $this->response = new GatewayResponse();

        $this->request->set(GatewayRequest::merchantId(), $this->merchantId);
        $this->request->set(GatewayRequest::merchantPassword(), $this->merchantPassword);
    }
}