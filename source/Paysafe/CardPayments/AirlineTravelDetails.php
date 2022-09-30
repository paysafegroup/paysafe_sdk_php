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

namespace Paysafe\CardPayments;

/**
 * @property string $passengerNameRecord
 * @property string $passengerName
 * @property string $departureDate
 * @property string $origin
 * @property string $computerizedReservationSystem
 * @property string $additionalBookingReference
 * @property string $totalFare
 * @property string $totalFee
 * @property string $totalTaxes
 * @property \Paysafe\CardPayments\AirlineTravelDetails\Ticket $ticket
 * @property \Paysafe\CardPayments\AirlineTravelDetails\Passengers $passengers
 * @property string $customerReferenceNumber
 * @property \Paysafe\CardPayments\AirlineTravelDetails\TravelAgency $travelAgency
 * @property \Paysafe\CardPayments\AirlineTravelDetails\TripLegs $tripLegs
 * 
 */
class AirlineTravelDetails extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'passengerNameRecord' => 'string',
        'passengerName' => 'string',
        'departureDate' => 'string',
        'origin' => 'string',
        'computerizedReservationSystem' => array(
            'STRT',
            'PARS',
            'DATS',
            'SABR',
            'DALA',
            'BLAN',
            'DERD',
            'TUID'
        ),
        'additionalBookingReference' => 'string',
        'totalFare' => 'string',
        'totalFee' => 'string',
        'totalTaxes' => 'string',
        'ticket' => '\Paysafe\CardPayments\AirlineTravelDetails\Ticket',
        'passengers' => '\Paysafe\CardPayments\AirlineTravelDetails\Passengers',
        'customerReferenceNumber' => 'string',
        'travelAgency' => '\Paysafe\CardPayments\AirlineTravelDetails\TravelAgency',
        'tripLegs' => '\Paysafe\CardPayments\AirlineTravelDetails\TripLegs',
    );

}
