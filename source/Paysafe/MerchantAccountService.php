<?php

namespace Paysafe;

use Paysafe\AccountManagement\MerchantAccount;
use Paysafe\AccountManagement\RecoveryQuestion;
use Paysafe\AccountManagement\RecoveryQuestionsList;
use Paysafe\AccountManagement\User;

class MerchantAccountService
{

    /**
     * @var PaysafeApiClient
     */
    private $client;

    /**
     * The uri for the customer vault api.
     * @var string
     */
    private $uri = "accountmanagement/v1";

    /**
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
     */
    public function monitor()
    {
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => 'accountmanagement/monitor'
        ));

        $response = $this->client->processRequest($request);
        return ($response['status'] == 'READY');
    }

    /**
     * Create Merchant Account
     *
     * @param MerchantAccount $merchantAccount
     * @return MerchantAccount
     * @throws PaysafeException
     */
    public function createMerchantAccount( MerchantAccount $merchantAccount )
    {
        $merchantAccount->setRequiredFields(array(
            'name',
            'currency',
            'region',
            'legalEntity',
            'productCode'
        ));
        $merchantAccount->setOptionalFields(array(
            'merchantId',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI('/merchants/' . $merchantAccount->merchantId . "/accounts"),
            'body' => $merchantAccount
        ));
        $response = $this->client->processRequest($request);
        return new MerchantAccount($response);
    }

    /**
     * Create New User
     *
     * @param User $user
     * @return User
     * @throws PaysafeException
     */
    public function createNewUser( User $user )
    {
        $user->setRequiredFields(array(
            'userName',
            'password',
            'email',
            'recoveryQuestion',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI('/accounts/' . $this->client->getAccount() . "/users"),
            'body' => $user
        ));
        $response = $this->client->processRequest($request);
        return new User($response);
    }

    /**
     * Get Recovery Questions
     *
     * @return RecoveryQuestionsList
     * @throws PaysafeException
     */
    public function getRecoveryQuestions()
    {
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI('/recoveryquestions')
        ));
        $response = $this->client->processRequest($request);
        return new RecoveryQuestionsList($response);
    }

    /**
     * Prepare the uri for submission to the api.
     *
     * @param type $path
     * @return string uri
     * @throw PaysafeException
     */
    private function prepareURI( $path )
    {
        return $this->uri . $path;
    }
}
