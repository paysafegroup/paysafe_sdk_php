<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property int $amount
 * @property int $count
 * @property string $currency

 */
class PurchasedGiftCardDetails  extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
     'amount' => 'int',
     'count' => 'int',
     'currency' => 'string'
    );

}
