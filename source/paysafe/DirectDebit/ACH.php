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
 * @property String $paymentToken paymentToken
 * @property Array $payMethod
 * @property String $paymentDescriptor
 * @property String $accountHolderName
 * @property Array $accountType
 * @property String $accountNumber
 * @property String $routingNumber
 * @property String $lastDigits
 */
class ACH extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
        'paymentToken' => 'string',
        'payMethod' =>
        array('WEB',
            'TEL',
            'PPD',
            'CCD'),
        'paymentDescriptor' => 'string',
        'accountHolderName' => 'string',
        'accountType' =>
        array('SAVINGS',
            'CHECKING',
            'LOAN'),
        'accountNumber' => 'string',
        'routingNumber' => 'string',
        'lastDigits' => 'string'
    );

}
