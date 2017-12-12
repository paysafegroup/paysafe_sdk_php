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


/**
 * Description of directdebitservice
 *
 * @author kushal.bhattad
 */

namespace Paysafe;

class DirectDebitService
{

    /**
     * @var PaysafeApiClient
     */
    private $client;

    /**
     * The uri for the card payment api.
     * @var string
     */
    private $uri = "directdebit/v1";
    private $purchasePath = "/purchases";
    private $standalonePath = '/standalonecredits';
    private $uriseparator = "/";

    /**
     * Initialize the Direct Debit service.
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
            'uri' => 'directdebit/monitor'
        ));

        $response = $this->client->processRequest($request);
        return ($response['status'] == 'READY');
    }

    /**
     * Submit purchase
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    public function submit( DirectDebit\Purchase $purchase )
    {
        if (isset($purchase->ach))
        {
            $return = $this->submitPurchaseACH($purchase);
        } else if (isset($purchase->eft))
        {
            $return = $this->submitPurchaseEFT($purchase);
        } else if (isset($purchase->bacs))
        {
            $return = $this->submitPurchaseBACS($purchase);
        } else if (isset($purchase->sepa))
        {
            $return = $this->submitPurchaseSEPA($purchase);
        }
        return $return;
    }

    /**
     * Process Purchase using ACH with and without payment token.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    private function submitPurchaseACH( DirectDebit\Purchase $purchase )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'ach'
        );

        if (!isset($purchase->ach->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $purchase->profile->setRequiredFields($fields2);
            $purchase->profile->checkRequiredFields($fields2);
        }

        $purchase->setRequiredFields($fields);
        $purchase->checkRequiredFields();
        $purchase->setOptionalFields(array(
            'customerIp',
            'dupCheck',
            'splitpay',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->purchasePath),
            'body' => $purchase
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Purchase($response);
    }

    /**
     * Process Purchase using EFT without payment token.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    private function submitPurchaseEFT( DirectDebit\Purchase $purchase )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'eft'
        );

        if (!isset($purchase->eft->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $purchase->profile->setRequiredFields($fields2);
            $purchase->profile->checkRequiredFields($fields2);
        }

        $purchase->setRequiredFields($fields);
        $purchase->checkRequiredFields();
        $purchase->setOptionalFields(array(
            'customerIp',
            'dupCheck',
            'splitpay',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->purchasePath),
            'body' => $purchase
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Purchase($response);
    }

    /**
     * Process Purchase using BACS without payment token.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    private function submitPurchaseBACS( DirectDebit\Purchase $purchase )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'bacs'
        );

        if (!isset($purchase->bacs->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $purchase->profile->setRequiredFields($fields2);
            $purchase->profile->checkRequiredFields($fields2);
        }

        $purchase->setRequiredFields($fields);
        $purchase->checkRequiredFields();
        $purchase->setOptionalFields(array(
            'customerIp',
            'dupCheck'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->purchasePath),
            'body' => $purchase
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Purchase($response);
    }

    /**
     * Process Purchase using SEPA without payment token.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    private function submitPurchaseSEPA( DirectDebit\Purchase $purchase )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'sepa'
        );

        if (!isset($purchase->sepa->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $purchase->profile->setRequiredFields($fields2);
            $purchase->profile->checkRequiredFields($fields2);
        }

        $purchase->setRequiredFields($fields);
        $purchase->checkRequiredFields();
        $purchase->setOptionalFields(array(
            'customerIp',
            'dupCheck'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->purchasePath),
            'body' => $purchase
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Purchase($response);
    }

    /**
     * Cancel Purchase.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    public function cancelPurchase( DirectDebit\Purchase $purchase )
    {
        $purchase->setRequiredFields(array('id','status'));
        $purchase->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI($this->purchasePath . $this->uriseparator . $purchase->id),
            'body' => $purchase
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Purchase($response);
    }

    /**
     * Lookup Purchase.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    public function getPurchase( DirectDebit\Purchase $purchase )
    {
        $purchase->setOptionalFields(array('id'));
        $purchase->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI($this->purchasePath . $this->uriseparator . $purchase->id)
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Purchase($response);
    }

    /**
     * Lookup Purchase.
     *
     * @param \Paysafe\DirectDebit\Purchase $purchase
     * @return \Paysafe\DirectDebit\Purchase
     * @throws PaysafeException
     */
    public function getPurchases( DirectDebit\Purchase $purchase, DirectDebit\Filter $filter )
    {
        $queryStr = array();
        if ($purchase && $purchase->merchantRefNum)
        {
            $queryStr['merchantRefNum'] = $purchase->merchantRefNum;
        }
        if ($filter)
        {
            if (isset($filter->limit))
            {
                $queryStr['limit'] = $filter->limit;
            }
            if (isset($filter->offset))
            {
                $queryStr['offset'] = $filter->offset;
            }
            if (isset($filter->startDate))
            {
                $queryStr['startDate'] = $filter->startDate;
            }
            if (isset($filter->endDate))
            {
                $queryStr['endDate'] = $filter->endDate;
            }
        }

        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI($this->purchasePath . $this->uriseparator . $purchase->id),
            'queryStr' => $queryStr
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\Pagerator($this->client, $response, '\Paysafe\DirectDebit\Purchase');
    }

    /* End Code For PURCHASE Request */

