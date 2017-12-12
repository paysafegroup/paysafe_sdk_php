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

    /**
     * @property String $id
     * @property String $merchantRefNum
     * @property String $amount
     * @property \Paysafe\DirectDebit\ach $ach
     * @property \Paysafe\DirectDebit\eft $eft
     * @property \Paysafe\DirectDebit\bacs $bacs
     * @property \Paysafe\DirectDebit\sepa $sepa
     * @property \Paysafe\DirectDebit\profile $profile
     * @property \Paysafe\DirectDebit\billingDetails $billingDetails
     * @property String $customerIp
     * @property String $dupCheck
     * @property String $txnTime
     * @property String $currencyCode
     * @property \Paysafe\Error $error
     * @property String $status
     * @property \Paysafe\DirectDebit\SplitPay[] $splitpay
     */
    class Purchase extends \Paysafe\JSONObject implements \Paysafe\Pageable {

        public static function getPageableArrayKey() {
            return "purchases";
        }

        protected static $fieldTypes = array(
            'id' => 'string',
            'merchantRefNum' => 'string',
            'amount' => 'string',
            'ach' => '\Paysafe\DirectDebit\ACH',
            'eft' => '\Paysafe\DirectDebit\EFT',
            'bacs' => '\Paysafe\DirectDebit\BACS',
            'sepa' => '\Paysafe\DirectDebit\SEPA',
            'profile' => '\Paysafe\DirectDebit\Profile',
            'billingDetails' => '\Paysafe\DirectDebit\BillingDetails',
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
