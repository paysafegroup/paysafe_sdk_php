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

/**
 * @property string $id
 * @property string $merchantRefNum
 * @property int $amount
 * @property string $paReq
 * @property string $customerIp
 * @property string $txnTime
 * @property \OptimalPayments\ThreeDSecure\Card $card
 * @property string $acsURL
 * @property string $eci
 * @property string $currency
 * @property \OptimalPayments\ThreeDSecure\ThreeDEnrollment $threeDEnrollment
 * @property \OptimalPayments\Error $error
 * @property string $status
 * 
 */
class Enrollmentchecks extends \Paysafe\JSONObject {

    protected static $fieldTypes = array(
        'id' => 'string',
        'merchantRefNum' => 'string',
        'txnTime' => 'dateTime',
        'status' => array(
            'RECEIVED',
            'COMPLETED',
            'HELD',
            'FAILED',
            'CANCELLED'
        ),
        'amount' => 'int',
        'card' => '\Paysafe\ThreeDSecure\Card',
        'customerIp' => 'string',
        'acsURL' => 'string',
        'paReq' => 'string',
        'threeDEnrollment' => array(
            'Y',
            'N',
            'U'
        ),
        'error' => '\Paysafe\Error',
        'links' => 'array:\Paysafe\Link',
        'currency' => 'string',
        'userAgent' => 'string',
        'acceptHeader' => 'string',
        'merchantUrl' => 'string',
        'eci' => 'string'
    );

}

?>
