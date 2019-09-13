<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $data
 * @property string $method
 * @property string $time
 * @property string $id
 */
class priorThreeDSAuthentication extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'data' => 'string',
    'method' => array(
        'FRICTIONLESS_AUTHENTICATION',
        'ACS_CHALLENGE',
        'AVS_VERIFIED',
        'OTHER_ISSUER_METHOD'
    ),
    'time' => 'string',
    'id' => 'string'
    );
}