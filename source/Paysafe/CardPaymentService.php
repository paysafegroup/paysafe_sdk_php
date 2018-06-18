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

namespace Paysafe;

class CardPaymentService
{
    /**
	 * @var PaysafeApiClient
	 */
    private $client;

    /**
	 * The uri for the card payment api.
	 * @var string
	 */
    private $uri = "cardpayments/v1";

    /**
	 * Initialize the card payment service.
	 *
	 * @param \Paysafe\PaysafeApiClient $client
	 */
    public function __construct(PaysafeApiClient $client)
    {
        $this->client = $client;
    }

    /**
	 * Monitor.
	 *
	 * @return bool true if successful
	 * @throws PaysafeException
	 */
    public function monitor()
    {
        $request = new Request(array(
             'method' => Request::GET,
             'uri' => 'cardpayments/monitor'
        ));

        $response = $this->client->processRequest($request);
        return ($response['status'] == 'READY');
    }

    /**
	 * Authorize.
	 *
	 * @param CardPayments\Authorization $auth
	 * @return CardPayments\Authorization
	 * @throws PaysafeException
	 */
    public function authorize(CardPayments\Authorization $auth)
    {
        $auth->setRequiredFields(array(
             'merchantRefNum',
             'amount',
             'card'
        ));
        $auth->setOptionalFields(array(
             'settleWithAuth',
	     'profile',	
             'customerIp',
             'dupCheck',
             'description',
             'authentication',
             'billingDetails',
             'shippingDetails',
             'recurring',
             'merchantDescriptor',
             'accordD',
             'description',
             'splitpay',
	     'storedCredential'
        ));

        $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/auths"),
             'body' => $auth
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\Authorization($response);
    }

