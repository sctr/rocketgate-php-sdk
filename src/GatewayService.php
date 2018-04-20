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
 *
 */

namespace RocketGate\Sdk;

class GatewayService extends GatewayAbstract
{
    /**
     * Gateway hostname.
     *
     * @var string
     */
    public $rocketGateHost;

    /**
     * Message protocol.
     *
     * @var string
     */
    public $rocketGateProtocol;

    /**
     * Network connection port.
     *
     * @var int
     */
    public $rocketGatePortNo;

    /**
     * Destination servlet.
     *
     * @var string
     */
    public $rocketGateServlet;

    /**
     * Timeout for network connection.
     *
     * @var int
     */
    public $rocketGateConnectTimeout;

    /**
     * Timeout for network read.
     *
     * @var int
     */
    public $rocketGateReadTimeout;

    /**
     * Set the standard production destinations for the service.
     *
     * @param bool $testMode
     */
    public function __construct(bool $testMode = true)
    {
        $this->setTestMode($testMode);
        $this->rocketGateServlet        = 'gateway/servlet/ServiceDispatcherAccess';
        $this->rocketGateConnectTimeout = 10;
        $this->rocketGateReadTimeout    = 90;
    }

    /**
     * Perform an auth-only transaction.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performAuthOnly(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CC_AUTH');
        if (!empty($request->get(GatewayRequest::referenceGuid()))) {
            if ($this->performTargetedTransaction($request, $response) === false) {
                return false;
            }
        } elseif ($this->performTransaction($request, $response) === false) {
            return false;
        }

        return $this->performConfirmation($request, $response);
    }

    /**
     * Perform a ticket operation for a previous auth-only transaction.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performTicket(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CC_TICKET');

        return $this->performTargetedTransaction($request, $response);
    }

    /**
     * Perform a complete purchase transaction using the information contained in a request.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performPurchase(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CC_PURCHASE');
        if (!empty($request->get(GatewayRequest::referenceGuid()))) {
            if ($this->performTargetedTransaction($request, $response) === false) {
                return false;
            }
        } elseif ($this->performTransaction($request, $response) === false) {
            return false;
        }

        return $this->performConfirmation($request, $response);
    }

    /**
     * Perform a credit operation for a previously completed transaction.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performCredit(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CC_CREDIT');

        // If the credit references a previous transaction, we
        // need to send it back to the origination site.  Otherwise,
        // it can be sent to any server.

        if (!empty($request->get(GatewayRequest::referenceGuid()))) {
            return $this->performTargetedTransaction($request, $response);
        }

        return $this->performTransaction($request, $response);
    }

    /**
     * Perform a void operation for a previously completed transaction.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performVoid(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CC_VOID');

        return $this->performTargetedTransaction($request, $response);
    }

    /**
     * Perform scrubbing on a card/customer.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performCardScrub(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CARDSCRUB');

        return $this->performTransaction($request, $response);
    }

    /**
     * Schedule cancellation of rebilling.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performRebillCancel(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'REBILL_CANCEL');

        return $this->performTransaction($request, $response);
    }

    /**
     * Update terms of rebilling.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performRebillUpdate(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'REBILL_UPDATE');

        $amount = $request->get(GatewayRequest::amount());
        if (empty($amount) || $amount <= 0) {
            return $this->performTransaction($request, $response);
        }

        if ($this->performTransaction($request, $response) === false) {
            return false;
        }

        return $this->performConfirmation($request, $response);
    }

    /**
     * Lookup previous transaction.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performLookup(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'LOOKUP');

        if (!empty($request->get(GatewayRequest::referenceGuid()))) {
            return $this->performTargetedTransaction($request, $response);
        }

        return $this->performTransaction($request, $response);
    }

    /**
     * Upload card data to the servers.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performCardUpload(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'CARDUPLOAD');

        return $this->performTransaction($request, $response);
    }

    /**
     * Add an entry to the XsellQueue.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function generateXsell(GatewayRequest $request, GatewayResponse $response)
    {
        $request->set(GatewayRequest::transactionType(), 'GENERATEXSELL');
        $request->set(GatewayRequest::referenceGuid(), $request->get(GatewayRequest::xsellReferenceXact()));

        if (!empty($request->get(GatewayRequest::referenceGuid()))) {
            return $this->performTargetedTransaction($request, $response);
        }

        return $this->performTransaction($request, $response);
    }

    /**
     * Set the communications parameters for production or test mode.
     *
     * @param bool $testFlag
     */
    public function setTestMode(bool $testFlag)
    {
        if ($testFlag) {
            $this->rocketGateHost     = 'dev-gateway.rocketgate.com';
            $this->rocketGateProtocol = 'https';
            $this->rocketGatePortNo   = '443';
        } else {
            $this->rocketGateHost     = 'gateway.rocketgate.com';
            $this->rocketGateProtocol = 'https';
            $this->rocketGatePortNo   = '443';
        }
    }

    /**
     * Set the host used by the service.
     *
     * @param string $hostname
     */
    public function setHost(string $hostname)
    {
        $this->rocketGateHost = $hostname;
    }

