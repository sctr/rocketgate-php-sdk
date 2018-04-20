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

class GatewayRequest extends GatewayParameterList
{
    public function __construct()
    {
        parent::__construct();

        $this->set(self::version(), $this->getVersion());
    }

    /**
     * Transform the parameter list into an XML String.
     *
     * @return string
     */
    public function toXMLString()
    {
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?><gatewayRequest>';

        foreach ($this->params as $key => $value) {
            $xmlString .= '<'.$key.'>';
            $xmlString .= $this->translateXML($value);
            $xmlString .= '</'.$key.'>';
        }
        $xmlString .= '</gatewayRequest>';

        return $xmlString;
    }

    /**
     * Translate a string to a valid XML string that can be used in an attribute or text node.
     *
     * @param string $sourceString
     *
     * @return string
     */
    public function translateXML(string $sourceString)
    {
        $sourceString = str_replace('&', '&amp;', $sourceString);
        $sourceString = str_replace('<', '&lt;', $sourceString);
        $sourceString = str_replace('>', '&gt;', $sourceString);

        return $sourceString;
    }

    /**
     * @return string
     */
    public static function version()
    {
        return 'version';
    }

    /**
     * @return string
     */
    public static function accountHolder()
    {
        return 'accountHolder';
    }

    /**
     * @return string
     */
    public static function accountNo()
    {
        return 'accountNo';
    }

    /**
     * @return string
     */
    public static function affiliate()
    {
        return 'affiliate';
    }

    /**
     * @return string
     */
    public static function amount()
    {
        return 'amount';
    }

    /**
     * @return string
     */
    public static function avsCheck()
    {
        return 'avsCheck';
    }

    /**
     * @return string
     */
    public static function billingAddress()
    {
        return 'billingAddress';
    }

    /**
     * @return string
     */
    public static function billingCity()
    {
        return 'billingCity';
    }

    /**
     * @return string
     */
    public static function billingCountry()
    {
        return 'billingCountry';
    }

    /**
     * @return string
     */
    public static function billingState()
    {
        return 'billingState';
    }

    /**
     * @return string
     */
    public static function billingType()
    {
        return 'billingType';
    }

    /**
     * @return string
     */
    public static function billingZipCode()
    {
        return 'billingZipCode';
    }

    /**
     * @return string
     */
    public static function browserUserAgent()
    {
        return 'browserUserAgent';
    }

    /**
     * @return string
     */
    public static function browserAcceptHeader()
    {
        return 'browserAcceptHeader';
    }

    /**
     * @return string
     */
    public static function captureDays()
    {
        return 'captureDays';
    }

    /**
     * @return string
     */
    public static function cardNo()
    {
        return 'cardNo';
    }

    /**
     * @return string
     */
    public static function cardHash()
    {
        return 'cardHash';
    }

    /**
     * @return string
     */
    public static function cloneCustomerRecord()
    {
        return 'cloneCustomerRecord';
    }

    /**
     * @return string
     */
    public static function cloneToCustomerId()
    {
        return 'cloneToCustomerID';
    }

    /**
     * @return string
     */
    public static function currency()
    {
        return 'currency';
    }

    /**
     * @return string
     */
    public static function customerFirstName()
    {
        return 'customerFirstName';
    }

    /**
     * @return string
     */
    public static function customerLastName()
    {
        return 'customerLastName';
    }

    /**
     * @return string
     */
    public static function customerPassword()
    {
        return 'customerPassword';
    }

    /**
     * @return string
     */
    public static function customerPhoneNo()
    {
        return 'customerPhoneNo';
    }

    /**
     * @return string
     */
    public static function cvv2()
    {
        return 'cvv2';
    }

    /**
     * @return string
     */
    public static function cvv2Check()
    {
        return 'cvv2Check';
    }

    /**
     * @return string
     */
    public static function email()
    {
        return 'email';
    }

    /**
     * @return string
     */
    public static function embeddedFieldToken()
    {
        return 'embeddedFieldsToken';
    }

    /**
     * @return string
     */
    public static function expireMonth()
    {
        return 'expireMonth';
    }

    /**
     * @return string
     */
    public static function expireYear()
    {
        return 'expireYear';
    }

    /**
     * @return string
     */
    public static function generatePostback()
    {
        return 'generatePostback';
    }

    /**
     * @return string
     */
    public static function iovationBlackBox()
    {
        return 'iovationBlackBox';
    }

    /**
     * @return string
     */
    public static function iovationRule()
    {
        return 'iovationRule';
    }

    /**
     * @return string
     */
    public static function ipAddress()
    {
        return 'ipAddress';
    }

    /**
     * @return string
     */
    public static function merchantAccount()
    {
        return 'merchantAccount';
    }

    /**
     * @return string
     */
    public static function merchantCustomerId()
    {
        return 'merchantCustomerID';
    }

    /**
     * @return string
     */
    public static function merchantDescriptor()
    {
        return 'merchantDescriptor';
    }

    /**
     * @return string
     */
    public static function merchantDescriptorCity()
    {
        return 'merchantDescriptorCity';
    }

    /**
     * @return string
     */
    public static function merchantInvoiceId()
    {
        return 'merchantInvoiceID';
    }

    /**
     * @return string
     */
    public static function merchantId()
    {
        return 'merchantID';
    }

    /**
     * @return string
     */
    public static function merchantPassword()
    {
        return 'merchantPassword';
    }

