<?php
namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $id
 * @property string $deviceFingerprintingId
 * @property string $merchantRefNum
 * @property int $amount
 * @property string $currency
 * @property \Paysafe\ThreeDSecureV2\Card $card
 * @property string $merchantUrl
 * @property string $txnTime
 * @property \Paysafe\Error $error
 * @property string status 
 * @property string $acsURL
 * @property string $payload
 * @property string $threeDEnrollment
 * @property string $threeDResult
 * @property string $threeDSecureVersion
 * @property string $directoryServerTransactionId
 * @property int $eci
 * @property string $cavv
 * @property string $xid
 * @property string $signatureStatus
 * @property string $sdkChallengePayload
 * @property string $transactionIntent
 * @property int $maxAuthorizationsForInstalmentPayment
 * @property string $authenticationPurpose  
 * @property string $deviceChannel
 * @property string $messageCategory
 * @property string $initialPurchaseTime
 * @property string $requestorChallengePreference
 * @property \Paysafe\ThreeDSecureV2\ElectronicDelivery $electronicDelivery
 * @property '\Paysafe\ThreeDSecureV2\OrderItemDetails',
 * @property '\Paysafe\ThreeDSecureV2\PurchasedGiftCardDetails',
 * @property '\Paysafe\ThreeDSecureV2\BillingCycle',
 * @property '\Paysafe\ThreeDSecureV2\BrowserDetails',
 * @property '\Paysafe\ThreeDSecureV2\UserAccountDetails',
 * @property '\Paysafe\ThreeDSecureV2\BillingDetails',
 * @property '\Paysafe\ThreeDSecureV2\ShippingDetails',
 * @property '\Paysafe\ThreeDSecureV2\\Profile'
 */

class Authentications extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
        'id' => 'string',
        'deviceFingerprintingId' => 'string',
        'merchantRefNum' => 'string',
        'amount' => 'int',
        'currency' => 'string',
        'card' => '\Paysafe\ThreeDSecureV2\Card',
        'merchantUrl' => 'string', 
        'txnTime' => 'dateTime',
        'error' => '\Paysafe\Error',
        'status' => array(
            'COMPLETED',
            'PENDING',
            'FAILED'
        ),
        'acsURL' => 'string',
        'payload' => 'string',
        'threeDEnrollment' => array(
            'Y', 
            'N', 
            'U'
        ), 
        'threeDResult' => array(
            'Y',
            'A',
            'N',
            'U',
            'C',
            'R'
        ), 
        'threeDSecureVersion' => 'string',
        'directoryServerTransactionId' => 'string',
        'eci' => 'int', 
        'cavv' => 'string', 
        'xid' => 'string',
        'signatureStatus' = array(
            'Y', 
            'N'
        ),
        'sdkChallengePayload' => 'string',
        'transactionIntent' => array(
            'GOODS_OR_SERVICE_PURCHASE',
            'CHECK_ACCEPTANCE',
            'CHECK_ACCEPTANCE', 
            'ACCOUNT_FUNDING', 
            'QUASI_CASH_TRANSACTION',
            'PREPAID_ACTIVATION' 
        ),
        'maxAuthorizationsForInstalmentPayment' => 'int',
        'authenticationPurpose' => array(
            'PAYMENT_TRANSACTION',
            'RECURRING_TRANSACTION',
            'INSTALMENT_TRANSACTION',
            'ADD_CARD',
            'MAINTAIN_CARD',
            'EMV_TOKEN_VERIFICATION'
        ),
        'deviceChannel' => array(
            'BROWSER',
            'SDK',
            '3RI'
        ),
        'messageCategory' => array(
            'PAYMENT',
            'NON_PAYMENT'
        ),
        'initialPurchaseTime' => "dateTime",
        'requestorChallengePreference' => array(
            'NO_PREFERENCE',
            'NO_CHALLENGE_REQUESTED',
            'CHALLENGE_REQUESTED',
            'CHALLENGE_MANDATED'
        ),
        'electronicDelivery' => '\Paysafe\ThreeDSecureV2\ElectronicDelivery',
        'orderItemDetails' => '\Paysafe\ThreeDSecureV2\OrderItemDetails',
        'purchasedGiftCardDetails' => '\Paysafe\ThreeDSecureV2\PurchasedGiftCardDetails',
        'billingCycle' => '\Paysafe\ThreeDSecureV2\BillingCycle',
        'browserDetails' => '\Paysafe\ThreeDSecureV2\BrowserDetails',
        'userAccountDetails' => '\Paysafe\ThreeDSecureV2\UserAccountDetails',
        'billingDetails'=> '\Paysafe\ThreeDSecureV2\BillingDetails',
        'shippingDetails' => '\Paysafe\ThreeDSecureV2\ShippingDetails',
        'profile' => '\Paysafe\ThreeDSecureV2\Profile'

    );

}