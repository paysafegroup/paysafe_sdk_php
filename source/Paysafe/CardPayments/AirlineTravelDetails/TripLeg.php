<?php
/*
 * Copyright (c) 2014 OptimalPayments
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Paysafe\CardPayments\AirlineTravelDetails;

/**
 * @property \Paysafe\CardPayments\AirlineTravelDetails\Flight $flight
 * @property string $serviceClass
 * @property string $serviceClassFee
 * @property bool $isStopOverAllowed
 * @property string $departureAirport
 * @property string $destination
 * @property string $fareBasis
 * @property string $departureDate
 * @property string $departureTime
 * @property string $arrivalTime
 * @property string $conjunctionTicket
 * @property string $couponNumber
 * @property string $notation
 * @property string $taxes
 */
class TripLeg extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'flight' => '\Paysafe\CardPayments\AirlineTravelDetails\Flight',
        'serviceClass' => 'string',
        'serviceClassFee' => 'string',
        'isStopOverAllowed' => 'bool',
        'departureAirport' => 'string',
        'destination' => 'string',
        'fareBasis' => 'string',
        'departureDate' => 'string',
        'departureTime' => 'string',
        'arrivalTime' => 'string',
        'conjunctionTicket' => 'string',
        'couponNumber' => 'string',
        'notation' => 'string',
        'taxes' => 'string',
    );

}
