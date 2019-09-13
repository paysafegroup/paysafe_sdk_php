<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $createdDate
 * @property string $createdRange
 * @property string $changedDate
 * @property string $changedRange   
 * @property string $passwordChangedDate
 * @property string $passwordChangedRange
 * @property int $totalPurchasesSixMonthCount
 * @property int $addCardAttemptsForLastDay
 * @property int $transactionCountForPreviousDay
 * @property int $transactionCountForPreviousYear
 * @property bool $suspiciousAccountActivity
 * @property Paysafe\ThreeDSecureV2\ShippingDetailsUsage $shippingDetailsUsage
 * @property Paysafe\ThreeDSecureV2\PaymentAccountDetails $paymentAccountDetails
 * @property string Paysafe\ThreeDSecureV2\UserLogin $userLogin
 * @property string 

 */
class UserAccountDetails extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'createdDate' => 'string',
    'createdRange' => array(
        'NO_ACCOUNT',
        'DURING_TRANSACTION',
        'LESS_THAN_THIRTY_DAYS',
        'THIRTY_TO_SIXTY_DAYS',
        'MORE_THAN_SIXTY_DAYS'
    ),
    'changedDate' => 'string',
    'changedRange' => array(
        'DURING_TRANSACTION',
        'LESS_THAN_THIRTY_DAYS',
        'THIRTY_TO_SIXTY_DAYS',
        'MORE_THAN_SIXTY_DAYS'
    ),
    'passwordChangedDate' => 'string',
    'passwordChangedRange' => array(
        'NO_CHANGE',
        'DURING_TRANSACTION',
        'LESS_THAN_THIRTY_DAYS',
        'THIRTY_TO_SIXTY_DAYS',
        'MORE_THAN_SIXTY_DAYS'
    ),
    'totalPurchasesSixMonthCount' => 'int',
    'addCardAttemptsForLastDay' => 'int',
    'transactionCountForPreviousDay' => 'int',
    'transactionCountForPreviousYear' => 'int',
    'suspiciousAccountActivity' => 'bool',
    'shippingDetailsUsage' => 'Paysafe\ThreeDSecureV2\ShippingDetailsUsage',
    'paymentAccountDetails' => 'Paysafe\ThreeDSecureV2\PaymentAccountDetails',
    'userLogin' => 'Paysafe\ThreeDSecureV2\UserLogin',
    'priorThreeDSAuthentication' => 'Paysafe\ThreeDSecureV2\PriorThreeDSAuthentication',
    'travelDetails' => 'Paysafe\ThreeDSecureV2\TravelDetails'



   
    );

}
