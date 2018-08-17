<?php
/*
 * TODO insert appropriate copyright notice
 */

namespace Paysafe\CardPayments;

/**
 * @property string $type
 * @property number $occurrence
 */
class StoredCredential extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
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
