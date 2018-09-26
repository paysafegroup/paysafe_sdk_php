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
 * @property string $childAccountNum
 * @property \Paysafe\CardPayments\Card $card
 * @property string $authCode
 * @property \Paysafe\CardPayments\Profile $profile
 * @property \Paysafe\CardPayments\BillingDetails $billingDetails
 * @property string $customerIp
 * @property string $dupCheck
 * @property \Paysafe\CardPayments\MerchantDescriptor $merchantDescriptor
 * @property string $description
 * @property string $txnTime
 * @property string $currencyCode
 * @property string $avsResponse
 * @property string $cvvVerification
 * @property string $status
 * @property int[] $riskReasonCode
 * @property \Paysafe\CardPayments\AcquirerResponse $acquirerResponse
 * @property \Paysafe\Error $error
 * @property \Paysafe\Link[] $links
 */
class Verification extends \Paysafe\JSONObject implements \Paysafe\Pageable
{
    public static function getPageableArrayKey()
    {
        return 'verifications';
    }

    protected static $fieldTypes = array(
         'id' => 'string',
         'merchantRefNum' => 'string',
         'childAccountNum' => 'string',
         'card' => '\Paysafe\CardPayments\Card',
         'authCode' => 'string',
         'profile' => '\Paysafe\CardPayments\Profile',
         'billingDetails' => '\Paysafe\CardPayments\BillingDetails',
         'customerIp' => 'string',
         'dupCheck' => 'bool',
         'merchantDescriptor' => '\Paysafe\CardPayments\MerchantDescriptor',
         'description' => 'string',
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
         'status' => 'string',
         'riskReasonCode' => 'array:int',
         'acquirerResponse' => '\Paysafe\CardPayments\AcquirerResponse',
         'error' => '\Paysafe\Error',
         'links' => 'array:\Paysafe\Link'
    );

}
