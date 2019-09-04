<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $street1
 * @property string $street2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip
 * @property string $phone	
 */
class BillingDetails extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(

     'street1' => 'string',
     'street2' => 'string',
     'city' => 'string',
     'state' => 'string',
     'country' => 'string',
     'zip' => 'string',
     'phone	' => 'string'
    );

}
