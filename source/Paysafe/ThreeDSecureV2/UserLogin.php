<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $data
 * @property string $authenticationMethod
 * @property string $time
 */
class UserLogin extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'data' => 'string',
    'authenticationMethod' => array(
        'NO_LOGIN',
        'INTERNAL_CREDENTIALS',
        'FEDERATED_ID',
        'ISSUER_CREDENTIALS',
        'THIRD_PARTY_AUTHENTICATION',
        'FIDO_AUTHENTICATOR'
    ),
    'time' => 'string'   
    );

}