    /**
	 * Cancel held authorization.
	 *
	 * @param \Paysafe\CardPayments\Authorization $auth
	 * @return \Paysafe\CardPayments\Authorization
	 * @throws PaysafeException
	 */
    public function cancelHeldAuth(CardPayments\Authorization $auth)
    {
        $auth->setRequiredFields(array('id'));
        $auth->checkRequiredFields();

        $tmpAuth = new CardPayments\Authorization(array(
             'status' => 'CANCELLED'
        ));
        $request = new Request(array(
             'method' => Request::PUT,
             'uri' => $this->prepareURI("/auths/" . $auth->id),
             'body' => $tmpAuth
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\Authorization($response);
    }

    /**
	 * Approve held authorization.
	 *
	 * @param \Paysafe\CardPayments\Authorization $auth
	 * @return \Paysafe\CardPayments\Authorization
	 * @throws PaysafeException
	 */
    public function approveHeldAuth(CardPayments\Authorization $auth)
    {
        $auth->setRequiredFields(array('id'));
        $auth->checkRequiredFields();

        $tmpAuth = new CardPayments\Authorization(array(
             'status' => 'COMPLETED'
        ));
        $request = new Request(array(
             'method' => Request::PUT,
             'uri' => $this->prepareURI("/auths/" . $auth->id),
             'body' => $tmpAuth
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\Authorization($response);
    }

    /**
	 * Reverse Authorization.
	 *
	 * @param \Paysafe\CardPayments\AuthorizationReversal $authReversal
	 * @return \Paysafe\CardPayments\AuthorizationReversal
	 * @throws PaysafeException
	 */
    public function reverseAuth(CardPayments\AuthorizationReversal $authReversal)
    {
        $authReversal->setRequiredFields(array('authorizationID'));
        $authReversal->checkRequiredFields();
        $authReversal->setRequiredFields(array('merchantRefNum'));
        $authReversal->setOptionalFields(array(
             'amount',
             'dupCheck'
        ));

        $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/auths/" . $authReversal->authorizationID . "/voidauths"),
             'body' => $authReversal
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\AuthorizationReversal($response);
    }

    /**
	 * Settlement.
	 *
	 * @param \Paysafe\CardPayments\Settlement $settlement
	 * @return \Paysafe\CardPayments\Settlement
	 * @throws PaysafeException
	 */
    public function settlement(CardPayments\Settlement $settlement)
    {
        $settlement->setRequiredFields(array('authorizationID'));
        $settlement->checkRequiredFields();
        $settlement->setRequiredFields(array('merchantRefNum'));
        $settlement->setOptionalFields(array(
             'amount',
             'dupCheck',
             'splitpay',
        ));

        $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/auths/" . $settlement->authorizationID . "/settlements"),
             'body' => $settlement
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\Settlement($response);
    }

    /**
	 * Cancel settlement.
	 *
	 * @param \Paysafe\CardPayments\Settlement $settlement
	 * @return \Paysafe\CardPayments\Settlement
	 * @throws PaysafeException
	 */
    public function cancelSettlement(CardPayments\Settlement $settlement)
    {
        $settlement->setRequiredFields(array('id'));
        $settlement->checkRequiredFields();

        $tmpSettlement = new CardPayments\Settlement(array(
             'status' => 'CANCELLED'
        ));
        $request = new Request(array(
             'method' => Request::PUT,
             'uri' => $this->prepareURI("/settlements/" . $settlement->id),
             'body' => $tmpSettlement
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\Settlement($response);
    }

    /**
	 * Refund.
	 *
	 * @param \Paysafe\CardPayments\Refund $refund
	 * @return \Paysafe\CardPayments\Refund
	 * @throws PaysafeException
	 */
    public function refund(CardPayments\Refund $refund)
    {
        $refund->setRequiredFields(array('settlementID'));
        $refund->checkRequiredFields();
        $refund->setRequiredFields(array('merchantRefNum'));
        $refund->setOptionalFields(array(
             'amount',
             'dupCheck',
             'splitpay',
        ));

        $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/settlements/" . $refund->settlementID . "/refunds"),
             'body' => $refund
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Refund($response);
    }

    /**
	 * Cancel Refund.
	 *
	 * @param \Paysafe\CardPayments\Refund $refund
	 * @return \Paysafe\CardPayments\Refund
	 * @throws PaysafeException
	 */
    public function cancelRefund(CardPayments\Refund $refund)
    {
        $refund->setRequiredFields(array('id'));
        $refund->checkRequiredFields();

        $tmpRefund = new CardPayments\Refund(array(
             'status' => 'CANCELLED'
        ));
        $request = new Request(array(
             'method' => Request::PUT,
             'uri' => $this->prepareURI("/refunds/" . $refund->id),
             'body' => $tmpRefund
        ));
        $response = $this->client->processRequest($request);

        return new CardPayments\Refund($response);
    }

    /**
	 * Verify.
	 *
	 * @param \Paysafe\CardPayments\Verification $verify
	 * @return \Paysafe\CardPayments\Verification
	 * @throws PaysafeException
	 */
    public function verify(CardPayments\Verification $verify)
    {
        $verify->setRequiredFields(array(
             'merchantRefNum',
             'card',
        ));
        $verify->setOptionalFields(array(
             'profile',
             'customerIp',
             'dupCheck',
             'description',
             'billingDetails'
        ));

        $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/verifications"),
             'body' => $verify
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Verification($response);
    }

    /**
	 * Get the authorization.
	 *
	 * @param CardPayments\Authorization $auth
	 * @return CardPayments\Authorization
	 * @throws PaysafeException
	 */
    public function getAuth(CardPayments\Authorization $auth)
    {
        $auth->setRequiredFields(array('id'));
        $auth->checkRequiredFields();

        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/auths/" . $auth->id)
        ));

        $response = $this->client->processRequest($request);
        return new CardPayments\Authorization($response);
    }

    /**
	 * Get the authrozation reversal
	 *
	 * @param CardPayments\AuthorizationReversal $authReversal
	 * @return CardPayments\AuthorizationReversal
	 * @throws PaysafeException
	 */
    public function getAuthReversal(CardPayments\AuthorizationReversal $authReversal)
    {
        $authReversal->setRequiredFields(array('id'));
        $authReversal->checkRequiredFields();

        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/voidauths/" . $authReversal->id)
        ));

        $response = $this->client->processRequest($request);
        return new CardPayments\AuthorizationReversal($response);
    }

    /**
	 * Get the settlement.
	 *
	 * @param CardPayments\Settlement $settlement
	 * @return CardPayments\Settlement
	 * @throws PaysafeException
	 */
    public function getSettlement(CardPayments\Settlement $settlement)
    {
        $settlement->setRequiredFields(array('id'));
        $settlement->checkRequiredFields();

        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/settlements/" . $settlement->id)
        ));

        $response = $this->client->processRequest($request);
        return new CardPayments\Settlement($response);
    }

