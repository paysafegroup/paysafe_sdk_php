<?php

/*
 * Copyright (c) 2016 OptimalPayments
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


/**
 * Description of threedsecureservice
 *
 * @author Prakahsh.Patil
 */

namespace Paysafe;

class ThreeDSecureService
{

    /**
     * @var PaysafeApiClient
     */
    private $client;

    /**
     * The uri for the Threed secure payment api.
     * @var string
     */
    private $uri = "threedsecure/v1";

    /**
     * Initialize the Threedsecure service.
     *
     * @param \Paysafe\PaysafeApiClient $client
     */
    public function __construct( PaysafeApiClient $client )
    {
        $this->client = $client;
    }

    /**
     * Monitor.
     *
     * @return bool true if successful
     * @throws PaysafeException
     * The following request verifies that the service is up and accessible from your network.
     */
    public function monitor()
    {
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => 'threedsecure/monitor'
        ));
        $response = $this->client->processRequest($request);
        return ($response['status'] == 'READY');
    }

    /**
     * Submit an Enrollment lookup Request
     * @param \Paysafe\ThreeDSecure\ThreeDEnrollment $enrollmentchecks
     * @return \Paysafe\ThreeDSecure\ThreeDEnrollment
     * @throws PaysafeException
     */
    public function enrollmentChecks( ThreeDSecure\ThreeDEnrollment $enrollmentchecks )
    {
        $enrollmentchecks->setRequiredFields(array(
            'merchantRefNum',
            'amount',
            'currency',
            'card',
            'customerIp',
            'userAgent',
            'acceptHeader',
            'merchantUrl'
        ));
        $enrollmentchecks->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/enrollmentchecks"),
            'body' => $enrollmentchecks
        ));

        $response = $this->client->processRequest($request);
        return new ThreeDSecure\ThreeDEnrollment($response);
    }

    /**
     * Look Up an Enrollment Lookup Using an ID
     * @param \Paysafe\ThreeDSecure\ThreeDEnrollment $enrollmentchecks
     * @return \Paysafe\ThreeDSecure\ThreeDEnrollment
     * @throws PaysafeException
     */
    public function getenrollmentChecks( ThreeDSecure\ThreeDEnrollment $enrollmentchecks )
    {
        $enrollmentchecks->setRequiredFields(array(
            'id'
        ));
        $enrollmentchecks->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/enrollmentchecks/" . $enrollmentchecks->id),
            'body' => $enrollmentchecks
        ));
        $response = $this->client->processRequest($request);
        return new ThreeDSecure\ThreeDEnrollment($response);
    }

    /**
     * Submit an Authentications Request
     * @param \Paysafe\ThreeDSecure\Authentications $authentications
     * @return \Paysafe\ThreeDSecure\Authentications
     * @throws PaysafeException
     */
    public function authentications( ThreeDSecure\Authentications $authentications )
    {
        $authentications->setRequiredFields(array(
            'merchantRefNum',
            'paRes'
        ));
        $authentications->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/enrollmentchecks/" . $authentications->id . "/authentications"),
            'body' => $authentications
        ));

        $response = $this->client->processRequest($request);
        return new ThreeDSecure\Authentications($response);
    }

    /**
     * Look Up an Authentication Using an ID
     * @param \Paysafe\ThreeDSecure\Authentications $authentications
     * @return \Paysafe\ThreeDSecure\Authentications
     * @throws PaysafeException
     */
    public function getAuthentication( ThreeDSecure\Authentications $authentications )
    {
        $authentications->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/authentications/" . $authentications->id),
            'body' => $authentications
        ));
        $response = $this->client->processRequest($request);
        return new ThreeDSecure\Authentications($response);
    }

    /**
     * Look Up an Authentication and Corresponding Enrollment Check
     * @param \Paysafe\ThreeDSecure\Authentications $authentications
     * @return \Paysafe\ThreeDSecure\Authentications
     * @throws PaysafeException
     */
    public function getAuthentications( ThreeDSecure\Authentications $authentications,$enrollmentlookup )
    {
       $authentications->setRequiredFields(array('id'));
            $authentications->checkRequiredFields();
            $fields = array();
            if ($enrollmentlookup)
            {
                $fields[]= 'enrollmentchecks';
            }
            $queryStr = array();
            if ($fields)
            {
                $queryStr['fields'] = join(',', $fields);
            }
 
            $request = new Request(array(
                'method' => Request::GET,
                'uri' => $this->prepareURI("/authentications/".$authentications->id),
                'queryStr' => $queryStr
            ));
 
            $response = $this->client->processRequest($request);
            return new ThreeDSecure\Authentications($response);
    }

    private function prepareURI( $path )
    {
        if (!$this->client->getAccount())
        {
            throw new PaysafeException('Missing or invalid account', 500);
        }
        return $this->uri . '/accounts/' . $this->client->getAccount() . $path;
    }

}

?>
