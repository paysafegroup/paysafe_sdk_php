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

namespace Paysafe\DirectDebit;

use Paysafe\PaysafeException;

/**
 * @property string $id
 * @property string $merchantRefNum
 * @property int $amount
 * @property \Paysafe\DirectDebit\ACH $ach
 * @property \Paysafe\DirectDebit\EFT $eft
 * @property \Paysafe\DirectDebit\BACS $bacs
 * @property \Paysafe\DirectDebit\Profile $profile
 * @property \Paysafe\DirectDebit\Filter $filter
 * @property \Paysafe\DirectDebit\BillingDetails $billingDetails
 * @property \Paysafe\DirectDebit\ShippingDetails $shippingDetails
 * @property string $customerIp
 * @property bool $dupCheck
 * @property string $txnTime
 * @property string $currencyCode
 * @property \Paysafe\Error $error
 * @property string $status
 * @property \Paysafe\Link[] $links
 * @property \Paysafe\DirectDebit\SplitPay[] $splitpay
 */
class StandaloneCredits extends \Paysafe\JSONObject implements \Paysafe\Pageable
{
    public static function getPageableArrayKey() {
        return "standaloneCredits";
    }

    protected static $fieldTypes = array(
        'id' => 'string',
        'merchantRefNum' => 'string',
        'amount' => 'int',
        'ach' => '\Paysafe\DirectDebit\ACH',
        'eft' => '\Paysafe\DirectDebit\EFT',
        'bacs' => '\Paysafe\DirectDebit\BACS',
        'profile' => '\Paysafe\DirectDebit\Profile',
        'filter' => '\Paysafe\DirectDebit\Filter',
        'billingDetails' => '\Paysafe\DirectDebit\BillingDetails',
        'shippingDetails' => '\Paysafe\DirectDebit\ShippingDetails',
        'customerIp' => 'string',
        'dupCheck' => 'bool',
        'txnTime' => 'string',
        'currencyCode' => 'string',
        'error' => '\Paysafe\Error',
        'status' => array(
            'RECEIVED',
            'PENDING',
            'PROCESSING',
            'COMPLETED',
            'FAILED',
            'CANCELLED'
        ),
        'links' => 'array:\Paysafe\Link',
        'splitpay' => 'array:\Paysafe\DirectDebit\SplitPay',
    );

    /**
     * @param string $linkName
     * @return \Paysafe\Link
     * @throws \Paysafe\PaysafeException
     */
    public function getLink( $linkName ) {
        if (!empty($this->links)) {
            foreach ($this->links as $link) {
                if ($link->rel == $linkName) {
                    return $link;
                }
            }
        }
        throw new PaysafeException("Link $linkName not found in stand alone credit.");
    }
}