    /**
	 * Get the refund.
	 *
	 * @param CardPayments\Refund $refund
	 * @return CardPayments\Refund[]
	 * @throws PaysafeException
	 */
    public function getRefund(CardPayments\Refund $refund)
    {
        $refund->setRequiredFields(array('id'));
        $refund->checkRequiredFields();

        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/refunds/" . $refund->id)
        ));

        $response = $this->client->processRequest($request);
        return new CardPayments\Refund($response);
    }

    /**
	 * Get the verification.
	 *
	 * @param CardPayments\Verification $verify
	 * @return CardPayments\Verification
	 * @throws PaysafeException
	 */
    public function getVerification(CardPayments\Verification $verify)
    {
        $verify->setRequiredFields(array('id'));
        $verify->checkRequiredFields();

        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/verifications/" . $verify->id)
        ));

        $response = $this->client->processRequest($request);
        return new CardPayments\Verification($response);
    }

    /**
	 * Get matching authorizations.
	 *
	 * @param CardPayments\Authorization $auth
	 * @param CardPayments\Filter $filter
	 * @return CardPayments\Authorization[] iterator
	 * @throws PaysafeException
	 */
    public function getAuths(CardPayments\Authorization $auth = null, CardPayments\Filter $filter = null)
    {
        $queryStr = array();
        if($auth && $auth->merchantRefNum) {
            $queryStr['merchantRefNum'] = $auth->merchantRefNum;
        }
        if($filter) {
            if(isset($filter->limit)) {
                $queryStr['limit'] = $filter->limit;
            }
            if(isset($filter->offset)) {
                $queryStr['offset'] = $filter->offset;
            }
            if(isset($filter->startDate)) {
                $queryStr['startDate'] = $filter->startDate;
            }
            if(isset($filter->endDate)) {
                $queryStr['endDate'] = $filter->endDate;
            }
        }
        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/auths"),
             'queryStr' => $queryStr
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Pagerator($this->client, $response, '\Paysafe\CardPayments\Authorization');
    }

    /**
	 * Get matching authorization reversals.
	 *
	 * @param CardPayments\AuthorizationReversal $authReversal
	 * @param CardPayments\Filter $filter
	 * @return CardPayments\AuthorizationReversal[] iterator
	 * @throws PaysafeException
	 */
    public function getAuthReversals(CardPayments\AuthorizationReversal $authReversal = null, CardPayments\Filter $filter = null)
    {
        $queryStr = array();
        if($authReversal && $authReversal->merchantRefNum) {
            $queryStr['merchantRefNum'] = $authReversal->merchantRefNum;
        }
        if($filter) {
            if(isset($filter->limit)) {
                $queryStr['limit'] = $filter->limit;
            }
            if(isset($filter->offset)) {
                $queryStr['offset'] = $filter->offset;
            }
            if(isset($filter->startDate)) {
                $queryStr['startDate'] = $filter->startDate;
            }
            if(isset($filter->endDate)) {
                $queryStr['endDate'] = $filter->endDate;
            }
        }
        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/voidauths"),
             'queryStr' => $queryStr
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Pagerator($this->client, $response, '\Paysafe\CardPayments\AuthorizationReversal');
    }

    /**
	 * Get matching settlements.
	 *
	 * @param CardPayments\Settlement $settlement
	 * @param CardPayments\Filter $filter
	 * @return CardPayments\Settlement[] iterator
	 * @throws PaysafeException
	 */
    public function getSettlements(CardPayments\Settlement $settlement = null, CardPayments\Filter $filter = null)
    {
        $queryStr = array();
        if($settlement && $settlement->merchantRefNum) {
            $queryStr['merchantRefNum'] = $settlement->merchantRefNum;
        }
        if($filter) {
            if(isset($filter->limit)) {
                $queryStr['limit'] = $filter->limit;
            }
            if(isset($filter->offset)) {
                $queryStr['offset'] = $filter->offset;
            }
            if(isset($filter->startDate)) {
                $queryStr['startDate'] = $filter->startDate;
            }
            if(isset($filter->endDate)) {
                $queryStr['endDate'] = $filter->endDate;
            }
        }
        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/settlements"),
             'queryStr' => $queryStr
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Pagerator($this->client, $response, '\Paysafe\CardPayments\Settlement');
    }

    /**
	 * Get matching refunds.
	 *
	 * @param CardPayments\Refund $refund
	 * @param CardPayments\Filter $filter
	 * @return CardPayments\Refund[] iterator
	 * @throws PaysafeException
	 */
    public function getRefunds(CardPayments\Refund $refund = null, CardPayments\Filter $filter = null)
    {
        $queryStr = array();
        if($refund && $refund->merchantRefNum) {
            $queryStr['merchantRefNum'] = $refund->merchantRefNum;
        }
        if($filter) {
            if(isset($filter->limit)) {
                $queryStr['limit'] = $filter->limit;
            }
            if(isset($filter->offset)) {
                $queryStr['offset'] = $filter->offset;
            }
            if(isset($filter->startDate)) {
                $queryStr['startDate'] = $filter->startDate;
            }
            if(isset($filter->endDate)) {
                $queryStr['endDate'] = $filter->endDate;
            }
        }
        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/refunds"),
             'queryStr' => $queryStr
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Pagerator($this->client, $response, '\Paysafe\CardPayments\Refund');
    }

    /**
	 * Get matching verifications.
	 *
	 * @param CardPayments\Verification $verify
	 * @param CardPayments\Filter $filter
	 * @return CardPayments\Verification[] iterator
	 * @throws PaysafeException
	 */
    public function getVerifications(CardPayments\Verification $verify = null, CardPayments\Filter $filter = null)
    {
        $queryStr = array();
        if($verify && $verify->merchantRefNum) {
            $queryStr['merchantRefNum'] = $verify->merchantRefNum;
        }
        if($filter) {
            if(isset($filter->limit)) {
                $queryStr['limit'] = $filter->limit;
            }
            if(isset($filter->offset)) {
                $queryStr['offset'] = $filter->offset;
            }
            if(isset($filter->startDate)) {
                $queryStr['startDate'] = $filter->startDate;
            }
            if(isset($filter->endDate)) {
                $queryStr['endDate'] = $filter->endDate;
            }
        }
        $request = new Request(array(
             'method' => Request::GET,
             'uri' => $this->prepareURI("/verifications"),
             'queryStr' => $queryStr
        ));

        $response = $this->client->processRequest($request);

        return new CardPayments\Pagerator($this->client, $response, '\Paysafe\CardPayments\Verification');
    }

    /**
	 * Prepare the uri for submission to the api.
	 *
	 * @param type $path
	 * @return string uri
	 * @throw PaysafeException
	 */
    private function prepareURI($path)
    {
        if (!$this->client->getAccount()) {
            throw new PaysafeException('Missing or invalid account', 500);
        }
        return $this->uri . '/accounts/' . $this->client->getAccount() . $path;
    }

}
