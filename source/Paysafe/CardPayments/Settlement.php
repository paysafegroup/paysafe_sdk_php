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
 * @property int $amount
 * @property int $availableToRefund
 * @property string $childAccountNum
 * @property string $txnTime
 * @property bool $dupCheck
 * @property string $status
 * @property int[] $riskReasonCode
 * @property \Paysafe\CardPayments\AcquirerResponse $acquirerResponse
 * @property \Paysafe\Error $error
 * @property \Paysafe\Link[] $links
 * @property string $authorizationID
 * @property \Paysafe\CardPayments\SplitPay[] $splitpay
 */
class Settlement extends \Paysafe\JSONObject implements \Paysafe\Pageable
{
    public static function getPageableArrayKey()
    {
        return 'settlements';
    }

    protected static $fieldTypes = array(
         'id' => 'string',
         'merchantRefNum' => 'string',
         'amount' => 'int',
         'availableToRefund' => 'int',
         'childAccountNum' => 'string',
         'txnTime' => 'string',
         'dupCheck' => 'bool',
         'status' => array(
              'RECEIVED',
              'PENDING',
              'PROCESSING',
              'COMPLETED',
              'FAILED',
              'CANCELLED'
         ),
         'riskReasonCode' => 'array:int',
         'acquirerResponse' => '\Paysafe\CardPayments\AcquirerResponse',
         'error' => '\Paysafe\Error',
         'links' => 'array:\Paysafe\Link',
         'authorizationID' => 'string',
         'splitpay' => 'array:\Paysafe\CardPayments\SplitPay',
    );

}
