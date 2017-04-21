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
 * @property string $status
 * @property string $merchantRefNum
 * @property string $holderName
 * @property string $cardNum
 * @property string $cardBin
 * @property string $lastDigits
 * @property \Paysafe\Customervault\CardExpiry $cardExpiry
 * @property string $cardType
 * @property string $billingAddressId
 * @property bool $defaultCardIndicator
 * @property string $paymentToken
 * @property \Paysafe\Error $error
 * @property \Paysafe\Link[] $links
 * @property string $profileID
 */
class Card extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
         'id' => 'string',
         'nickName' => 'string',
         'status' => array(
              'INITIAL',
              'ACTIVE'
         ),
         'merchantRefNum' => 'string',
         'holderName' => 'string',
         'cardNum' => 'string',
         'cardBin' => 'string',
         'lastDigits' => 'string',
         'cardExpiry' => '\Paysafe\CustomerVault\CardExpiry',
         'cardType' => 'string',
         'billingAddressId' => 'string',
         'defaultCardIndicator' => 'bool',
         'paymentToken' => 'string',
         'error' => '\Paysafe\Error',
         'links' => 'array:\Paysafe\Link',
         'profileID' => 'string',
        'singleUseToken'=>'string',
		'billingAddress' => '\Paysafe\CustomerVault\BillingAddress'
    );

}
