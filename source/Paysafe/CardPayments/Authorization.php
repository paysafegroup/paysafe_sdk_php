<?php
/*
 * Copyright (c) 2014 OptimalPayments
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Paysafe\CardPayments;

/**
 * @property string $id
 * @property string $merchantRefNum
 * @property int $amount
 * @property bool $settleWithAuth
 * @property int $availableToSettle
 * @property string $childAccountNum
 * @property \Paysafe\CardPayments\Card $card
 * @property \Paysafe\CardPayments\Authentication $authentication
 * @property string $authCode
 * @property \Paysafe\CardPayments\Profile $profile
 * @property \Paysafe\CardPayments\BillingDetails $billingDetails
 * @property \Paysafe\CardPayments\ShippingDetails $shippingDetails
 * @property string $recurring
 * @property string $customerIp
 * @property bool $dupCheck
 * @property string[] $keywords
 * @property \Paysafe\CardPayments\MerchantDescriptor $merchantDescriptor
 * @property \Paysafe\CardPayments\AccordD $accordD
 * @property string $description
 * @property \Paysafe\CardPayments\MasterPass
 * @property string $txnTime
 * @property string $currencyCode
 * @property string $avsResponse
 * @property string $cvvVerication
 * @property string $status
 * @property int[] $riskReasonCode
 * @property \Paysafe\CardPayments\AcquirerResponse $acquirerRresponse
 * @property \Paysafe\CardPayments\VisaAdditionalAuthData $visaAdditionalAuthData
 * @property \Paysafe\CardPayments\Settlement $settlements
 * @property \Paysafe\Error $error
 * @property \Paysafe\Link[] $links
 * @property \Paysafe\CardPayments\SplitPay[] $splitpay
 * @property \Paysafe\CardPayments\StoredCredential $storedCredential
 */
class Authorization extends \Paysafe\JSONObject implements \Paysafe\Pageable
{
    public static function getPageableArrayKey()
    {
        return 'auths';
    }

    protected static $fieldTypes = array(
         'id' => 'string',
         'merchantRefNum' => 'string',
         'amount' => 'int',
         'settleWithAuth' => 'bool',
         'availableToSettle' => 'int',
         'childAccountNum' => 'string',
         'card' => '\Paysafe\CardPayments\Card',
         'authentication' => '\Paysafe\CardPayments\Authentication',
         'authCode' => 'string',
         'profile' => '\Paysafe\CardPayments\Profile',
         'billingDetails' => '\Paysafe\CardPayments\BillingDetails',
         'shippingDetails' => '\Paysafe\CardPayments\ShippingDetails',
         'recurring' => array(
              'INITIAL',
              'RECURRING'
         ),
         'customerIp' => 'string',
         'dupCheck' => 'bool',
         'keywords' => 'array:string',
         'merchantDescriptor' => '\Paysafe\CardPayments\MerchantDescriptor',
         'accordD' => '\Paysafe\CardPayments\AccordD',
         'description' => 'string',
         'masterPass' => '\Paysafe\CardPayments\MasterPass',
         'txnTime' => 'string',
         'currencyCode' => 'string',
         'avsResponse' => array(
              'MATCH',
              'MATCH_ADDRESS_ONLY',
              'MATCH_ZIP_ONLY',
              'NO_MATCH',
              'NOT_PROCESSED',
              'UNKNOWN'
         ),
         'cvvVerification' => array(
              'MATCH',
              'NO_MATCH',
              'NOT_PROCESSED',
              'UNKNOWN'
         ),
         'status' => array(
              'RECEIVED',
              'COMPLETED',
              'HELD',
              'FAILED',
              'CANCELLED'
         ),
         'riskReasonCode' => 'array:int',
         'acquirerResponse' => '\Paysafe\CardPayments\AcquirerResponse',
         'visaAdditionalAuthData' => '\Paysafe\CardPayments\VisaAdditionalAuthData',
         'settlements' => 'array:\Paysafe\CardPayments\Settlement',
         'error' => '\Paysafe\Error',
         'links' => 'array:\Paysafe\Link',
        'splitpay' => 'array:\Paysafe\CardPayments\SplitPay',
        'storedCredential' => '\Paysafe\CardPayments\StoredCredential'
    );

}
