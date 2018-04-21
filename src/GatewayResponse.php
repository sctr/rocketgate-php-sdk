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

namespace RocketGate\Sdk;

class GatewayResponse extends GatewayParameterList
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set the response and reason values.
     *
     * @param string $response
     * @param string $reason
     */
    public function setResults(string $response, string $reason)
    {
        $this->set(self::responseCode(), $response);
        $this->set(self::reasonCode(), $reason);
    }

    /**
     * Set the internal parameters using the contents of an XML document.
     *
     * @param string $xmlString
     */
    public function setFromXML(string $xmlString)
    {
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);

        if (xml_parse_into_struct($parser, $xmlString, $values, $index) === 0) {
            $this->set(self::exception(), xml_error_string(xml_get_error_code($parser)));
            $this->setResults(self::RESPONSE_SYSTEM_ERROR, self::REASON_XML_ERROR);
            xml_parser_free($parser);

            return;
        }

        foreach ($values as $value) {
            if (isset($value['value'])) {
                $this->set($value['tag'], $value['value']);
            }
        }

        xml_parser_free($parser);
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
    public static function acsUrl()
    {
        return 'acsURL';
    }

    /**
     * @return string
     */
    public static function authNo()
    {
        return 'authNo';
    }

    /**
     * @return string
     */
    public static function avsResponse()
    {
        return 'avsResponse';
    }

    /**
     * @return string
     */
    public static function balanceAmount()
    {
        return 'balanceAmount';
    }

    /**
     * @return string
     */
    public static function balanceCurrency()
    {
        return 'balanceCurrency';
    }

    /**
     * @return string
     */
    public static function bankResponseCode()
    {
        return 'bankResponseCode';
    }

    /**
     * @return string
     */
    public static function cardType()
    {
        return 'cardType';
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
    public static function cardLastFour()
    {
        return 'cardLastFour';
    }

    /**
     * @return string
     */
    public static function cardExpiration()
    {
        return 'cardExpiration';
    }

    /**
     * @return string
     */
    public static function cardCountry()
    {
        return 'cardCountry';
    }

    /**
     * @return string
     */
    public static function cardRegion()
    {
        return 'cardRegion';
    }

    /**
     * @return string
     */
    public static function cardDescription()
    {
        return 'cardDescription';
    }

    /**
     * @return string
     */
    public static function cardDebitCredit()
    {
        return 'cardDebitCredit';
    }

    /**
     * @return string
     */
    public static function cardIssuerName()
    {
        return 'cardIssuerName';
    }

    /**
     * @return string
     */
    public static function cardIssuerPhone()
    {
        return 'cardIssuerPhone';
    }

    /**
     * @return string
     */
    public static function cardIssuerURL()
    {
        return 'cardIssuerURL';
    }

    /**
     * @return string
     */
    public static function cvv2Code()
    {
        return 'cvv2Code';
    }

    /**
     * @return string
     */
    public static function exception()
    {
        return 'exception';
    }

    /**
     * @return string
     */
    public static function eci()
    {
        return 'ECI';
    }

    /**
     * @return string
     */
    public static function iovationTrackingNo()
    {
        return 'IOVATIONTRACKINGNO';
    }

    /**
     * @return string
     */
    public static function iovationDevice()
    {
        return 'IOVATIONDEVICE';
    }

    /**
     * @return string
     */
    public static function iovationResults()
    {
        return 'IOVATIONRESULTS';
    }

    /**
     * @return string
     */
    public static function iovationScore()
    {
        return 'IOVATIONSCORE';
    }

    /**
     * @return string
     */
    public static function iovationRuleCount()
    {
        return 'IOVATIONRULECOUNT';
    }

    /**
     * @return string
     */
    public static function iovationRuleType()
    {
        return 'IOVATIONRULETYPE_';
    }

    /**
     * @return string
     */
    public static function iovationRuleReason()
    {
        return 'IOVATIONRULEREASON_';
    }

    /**
     * @return string
     */
    public static function iovationRuleScore()
    {
        return 'IOVATIONRULESCORE_';
    }

    /**
     * @return string
     */
    public static function joinDate()
    {
        return 'joinDate';
    }

    /**
     * @return string
     */
    public static function joinAmount()
    {
        return 'joinAmount';
    }

    /**
     * @return string
     */
    public static function lastBillingDate()
    {
        return 'lastBillingDate';
    }

    /**
     * @return string
     */
    public static function lastBillingAmount()
    {
        return 'lastBillingAmount';
    }

    /**
     * @return string
     */
    public static function lastReasonCode()
    {
        return 'lastReasonCode';
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
    public static function merchantCustomerID()
    {
        return 'merchantCustomerID';
    }

    /**
     * @return string
     */
    public static function merchantInvoiceID()
    {
        return 'merchantInvoiceID';
    }

    /**
     * @return string
     */
    public static function merchantProductID()
    {
        return 'merchantProductID';
    }

    /**
     * @return string
     */
    public static function merchantSiteID()
    {
        return 'merchantSiteID';
    }

    /**
     * @return string
     */
    public static function pareq()
    {
        return 'PAREQ';
    }

    /**
     * @return string
     */
    public static function reasonCode()
    {
        return 'reasonCode';
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
    public static function rebillDate()
    {
        return 'rebillDate';
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
    public static function rebillFrequency()
    {
        return 'rebillFrequency';
    }

    /**
     * @return string
     */
    public static function rebillStatus()
    {
        return 'rebillStatus';
    }

    /**
     * @return string
     */
    public static function responseCode()
    {
        return 'responseCode';
    }

    /**
     * @return string
     */
    public static function transactId()
    {
        return 'guidNo';
    }

    /**
     * @return string
     */
    public static function scrubResults()
    {
        return 'scrubResults';
    }

    /**
     * @return string
     */
    public static function settledAmount()
    {
        return 'approvedAmount';
    }

    /**
     * @return string
     */
    public static function settledCurrency()
    {
        return 'approvedCurrency';
    }
}
