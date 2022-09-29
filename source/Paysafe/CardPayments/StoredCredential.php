<?php
/*
 * TODO insert appropriate copyright notice
 */

namespace Paysafe\CardPayments;

/**
 * @property string $initialTransactionId
 * @property string $externalInitialTransactionId
 * @property string $type
 * @property number $occurrence
 */
class StoredCredential extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'initialTransactionId' => 'string',
        'externalInitialTransactionId' => 'string',
        'type' => array(
            'ADHOC',
            'TOPUP',
            'RECURRING'
        ),
        'occurrence' => array(
            'INITIAL',
            'SUBSEQUENT'
        )
    );
}
