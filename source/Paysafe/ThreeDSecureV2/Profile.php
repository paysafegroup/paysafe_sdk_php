<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $email	
 * @property string $phone
 * @property string $cellphone
 * 
 */
class Profile extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
     'email' => 'string',
     'phone' => 'string',
     'cellPhone' => 'string'
    );
    
}
