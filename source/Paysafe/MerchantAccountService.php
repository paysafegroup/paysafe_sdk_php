<?php

namespace Paysafe;

use Paysafe\AccountManagement\MerchantAccount;

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
    private $uri = "accountmanagement/v1/merchants";

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
            'uri' => $this->prepareURI('/' . $merchantAccount->merchantId . "/accounts"),
            'body' => $merchantAccount
        ));
//        die($this->prepareURI('/' . $merchantAccount->merchantId . "/accounts"));
        $response = $this->client->processRequest($request);
var_dump($response);
        return new MerchantAccount($response);
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
