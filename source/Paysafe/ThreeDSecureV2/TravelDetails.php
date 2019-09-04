<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property bool $isAirTravel
 * @property string $departureDate
 * @property string $passengerFirstName
 * @property string $passengerLastName   
 * @property string $origin
 * @property string $destination
 * @property string $airlineCarrier
 */
class TravelDetails extends \Paysafe\JSONObject
{
    
    protected static $fieldTypes = array(
    'isAirTravel' => 'bool',
    'departureDate' => 'string',
    'passengerFirstName' => 'string',
    'passengerLastName' => 'string',
    'origin' => 'string',
    'destination' => 'string',
    'airlineCarrier' => 'string',

    );

}
