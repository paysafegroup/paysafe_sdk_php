<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $carrier
 * @property string $shipMethod
 * @property string $recipientName
 * @property string $street	
 * @property string $street2
 * @property string $city
 * @property string $state
 * @property string $country	
 * @property string $zip
 * 
 */
class ShippingDetails extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
   
      'carrier' => array(
         'APC',
         'APS',
         'CAD',
         'DHL',
         'FEX',
         'RML',
         'UPS',
         'USPS',
         'CLK',
         'EMS',
         'NEX',
         'OTHER'
      ),
      'shipMethod' => array(
        'N', 
        'T', 
        'C',
        'O',
        'S' 
      ),
      'recipientName' => 'string',
      'company' => 'string',
      'street' => 'string',
      'street2' => 'string',
      'city' => 'string',
      'state' => 'string',
      'country' => 'string',
      'zip' => 'string'
      );
    
}
