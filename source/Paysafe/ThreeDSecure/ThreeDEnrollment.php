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
namespace Paysafe\ThreeDSecure;

/*
 * @property string $id
 * @property string $merchantRefNum
 * @property int $amount
 * @property string $currency
 * @property \Paysafe\ThreeDSecure\Card $card
 * @property string $customerIp
 * @property string $userAgent
 * @property string $acceptHeader
 * @property string $merchantUrl
 * @property string $txnTime
 * @property \Paysafe\Error $error
 * @property string $status
 * @property string $acsURL
 * @property string $paReq
 * @property string $eci
 * @property \Paysafe\ThreeDSecure\profile $threeDEnrollment
 */

class ThreeDEnrollment extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
        'id' => 'string',
        'merchantRefNum' => 'string',
        'amount' => 'int',
        'currency' => 'string',
        'card' => '\Paysafe\ThreeDSecure\Card',
        'customerIp' => 'string',
        'userAgent' => 'string',
        'acceptHeader' => 'string',
        'merchantUrl' => 'string',
        'txnTime' => 'string',
        'error' => '\Paysafe\Error',
        'status' => array(
            'RECEIVED',
            'COMPLETED',
            'HELD',
            'FAILED',
            'CANCELLED'
        ),
        'acsURL' => 'string',
        'paReq' => 'string',
        'eci' => 'int',
        'threeDEnrollment' => array(
            'Y',
            'N',
            'U'
        ),
        'links' => 'array:\Paysafe\Link'
    );

}
