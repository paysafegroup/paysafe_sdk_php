<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $email
 * @property bool $isElectronicDelivery
 */
class ElectronicDelivery extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
     'email' => 'string',
     'isElectronicDelivery' => 'bool' 
    );

}
