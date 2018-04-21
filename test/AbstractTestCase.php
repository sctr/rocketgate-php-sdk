<?php

/*
 * Copyright notice:
 * (c) Copyright 2017 RocketGate
 * All rights reserved.
 *
 * The copyright notice must not be removed without specific, prior
 * written permission from RocketGate.
 *
 * This software is protected as an unpublished work under the U.S. copyright
 * laws. The above copyright notice is not intended to effect a publication of
 * this work.
 * This software is the confidential and proprietary information of RocketGate.
 * Neither the binaries nor the source code may be redistributed without prior
 * written permission from RocketGate.
 *
 * The software is provided "as-is" and without warranty of any kind, express, implied
 * or otherwise, including without limitation, any warranty of merchantability or fitness
 * for a particular purpose.  In no event shall RocketGate be liable for any direct,
 * special, incidental, indirect, consequential or other damages of any kind, or any damages
 * whatsoever arising out of or in connection with the use or performance of this software,
 * including, without limitation, damages resulting from loss of use, data or profits, and
 * whether or not advised of the possibility of damage, regardless of the theory of liability.
 */

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
     * {@inheritdoc}
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