    /**
     * Submit Standalone Cedits
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    public function standaloneCredits( DirectDebit\StandaloneCredits $standalonecredits )
    {
        if (isset($standalonecredits->ach))
        {
            $return = $this->standalonecreditsACH($standalonecredits);
        } else if (isset($standalonecredits->eft))
        {
            $return = $this->standalonecreditsEFT($standalonecredits);
        } else if (isset($standalonecredits->bacs))
        {
            $return = $this->standalonecreditsBACS($standalonecredits);
        }
        return $return;
    }

    /**
     * Process Standalone Credits using ACH with and without payment token.
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    private function standalonecreditsACH( DirectDebit\StandaloneCredits $standalonecredits )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'ach'
        );
        if (!isset($standalonecredits->ach->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $standalonecredits->profile->setRequiredFields($fields2);
            $standalonecredits->profile->checkRequiredFields($fields2);
        }

        $standalonecredits->setRequiredFields($fields);
        $standalonecredits->checkRequiredFields();
        $standalonecredits->setOptionalFields(array(
            'customerIp',
            'dupCheck',
            'splitpay',
        ));
        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->standalonePath),
            'body' => $standalonecredits
        ));
        $response = $this->client->processRequest($request);
        return new DirectDebit\StandaloneCredits($response);
    }

    /**
     * Process Standalone Credits using EFT without payment token.
     *
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    private function standalonecreditsEFT( DirectDebit\StandaloneCredits $standalonecredits )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'eft'
        );
        if (!isset($standalonecredits->eft->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $standalonecredits->profile->setRequiredFields($fields2);
            $standalonecredits->profile->checkRequiredFields($fields2);
        }

        $standalonecredits->setRequiredFields($fields);
        $standalonecredits->checkRequiredFields();
        $standalonecredits->setOptionalFields(array(
            'customerIp',
            'dupCheck',
            'splitpay',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->standalonePath),
            'body' => $standalonecredits
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\StandaloneCredits($response);
    }

    /**
     * Process Standalone Credits using BACS without payment token.
     *
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    private function standalonecreditsBACS( DirectDebit\StandaloneCredits $standalonecredits )
    {
        $fields = array(
            'merchantRefNum',
            'amount',
            'bacs'
        );
        if (!isset($standalonecredits->bacs->paymentToken))
        {
            $fields[] = 'profile';
            $fields[] = 'billingDetails';
			$fields2 = array("firstName","lastName");
            $standalonecredits->profile->setRequiredFields($fields2);
            $standalonecredits->profile->checkRequiredFields($fields2);
        }

        $standalonecredits->setRequiredFields($fields);
        $standalonecredits->checkRequiredFields();
        $standalonecredits->setOptionalFields(array(
            'customerIp',
            'dupCheck'
        ));
        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI($this->standalonePath),
            'body' => $standalonecredits
        ));
        $response = $this->client->processRequest($request);
        return new DirectDebit\StandaloneCredits($response);
    }

    /**
     * Cancel StandaloneCredits.
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    public function cancelStandalonecredits( DirectDebit\StandaloneCredits $standalonecredits )
    {
        $standalonecredits->setRequiredFields(array('id'));
        $standalonecredits->checkRequiredFields();
        $tmpAuth = new DirectDebit\StandaloneCredits(array(
            'status' => 'CANCELLED'
        ));
        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI($this->standalonePath . $this->uriseparator . $standalonecredits->id),
            'body' => $tmpAuth
        ));
        $response = $this->client->processRequest($request);
        return new DirectDebit\StandaloneCredits($response);
    }

    /**
     * Lookup StandaloneCredits.
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    public function getStandaloneCredit( DirectDebit\StandaloneCredits $standalonecredits )
    {
        $standalonecredits->setRequiredFields(array('id'));
        $standalonecredits->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI($this->standalonePath . $this->uriseparator . $standalonecredits->id),
            'body' => $standalonecredits
        ));

        $response = $this->client->processRequest($request);
        return new DirectDebit\StandaloneCredits($response);
    }

    /**
     * Lookup StandaloneCredits.
     * @param \Paysafe\DirectDebit\StandaloneCredits $standalonecredits
     * @return \Paysafe\DirectDebit\StandaloneCredits
     * @throws PaysafeException
     */
    public function getStandaloneCredits( DirectDebit\StandaloneCredits $standalonecredits, DirectDebit\Filter $filter )
    {
        $queryStr = array();
        if ($standalonecredits && $standalonecredits->merchantRefNum)
        {
            $queryStr['merchantRefNum'] = $standalonecredits->merchantRefNum;
        }
        if ($filter)
        {
            if (isset($filter->limit))
            {
                $queryStr['limit'] = $filter->limit;
            }
            if (isset($filter->offset))
            {
                $queryStr['offset'] = $filter->offset;
            }
            if (isset($filter->startDate))
            {
                $queryStr['startDate'] = $filter->startDate;
            }
            if (isset($filter->endDate))
            {
                $queryStr['endDate'] = $filter->endDate;
            }
        }

        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI($this->standalonePath . $this->uriseparator . $standalonecredits->id),
            'queryStr' => $queryStr
        ));
        $response = $this->client->processRequest($request);
        return new DirectDebit\Pagerator($this->client, $response, '\Paysafe\DirectDebit\StandaloneCredits');
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
