<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $endDate
 * @property int $frequency

 */
class BillingCycle  extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'endDate' => 'string',
    'frequency' => 'int'
   
    );

}
