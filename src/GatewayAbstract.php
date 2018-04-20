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

abstract class GatewayAbstract
{
    const RESPONSE_SUCCESS                   = 0;
    const RESPONSE_BANK_FAIL                 = 1;
    const RESPONSE_RISK_FAIL                 = 2;
    const RESPONSE_SYSTEM_ERROR              = 3;
    const RESPONSE_REQUEST_ERROR             = 4;
    const REASON_SUCCESS                     = 0;
    const REASON_NOMATCHING_XACT             = 100;
    const REASON_CANNOT_VOID                 = 101;
    const REASON_CANNOT_CREDIT               = 102;
    const REASON_CANNOT_TICKET               = 103;
    const REASON_DECLINED                    = 104;
    const REASON_DECLINED_OVERLIMIT          = 105;
    const REASON_DECLINED_CVV2               = 106;
    const REASON_DECLINED_EXPIRED            = 107;
    const REASON_DECLINED_CALL               = 108;
    const REASON_DECLINED_PICKUP             = 109;
    const REASON_DECLINED_EXCESSIVEUSE       = 110;
    const REASON_DECLINED_INVALID_CARDNO     = 111;
    const REASON_DECLINED_INVALID_EXPIRATION = 112;
    const REASON_BANK_UNAVAILABLE            = 113;
    const REASON_EMPTY_BATCH                 = 114;
    const REASON_BATCH_REJECTED              = 115;
    const REASON_DUPLICATE_BATCH             = 116;
    const REASON_DECLINED_AVS                = 117;
    const REASON_RISK_FAIL                   = 200;
    const REASON_DNS_FAILURE                 = 300;
    const REASON_UNABLE_TO_CONNECT           = 301;
    const REASON_REQUEST_XMIT_ERROR          = 302;
    const REASON_RESPONSE_READ_TIMEOUT       = 303;
    const REASON_RESPONSE_READ_ERROR         = 304;
    const REASON_SERVICE_UNAVAILABLE         = 305;
    const REASON_CONNECTION_UNAVAILABLE      = 306;
    const REASON_BUGCHECK                    = 307;
    const REASON_UNHANDLED_EXCEPTION         = 308;
    const REASON_SQL_EXCEPTION               = 309;
    const REASON_SQL_INSERT_ERROR            = 310;
    const REASON_BANK_CONNECT_ERROR          = 311;
    const REASON_BANK_XMIT_ERROR             = 312;
    const REASON_BANK_READ_ERROR             = 313;
    const REASON_BANK_DISCONNECT_ERROR       = 314;
    const REASON_BANK_TIMEOUT_ERROR          = 315;
    const REASON_BANK_PROTOCOL_ERROR         = 316;
    const REASON_ENCRYPTION_ERROR            = 317;
    const REASON_BANK_XMIT_RETRIES           = 318;
    const REASON_BANK_RESPONSE_RETRIES       = 319;
    const REASON_BANK_REDUNDANT_RESPONSES    = 320;
    const REASON_XML_ERROR                   = 400;
    const REASON_INVALID_URL                 = 401;
    const REASON_INVALID_TRANSACTION         = 402;
    const REASON_INVALID_CARDNO              = 403;
    const REASON_INVALID_EXPIRATION          = 404;
    const REASON_INVALID_AMOUNT              = 405;
    const REASON_INVALID_MERCHANT_ID         = 406;
    const REASON_INVALID_MERCHANT_ACCOUNT    = 407;
    const REASON_INCOMPATABLE_CARDTYPE       = 408;
    const REASON_NO_SUITABLE_ACCOUNT         = 409;
    const REASON_INVALID_REFGUID             = 410;
    const REASON_INVALID_ACCESS_CODE         = 411;
    const REASON_INVALID_CUSTDATA_LENGTH     = 412;
    const REASON_INVALID_EXTDATA_LENGTH      = 413;
    const REASON_INVALID_CUSTOMER_ID         = 414;

    /**
     * @var string
     */
    public $checksum = '';

    /**
     * @var string
     */
    public $baseChecksum = 'f0286c49b8750b78ebadb95cb2469337';

    /**
     * @var string
     */
    public $versionNo = 'P6.3';

    public function setVersion()
    {
        $dirName    = dirname(__FILE__);
        $baseString = md5_file($dirName.'/GatewayService.php').md5_file($dirName.'/GatewayRequest.php');
        $baseString .= md5_file($dirName.'/GatewayResponse.php').md5_file($dirName.'/GatewayParameterList.php');

        $this->checksum = md5($baseString);
        if ($this->checksum !== $this->baseChecksum) {
            $this->versionNo = 'P6.3m';
        }
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        if (empty($this->checksum)) {
            $this->setVersion();
        }

        return $this->versionNo;
    }
}