    /**
     * Set the communications protocol used by the service.
     *
     * @param string $protocol
     */
    public function setProtocol(string $protocol)
    {
        $this->rocketGateProtocol = $protocol;
    }

    /**
     * Set the port number used by the service.
     *
     * @param int $portNo
     */
    public function setPortNo(int $portNo)
    {
        $this->rocketGatePortNo = $portNo;
    }

    /**
     * Set the servlet used by the service.
     *
     * @param string $servlet
     */
    public function setServlet(string $servlet)
    {
        $this->rocketGateServlet = $servlet;
    }

    /**
     * Set the timeout used during connection to the servlet.
     *
     * @param int $timeout
     */
    public function setConnectTimeout(int $timeout)
    {
        $this->rocketGateConnectTimeout = $timeout;
    }

    /**
     * Set the timeout used while waiting for the servlet to answer.
     *
     * @param int $timeout
     */
    public function setReadTimeout(int $timeout)
    {
        $this->rocketGateReadTimeout = $timeout;
    }

    /**
     * Perform the transaction outlined in a GatewayRequest.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performTransaction(GatewayRequest $request, GatewayResponse $response)
    {
        $this->prepareRequest($request);

        $serverName = $request->get('gatewayServer');
        if (empty($serverName)) {
            $serverName = $this->rocketGateHost;
        }

        if (strcmp($serverName, 'gateway.rocketgate.com') !== 0) {
            $hostList = [$serverName];
        } else {
            $hostList = gethostbynamel($serverName);
            if (empty($hostList)) {
                $hostList = [
                    'gateway-16.rocketgate.com',
                    'gateway-17.rocketgate.com',
                ];
            } else {
                $listSize = count($hostList);
                for ($index = 0; $index < $listSize; $index++) {
                    if (strcmp($hostList[$index], '69.20.127.91') === 0) {
                        $hostList[$index] = 'gateway-16.rocketgate.com';
                    } elseif (strcmp($hostList[$index], '72.32.126.131') === 0) {
                        $hostList[$index] = 'gateway-17.rocketgate.com';
                    }
                }
            }
        }

        if (($listSize = count($hostList)) > 1) {
            $index = rand(0, ($listSize - 1));
            if ($index > 0) {
                $swapper          = $hostList[0];
                $hostList[0]      = $hostList[$index];
                $hostList[$index] = $swapper;
            }
        }

        for ($index = 0; $index < $listSize; $index++) {
            $results = $this->performCURLTransaction($hostList[$index], $request, $response);
            if ($results === self::RESPONSE_SUCCESS) {
                return true;
            }

            if ($results !== self::RESPONSE_SYSTEM_ERROR) {
                return false;
            }

            $request->set(GatewayRequest::failedServer(), $hostList[$index]);
            $request->set(GatewayRequest::failedResponseCode(), $response->get(GatewayResponse::responseCode()));
            $request->set(GatewayRequest::failedReasonCode(), $response->get(GatewayResponse::reasonCode()));
            $request->set(GatewayRequest::failedGuid(), $response->get(GatewayResponse::transactId()));
        }

        return false;
    }

    /**
     * Send a transaction to a server based upon the reference GUID.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performTargetedTransaction(GatewayRequest $request, GatewayResponse $response)
    {
        $this->prepareRequest($request);

        $referenceGUID = $request->get(GatewayRequest::referenceGuid());
        if (empty($referenceGUID)) {
            $response->setResults(self::RESPONSE_REQUEST_ERROR, self::REASON_INVALID_REFGUID);

            return false;
        }

        if (strlen($referenceGUID) > 15) {
            $siteNo = substr($referenceGUID, 0, 2);
        } else {
            $siteNo = substr($referenceGUID, 0, 1);
        }
        $siteNo = hexdec($siteNo);

        $serverName = $request->get('gatewayServer');
        if (empty($serverName)) {
            $serverName = $this->rocketGateHost;
            if (($separator = strpos($serverName, '.')) > 0) {
                $prefix     = substr($serverName, 0, $separator);
                $serverName = substr($serverName, $separator);
                $serverName = $prefix.'-'.$siteNo.$serverName;
            }
        }

        $results = $this->performCURLTransaction($serverName, $request, $response);
        if ((int) $results === self::RESPONSE_SUCCESS) {
            return true;
        }

        return false;
    }

    /**
     * @param GatewayRequest $request
     */
    private function prepareRequest(GatewayRequest &$request)
    {
        $request->clear(GatewayRequest::failedServer());
        $request->clear(GatewayRequest::failedResponseCode());
        $request->clear(GatewayRequest::failedReasonCode());
        $request->clear(GatewayRequest::failedGuid());

        $fullURL = $request->get('gatewayURL');
        if (empty($fullURL)) {
            $fullURL = $request->get('embeddedFieldsToken');
        }

        if (!empty($fullURL)) {
            $urlBits = parse_url($fullURL); // Split the URL
            if (empty($request->get('gatewayServer'))) {
                $request->set('gatewayServer', $urlBits['host']);
            }

            $request->set('gatewayProtocol', $urlBits['scheme']);
            if (array_key_exists('port', $urlBits)) {
                $request->set('gatewayPortNo', $urlBits['port']);
            }
            $request->set('gatewayServlet', $urlBits['path'].'?'.$urlBits['query']);
        }
    }

