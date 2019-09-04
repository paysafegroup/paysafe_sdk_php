<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $createdDate
 * @property string $createdRange
 */
class PaymentAccountDetails extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'createdDate' => 'string',
    'createdRange' => array(
        'NO_ACCOUNT',
        'DURING_TRANSACTION',
        'LESS_THAN_THIRTY_DAYS',
        'THIRTY_TO_SIXTY_DAYS',
        'MORE_THAN_SIXTY_DAYS'
    )
    );

}