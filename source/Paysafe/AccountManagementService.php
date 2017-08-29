<?php

namespace Paysafe;

use Paysafe\AccountManagement\Transfer;

class AccountManagementService
{
    /**
     * @var PaysafeApiClient
     */
    private $client;

    /**
     * The uri for the card payment api.
     * @var string
     */
    private $uri = "accountmanagement/v1";
    private $debitPath = "/debits";
    private $creditPath = "/credits";

    /**
     * Initialize the Account Management service.
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
     * @throws \Paysafe\PaysafeException
     */
    public function monitor()
    {
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => 'accountmanagement/monitor'
        ));

        $response = $this->client->processRequest($request);
        if (!isset($response['status'])) {
            return false;
        }
        return ($response['status'] == 'READY');
    }

    public function transferDebit(Transfer $transfer)
    {
        $request = new Request(array(
               'method' => Request::POST,
               'uri' => $this->prepareURI($this->debitPath),
               'body' => $transfer
           ));

        $response = $this->client->processRequest($request);

        return new Transfer($response);
    }

    public function transferCredit(Transfer $transfer)
    {
        $request = new Request(array(
               'method' => Request::POST,
               'uri' => $this->prepareURI($this->creditPath),
               'body' => $transfer
           ));

        $response = $this->client->processRequest($request);

        return new Transfer($response);
    }

    private function prepareURI($path)
    {
        if (!$this->client->getAccount())
        {
            throw new PaysafeException('Missing or invalid account', 500);
        }

        return $this->uri . "/accounts/" . $this->client->getAccount() . $path;
    }
}