    /**
     * Perform the confirmation pass that tells the server we have received transaction reply.
     *
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performConfirmation(GatewayRequest $request, GatewayResponse $response)
    {
        $confirmGUID = $response->get(GatewayResponse::transactId());
        if (empty($confirmGUID)) {
            $response->set(GatewayResponse::EXCEPTION(), 'BUG-CHECK - Missing confirmation GUID');
            $response->setResults(self::RESPONSE_SYSTEM_ERROR, self::REASON_BUGCHECK);

            return false;
        }

        $confirmResponse = new GatewayResponse();
        $request->set(GatewayRequest::transactionType(), 'CC_CONFIRM');
        $request->set(GatewayRequest::referenceGuid(), $confirmGUID);
        if ($this->performTargetedTransaction($request, $confirmResponse)) {
            return true;
        }

        if ((int) $confirmResponse->get(GatewayResponse::responseCode()) === self::RESPONSE_SYSTEM_ERROR) {
            sleep(2);
            if ($this->performTargetedTransaction($request, $confirmResponse)) {
                return true;
            }
        }

        $response->setResults(
            $confirmResponse->get(GatewayResponse::responseCode()),
            $confirmResponse->get(GatewayResponse::reasonCode())
        );
        $response->set(GatewayResponse::exception(), $confirmResponse->get(GatewayResponse::exception()));

        return false;
    }

    /**
     * Perform a transaction exchange with a given host.
     *
     * @param string          $host
     * @param GatewayRequest  $request
     * @param GatewayResponse $response
     *
     * @return bool
     */
    public function performCURLTransaction(string $host, GatewayRequest $request, GatewayResponse $response)
    {
        $response->reset();
        $requestBytes = $request->toXMLString();

        $urlServlet  = $request->get('gatewayServlet');
        $urlProtocol = $request->get('gatewayProtocol');
        $urlPortNo   = $request->get('gatewayPortNo');

        if (empty($urlServlet)) {
            $urlServlet = $this->rocketGateServlet;
        }
        if (empty($urlProtocol)) {
            $urlProtocol = $this->rocketGateProtocol;
        }
        if (empty($urlPortNo)) {
            $urlPortNo = $this->rocketGatePortNo;
        }

        $url = $urlProtocol.'://'.$host.':'.$urlPortNo.'/'.$urlServlet;

        $connectTimeout = $request->get('gatewayConnectTimeout');
        $readTimeout    = $request->get('gatewayReadTimeout');

        if (empty($connectTimeout)) {
            $connectTimeout = $this->rocketGateConnectTimeout;
        }
        if (empty($readTimeout)) {
            $readTimeout = $this->rocketGateReadTimeout;
        }

        if (!$handle = curl_init()) {
            $response->set(GatewayResponse::exception(), 'curl_init() error');
            $response->setResults(self::RESPONSE_REQUEST_ERROR, self::REASON_INVALID_URL);

            return self::RESPONSE_REQUEST_ERROR;
        }

        /*
         * Set timeout values used in the operation.
         */
        curl_setopt($handle, CURLOPT_NOSIGNAL, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($handle, CURLOPT_TIMEOUT, $readTimeout);

        /*
         * Setup the call to the URL.
         */
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $requestBytes);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_FAILONERROR, true);
        curl_setopt($handle, CURLOPT_USERAGENT, 'RG PHP Client '.$this->getVersion());
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);

        $results = curl_exec($handle);
        if (empty($results)) {
            $errorCode   = curl_errno($handle);
            $errorString = curl_error($handle);
            curl_close($handle);

            switch ($errorCode) {
                case CURLE_SSL_CONNECT_ERROR:
                case CURLE_COULDNT_CONNECT:
                    $internalCode = self::REASON_UNABLE_TO_CONNECT;
                    break;
                case CURLE_SEND_ERROR:
                    $internalCode = self::REASON_REQUEST_XMIT_ERROR;
                    break;
                case CURLE_OPERATION_TIMEOUTED:
                    $internalCode = self::REASON_RESPONSE_READ_TIMEOUT;
                    break;
                case CURLE_RECV_ERROR:
                case CURLE_READ_ERROR:
                default:
                    $internalCode = self::REASON_RESPONSE_READ_ERROR;
            }

            if (!empty($errorString)) {
                $response->set(GatewayResponse::exception(), $errorString);
            }
            $response->setResults(self::RESPONSE_SYSTEM_ERROR, $internalCode);

            return self::RESPONSE_SYSTEM_ERROR;
        }

        curl_close($handle);
        $response->setFromXML($results);

        return $response->get(GatewayResponse::responseCode());
    }
}
