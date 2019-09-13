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

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $paymentToken
 * @property string $cardNum
 * @property string $cardBin
 * @property string $lastDigits
 * @property \Paysafe\ThreeDSecureV2\CardExpiry $cardExpiry
 * @property string $type
 * @property string $holderName
 */
class Card extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
        'paymentToken' => 'string',
        'cardNum' => 'string',
        'cardBin' => 'string',
        'lastDigits' => 'string',
        'cardExpiry' => '\Paysafe\ThreeDSecureV2\CardExpiry',
        'type' => array(
            'AM',
            'MC',
            'VI'
        ),
        'holderName' => 'string'
    );

}
