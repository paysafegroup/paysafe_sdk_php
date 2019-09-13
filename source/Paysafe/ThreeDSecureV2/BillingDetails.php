<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $street
 * @property string $street2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip
 */
class BillingDetails extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(

     'street' => 'string',
     'street2' => 'string',
     'city' => 'string',
     'state' => 'string',
     'country' => 'string',
     'zip' => 'string'
    );

}