    /**
     * @return string
     */
    public static function merchantProductId()
    {
        return 'merchantProductID';
    }

    /**
     * @return string
     */
    public static function merchantSiteId()
    {
        return 'merchantSiteID';
    }

    /**
     * @return string
     */
    public static function omitReceipt()
    {
        return 'omitReceipt';
    }

    /**
     * @return string
     */
    public static function pares()
    {
        return 'PARES';
    }

    /**
     * @return string
     */
    public static function partialAuthFlag()
    {
        return 'partialAuthFlag';
    }

    /**
     * @return string
     */
    public static function payInfoTransactId()
    {
        return 'payInfoTransactID';
    }

    /**
     * @return string
     */
    public static function rebillFrequency()
    {
        return 'rebillFrequency';
    }

    /**
     * @return string
     */
    public static function rebillAmount()
    {
        return 'rebillAmount';
    }

    /**
     * @return string
     */
    public static function rebillStart()
    {
        return 'rebillStart';
    }

    /**
     * @return string
     */
    public static function rebillEndDate()
    {
        return 'rebillEndDate';
    }

    /**
     * @return string
     */
    public static function rebillCount()
    {
        return 'rebillCount';
    }

    /**
     * @return string
     */
    public static function rebillSuspend()
    {
        return 'rebillSuspend';
    }

    /**
     * @return string
     */
    public static function rebillResume()
    {
        return 'rebillResume';
    }

    /**
     * @return string
     */
    public static function referenceGuid()
    {
        return 'referenceGUID';
    }

    /**
     * @return string
     */
    public static function referralNo()
    {
        return 'referralNo';
    }

    /**
     * @return string
     */
    public static function referringMerchantId()
    {
        return 'referringMerchantID';
    }

    /**
     * @return string
     */
    public static function referredCustomerId()
    {
        return 'referredCustomerID';
    }

    /**
     * @return string
     */
    public static function routingNo()
    {
        return 'routingNo';
    }

    /**
     * @return string
     */
    public static function savingsAccount()
    {
        return 'savingsAccount';
    }

    /**
     * @return string
     */
    public static function scrub()
    {
        return 'scrub';
    }

    /**
     * @return string
     */
    public static function scrubActivity()
    {
        return 'scrubActivity';
    }

    /**
     * @return string
     */
    public static function scrubNegDB()
    {
        return 'scrubNegDB';
    }

    /**
     * @return string
     */
    public static function scrubProfile()
    {
        return 'scrubProfile';
    }

    /**
     * @return string
     */
    public static function ssNumber()
    {
        return 'ssNumber';
    }

    /**
     * @return string
     */
    public static function subMerchantId()
    {
        return 'subMerchantID';
    }

    /**
     * @return string
     */
    public static function threatMetrixSessionId()
    {
        return 'threatMetrixSessionID';
    }

    /**
     * @return string
     */
    public static function transactId()
    {
        return self::referenceGuid();
    }

    /**
     * @return string
     */
    public static function transactionType()
    {
        return 'transactionType';
    }

    /**
     * @return string
     */
    public static function udf01()
    {
        return 'udf01';
    }

    /**
     * @return string
     */
    public static function udf02()
    {
        return 'udf02';
    }

    /**
     * @return string
     */
    public static function use3DSecure()
    {
        return 'use3DSecure';
    }

    /**
     * @return string
     */
    public static function username()
    {
        return 'username';
    }

    /**
     * @return string
     */
    public static function xsellMerchantID()
    {
        return 'xsellMerchantID';
    }

    /**
     * @return string
     */
    public static function xsellCustomerID()
    {
        return 'xsellCustomerID';
    }

    /**
     * @return string
     */
    public static function xsellReferenceXact()
    {
        return 'xsellReferenceXact';
    }

    /**
     * @return string
     */
    public static function threeDCheck()
    {
        return 'ThreeDCheck';
    }

    /**
     * @return string
     */
    public static function threeDECI()
    {
        return 'ThreeDECI';
    }

    /**
     * @return string
     */
    public static function threeDCavvUcaf()
    {
        return 'ThreeDCavvUcaf';
    }

    /**
     * @return string
     */
    public static function threeDXID()
    {
        return 'ThreeDXID';
    }

    /**
     * @return string
     */
    public static function failedServer()
    {
        return 'failedServer';
    }

    /**
     * @return string
     */
    public static function failedGuid()
    {
        return 'failedGUID';
    }

    /**
     * @return string
     */
    public static function failedResponseCode()
    {
        return 'failedResponseCode';
    }

    /**
     * @return string
     */
    public static function failedReasonCode()
    {
        return 'failedReasonCode';
    }

    /**
     * @return string
     */
    public static function gatewayServer()
    {
        return 'gatewayServer';
    }

    /**
     * @return string
     */
    public static function gatewayProtocol()
    {
        return 'gatewayProtocol';
    }

    /**
     * @return string
     */
    public static function gatewayPortNo()
    {
        return 'gatewayPortNo';
    }

    /**
     * @return string
     */
    public static function gatewayServlet()
    {
        return 'gatewayServlet';
    }

    /**
     * @return string
     */
    public static function gatewayUrl()
    {
        return 'gatewayURL';
    }

    /**
     * @return string
     */
    public static function gatewayConnectTimeout()
    {
        return 'gatewayConnectTimeout';
    }

    /**
     * @return string
     */
    public static function gatewayReadTimeout()
    {
        return 'gatewayReadTimeout';
    }
}
