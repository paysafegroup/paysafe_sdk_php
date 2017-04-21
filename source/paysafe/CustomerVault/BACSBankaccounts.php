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
    namespace Paysafe\CustomerVault;

    /**
     * @property string $id
     * @property string $nickName
     * @property string $merchantRefNum
     * @property string $status
     * @property string $statusReason
     * @property string $accountNumber
     * @property string $accountHolderName
     * @property string $sortCode
     * @property string $lastDigits
     * @property string $billingAddressId
     * @property string $paymentToken
     * @property string $mandates
     */
    class BACSBankaccounts extends \Paysafe\JSONObject
    {

        protected static $fieldTypes = array(
            'id' => 'string',
            'nickName' => 'string',
            'merchantRefNum' => 'string',
            'status' =>  array(
                'ACTIVE',
                'INVALID',
                'INACTIVE'
            ),
            'statusReason' => 'string',
            'accountNumber' => 'string',
            'accountHolderName' => 'string',
            'sortCode' => 'string',
            'lastDigits' => 'string',
            'billingAddressId' => 'string',
            'paymentToken' => 'string',
            'mandates' => 'array:\Paysafe\CustomerVault\Mandates'
        );

    }
