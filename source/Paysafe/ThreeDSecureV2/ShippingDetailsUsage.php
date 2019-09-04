<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $initialUsageDate
 * @property string $initialUsageRange
 * @property bool $cardHolderNameMatch
 
 */
class ShippingDetailsUsage extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'initialUsageDate' => 'string',
    'initialUsageRange' => array(
        'CURRENT_TRANSACTION',
        'LESS_THAN_THIRTY_DAYS',
        'THIRTY_TO_SIXTY_DAYS',
        'MORE_THAN_SIXTY_DAYS'
    ),
    'cardHolderNameMatch' => 'bool'
    );
}