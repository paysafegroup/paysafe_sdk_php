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

/*
     * @property string $id
     * @property string $merchantRefNum
     * @property int $amount
     * @property \Paysafe\DirectDebit\ach $ach
     * @property \Paysafe\DirectDebit\eft $eft
     * @property \Paysafe\DirectDebit\bacs $bacs
     * @property \Paysafe\DirectDebit\profile $profile
     * @property \Paysafe\DirectDebit\billingDetails $billingDetails
     * @property \Paysafe\DirectDebit\ShippingDetails $shippingDetails
     * @property string $customerIp
     * @property string $dupCheck
     * @property string $txnTime
     * @property string $currencyCode
     * @property \Paysafe\Error $error
     * @property string $status
     */

    class StandaloneCredits extends \Paysafe\JSONObject implements \Paysafe\Pageable {

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
            'links' => 'array:\Paysafe\Link'
        );

        /**
         *
         * @param type $linkName
         * @return \Paysafe\HostedPayment\Link
         * @throws PaysafeException
         */
        public function getLink( $linkName ) {
            if (!empty($this->link)) {
                foreach ($this->link as $link) {
                    if ($link->rel == $linkName) {
                        return $link;
                    }
                }
            }
            throw new PaysafeException("Link $linkName not found in purchase.");
        }

    }
