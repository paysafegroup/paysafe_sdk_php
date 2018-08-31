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

class CustomerVaultService
{

    /**
     * @var PaysafeApiClient
     */
    private $client;

    /**
     * The uri for the customer vault api.
     * @var string
     */
    private $uri = "customervault/v1";

    /**
     * Initialize the customer vault service.
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
     */
    public function monitor()
    {
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => 'customervault/monitor'
        ));

        $response = $this->client->processRequest($request);
        return ($response['status'] == 'READY');
    }

    /**
     * Create profile.
     *
     * @param \Paysafe\CustomerVault\Profile $profile
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function createProfile( CustomerVault\Profile $profile )
    {
        $profile->setRequiredFields(array(
            'merchantCustomerId',
            'locale'
        ));
        $profile->setOptionalFields(array(
            'firstName',
            'middleName',
            'lastName',
            'dateOfBirth',
            'ip',
            'gender',
            'nationality',
            'email',
            'phone',
            'cellPhone',
			'card',
            'cards'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles"),
            'body' => $profile
        ));
        $response = $this->client->processRequest($request);

        return new CustomerVault\Profile($response);
    }

    /**
     * Update profile.
     *
     * @param \Paysafe\CustomerVault\Profile $profile
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function updateProfile( CustomerVault\Profile $profile )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $profile->setRequiredFields(array(
            'merchantCustomerId',
            'locale'
        ));
        $profile->setOptionalFields(array(
            'firstName',
            'middleName',
            'lastName',
            'dateOfBirth',
            'ip',
            'gender',
            'nationality',
            'email',
            'phone',
            'cellPhone'
        ));

        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $profile->id),
            'body' => $profile
        ));
        $response = $this->client->processRequest($request);

        return new CustomerVault\Profile($response);
    }

    /**
     * Delete profile.
     *
     * @param \Paysafe\CustomerVault\Profile $profile
     * @return bool
     * @throws PaysafeException
     */
    public function deleteProfile( CustomerVault\Profile $profile )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $profile->id)
        ));
        $this->client->processRequest($request);
        return true;
    }

    /**
     * Get the profile.
     *
     * @param \Paysafe\CustomerVault\Profile $profile
     * @param bool $includeAddresses
     * @param bool $includeCards
     * @param bool $includeachbankaccount
     * @param bool $includeeftbankaccount
     * @param bool $includebacsbankaccount
     * @param bool $includesepabankaccount
     * @return bool
     * @throws PaysafeException
     */
    public function getProfile( CustomerVault\Profile $profile, $includeAddresses = false, $includeCards = false, $includeachbankaccount = false, $includeeftbankaccount = false, $includebacsbankaccount = false, $includesepabankaccount = false )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();

        $fields = array();
        if ($includeAddresses)
        {
            $fields[] = 'addresses';
        }
        if ($includeCards)
        {
            $fields[] = 'cards';
        }
        if ($includeachbankaccount)
        {
            $fields[] = 'achbankaccounts';
        }
        if ($includeeftbankaccount)
        {
            $fields[] = 'eftbankaccounts';
        }
        if ($includebacsbankaccount)
        {
            $fields[] = 'bacsbankaccounts';
        }
        if ($includesepabankaccount)
        {
            $fields[] = 'sepabankaccounts';
        }

        $queryStr = array();
        if ($fields)
        {
            $queryStr['fields'] = join(',', $fields);
        }

        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $profile->id),
            'queryStr' => $queryStr
        ));
        $response = $this->client->processRequest($request);

        return new CustomerVault\Profile($response);
    }

    /**
     * Create address.
     *
     * @param \Paysafe\CustomerVault\Address $address
     * @return \Paysafe\CustomerVault\Address
     * @throws PaysafeException
     */
    public function createAddress( CustomerVault\Address $address )
    {
        $address->setRequiredFields(array('profileID'));
        $address->checkRequiredFields();
        $address->setRequiredFields(array('country'));
        $address->setOptionalFields(array(
            'nickName',
            'street',
            'street2',
            'city',
            'state',
            'zip',
            'recipientName',
            'phone',
            'defaultShippingAddressIndicator',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $address->profileID . "/addresses"),
            'body' => $address
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $address->profileID;
        return new CustomerVault\Address($response);
    }

    /**
     * Update address.
     *
     * @param \Paysafe\CustomerVault\Address $address
     * @return \Paysafe\CustomerVault\Address
     * @throws PaysafeException
     */
    public function updateAddress( CustomerVault\Address $address )
    {
        $address->setRequiredFields(array(
            'profileID',
            'id'
        ));
        $address->checkRequiredFields();
        $address->setRequiredFields(array('country'));
        $address->setOptionalFields(array(
            'nickName',
            'street',
            'street2',
            'city',
            'state',
            'zip',
            'recipientName',
            'phone',
            'defaultShippingAddressIndicator',
        ));

        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $address->profileID . "/addresses/" . $address->id),
            'body' => $address
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $address->profileID;

        return new CustomerVault\Address($response);
    }

    /**
     * Delete address.
     *
     * @param \Paysafe\CustomerVault\Address $address
     * @return bool
     * @throws PaysafeException
     */
    public function deleteAddress( CustomerVault\Address $address )
    {
        $address->setRequiredFields(array(
            'profileID',
            'id'
        ));
        $address->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $address->profileID . "/addresses/" . $address->id),
        ));
        $this->client->processRequest($request);

        return true;
    }

    /**
     * Get the address.
     *
     * @param \Paysafe\CustomerVault\Address $address
     * @return bool
     * @throws PaysafeException
     */
    public function getAddress( CustomerVault\Address $address )
    {
        $address->setRequiredFields(array(
            'profileID',
            'id'
        ));
        $address->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $address->profileID . "/addresses/" . $address->id),
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $address->profileID;

        return new CustomerVault\Address($response);
    }

    /**
     * Create card.
     *
     * @param \Paysafe\CustomerVault\Card $card
     * @return \Paysafe\CustomerVault\Card
     * @throws PaysafeException
     */
    public function createCard( CustomerVault\Card $card )
    {
        $card->setRequiredFields(array('profileID'));
        $card->checkRequiredFields();
        $card->setRequiredFields(array(
            'cardNum',
            'cardExpiry'
        ));
        $card->setOptionalFields(array(
            'nickName',
            'merchantRefNum',
            'holderName',
            'billingAddressId',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $card->profileID . "/cards"),
            'body' => $card
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $card->profileID;

        return new CustomerVault\Card($response);
    }

    /**
     * Create card from a Single-Use Token.
     *
     * @param \Paysafe\CustomerVault\Card $card
     * @return \Paysafe\CustomerVault\Card
     * @throws PaysafeException
     */
    public function createCardFromSingleUseToken( CustomerVault\Card $card )
    {
        $card->setRequiredFields(array('profileID'));
        $card->checkRequiredFields();
        $card->setRequiredFields(array(
            'singleUseToken',
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $card->profileID . "/cards"),
            'body' => $card
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $card->profileID;

        return new CustomerVault\Card($response);
    }

    /**
     * Update card.
     *
     * @param \Paysafe\CustomerVault\Card $card
     * @return \Paysafe\CustomerVault\Card
     * @throws PaysafeException
     */
    public function updateCard( CustomerVault\Card $card )
    {
        $card->setRequiredFields(array(
            'profileID',
            'id'
        ));
        $card->checkRequiredFields();
        $card->setRequiredFields(array());
        $card->setOptionalFields(array(
            'cardExpiry',
            'nickName',
            'merchantRefNum',
            'holderName',
            'billingAddressId',
            'defaultCardIndicator',
        ));

        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $card->profileID . "/cards/" . $card->id),
            'body' => $card
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $card->profileID;

        return new CustomerVault\Card($response);
    }

    /**
     * Delete card.
     *
     * @param \Paysafe\CustomerVault\Card $card
     * @return bool
     * @throws PaysafeException
     */
    public function deleteCard( CustomerVault\Card $card )
    {
        $card->setRequiredFields(array(
            'profileID',
            'id'
        ));
        $card->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $card->profileID . "/cards/" . $card->id),
        ));
        $this->client->processRequest($request);

        return true;
    }

    /**
     * Get the card.
     *
     * @param \Paysafe\CustomerVault\Card $card
     * @return bool
     * @throws PaysafeException
     */
    public function getCard( CustomerVault\Card $card )
    {
        $card->setRequiredFields(array(
            'profileID',
            'id'
        ));
        $card->checkRequiredFields();

        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $card->profileID . "/cards/" . $card->id),
        ));
        $response = $this->client->processRequest($request);
        $response['profileID'] = $card->profileID;

        return new CustomerVault\Card($response);
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

    /**
     * Creates ACH bank account for given profile id.
     *
     * @param CustomerVault\ACHBankaccounts $bankDetails https://developer.optimalpayments.com/en/documentation/customer-vault-api/ach-bank-accounts/
     * @return \Paysafe\CustomerVault\Profile https://developer.optimalpayments.com/en/documentation/customer-vault-api/profiles/
     * @throws PaysafeException
     */
    public function createACHBankAccount( CustomerVault\ACHBankaccounts $bankDetails )
    {
        $bankDetails->setRequiredFields(array(
            'accountHolderName',
            'accountNumber',
            'routingNumber',
            'billingAddressId',
            'accountType'
        ));

        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'nickName',
            'merchantRefNum'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $bankDetails->id . "/achbankaccounts"),
            'body' => $bankDetails
        ));

        $response = $this->client->processRequest($request);
        return new CustomerVault\ACHBankaccounts($response);
    }

    /**
     * Creates EFT bank account for given profile id.
     *
     * @param CustomerVault\EFTBankaccounts $bankDetails https://developer.optimalpayments.com/en/documentation/customer-vault-api/eft-bank-accounts/
     * @return \Paysafe\CustomerVault\Profile https://developer.optimalpayments.com/en/documentation/customer-vault-api/profiles/
     * @throws PaysafeException
     */
    public function createEFTBankAccount( CustomerVault\EFTBankaccounts $bankDetails )
    {
        $bankDetails->setRequiredFields(array(
            'accountNumber',
            'transitNumber',
            'institutionId',
            'accountHolderName',
            'billingAddressId'
        ));
        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'nickName',
            'merchantRefNum'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $bankDetails->id . "/eftbankaccounts"),
            'body' => $bankDetails
        ));

        $response = $this->client->processRequest($request);
        return new CustomerVault\EFTBankaccounts($response);
    }

    /**
     * Creates BACS bank account for given profile id.
     *
     * @param CustomerVault\ACHBankaccounts $bankDetails https://developer.Paysafe.com/en/documentation/customer-vault-api/bacs-bank-accounts/
     * @return \Paysafe\CustomerVault\Profile https://developer.optimalpayments.com/en/documentation/customer-vault-api/profiles/
     * @throws PaysafeException
     */
    public function createBACSBankAccount( CustomerVault\BACSBankaccounts $bankDetails )
    {
        $bankDetails->setRequiredFields(array(
            'accountNumber',
            'sortCode',
            'accountHolderName',
            'billingAddressId'
        ));
        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'mandates',
            'nickName',
            'merchantRefNum'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $bankDetails->id . "/bacsbankaccounts"),
            'body' => $bankDetails
        ));

        $response = $this->client->processRequest($request);
        return new CustomerVault\BACSBankaccounts($response);
    }

    /**
     * Creates SEPA bank account for given profile id.
     *
     * @param CustomerVault\SEPABankaccounts $bankDetails https://developer.optimalpayments.com/en/documentation/customer-vault-api/sepa-bank-accounts/
     * @return \Paysafe\CustomerVault\Profile https://developer.optimalpayments.com/en/documentation/customer-vault-api/profiles/
     * @throws PaysafeException
     */
    public function createSEPABankAccount( CustomerVault\SEPABankaccounts $bankDetails )
    {
        $bankDetails->setRequiredFields(array(
            'iban',
            'accountHolderName',
            'billingAddressId'
        ));
        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'bic',
            'mandates',
            'nickName',
            'merchantRefNum'
        ));

        $request = new Request(array(
            'method' => Request::POST,
            'uri' => $this->prepareURI("/profiles/" . $bankDetails->id . "/sepabankaccounts"),
            'body' => $bankDetails
        ));

        $response = $this->client->processRequest($request);
        return new CustomerVault\SEPABankaccounts($response);
    }

    /**
     * Lookup ACH bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\ACHBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function getACHBankAccount( CustomerVault\Profile $profile, CustomerVault\ACHBankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/achbankaccounts/" . $bankDetails->id),
            'body' => $profile
        ));
        print_r($request);
        $response = $this->client->processRequest($request);
        print_r($response);
        return new CustomerVault\ACHBankaccounts($response);
    }

    /**
     * Lookup EFT bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\EFTBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function getEFTBankAccount( CustomerVault\Profile $profile, CustomerVault\EFTBankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/eftbankaccounts/" . $bankDetails->id),
            'body' => $profile
        ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\EFTBankaccounts($response);
    }

    /**
     * Lookup BACS bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\BACSBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function getBACSBankAccount( CustomerVault\Profile $profile, CustomerVault\BACSBankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/bacsbankaccounts/" . $bankDetails->id),
            'body' => $profile
        ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\BACSBankaccounts($response);
    }

    /**
     * Lookup SEPA bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\SEPABankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function getSEPABankAccount( CustomerVault\Profile $profile, CustomerVault\SEPABankaccounts $bankDetails )
    {

        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/sepabankaccounts/" . $bankDetails->id),
            'body' => $profile
        ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\SEPABankaccounts($response);
    }

    /**
     * Update ACH bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\ACHBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function updateACHBankAccount( CustomerVault\Profile $profile, CustomerVault\ACHBankaccounts $bankDetails )
    {
		$profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array(
            'accountHolderName',
            'routingNumber',
            'billingAddressId',
            'accountType'
        ));
        $bankDetails->checkRequiredFields();        
        $bankDetails->setOptionalFields(array(
            'nickName',
            'merchantRefNum',
            'accountNumber'
        ));

        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/achbankaccounts/" . $bankDetails->id),
            'body' => $bankDetails
        ));

        $response = $this->client->processRequest($request);
        return new CustomerVault\ACHBankaccounts($response);
    }

    /**
     * Update EFT bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\EFTBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function updateEFTBankAccount( CustomerVault\Profile $profile, CustomerVault\EFTBankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
		$profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array(
            'transitNumber',
            'institutionId',
            'accountHolderName',
            'billingAddressId'
        ));
        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'nickName',
            'merchantRefNum',
            'accountNumber'
        ));
        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/eftbankaccounts/" . $bankDetails->id),
            'body' => $bankDetails
        ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\EFTBankaccounts($response);
    }

    /**
     * Update BACS bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\BACSBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function updateBACSBankAccount( CustomerVault\Profile $profile, CustomerVault\BACSBankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
		$profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array(
            'accountHolderName',
            'sortCode',
            'accountNumber',
            'billingAddressId'
        ));
        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'nickName',
            'merchantRefNum'
        ));
        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/bacsbankaccounts/" . $bankDetails->id),
            'body' => $bankDetails
        ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\BACSBankaccounts($response);
    }

    /**
     * Update SEPA bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\SEPABankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function updateSEPABankAccount( CustomerVault\Profile $profile, CustomerVault\SEPABankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
		$profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array(
            'accountHolderName',
            'iban',
            'billingAddressId'
        ));
        $bankDetails->checkRequiredFields();
        $bankDetails->setOptionalFields(array(
            'bic',
            'nickName',
            'merchantRefNum'
        ));
        $request = new Request(array(
            'method' => Request::PUT,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/sepabankaccounts/" . $bankDetails->id),
            'body' => $bankDetails
        ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\SEPABankaccounts($response);
    }

    /**
     * Delete ACH bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\ACHBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function deleteACHBankAccount( CustomerVault\Profile $profile, CustomerVault\ACHBankaccounts $bankDetails )
    {
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/achbankaccounts/" . $bankDetails->id)
        ));
        $response = $this->client->processRequest($request);
        return $response;
    }

    /**
     * Delete EFT bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\EFTBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function deleteEFTBankAccount( CustomerVault\Profile $profile, CustomerVault\EFTBankaccounts $bankDetails )
    {
        
        $bankDetails->setRequiredFields(array('id'));
		$bankDetails->checkRequiredFields();
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/eftbankaccounts/" . $bankDetails->id)
        ));
        $response = $this->client->processRequest($request);
        return $response;
    }

    /**
     * Delete BACS bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\BACSBankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function deleteBACSBankAccount( CustomerVault\Profile $profile, CustomerVault\BACSBankaccounts $bankDetails )
    {
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
		$profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/bacsbankaccounts/" . $bankDetails->id)
        ));
        $response = $this->client->processRequest($request);
        return $response;
    }

    /**
     * Delete SEPA bank account
     *
     * @param CustomerVault\Profile $profile
     * @param CustomerVault\SEPABankaccounts $bankDetails
     * @return \Paysafe\CustomerVault\Profile
     * @throws PaysafeException
     */
    public function deleteSEPABankAccount( CustomerVault\Profile $profile, CustomerVault\SEPABankaccounts $bankDetails )
    {
        $profile->setRequiredFields(array('id'));
        $profile->checkRequiredFields();
        $bankDetails->setRequiredFields(array('id'));
        $bankDetails->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::DELETE,
            'uri' => $this->prepareURI("/profiles/" . $profile->id . "/sepabankaccounts/" . $bankDetails->id)
        ));
        $response = $this->client->processRequest($request);
        return $response;
    }

    /**
     * Process Create a Mandate.
     * @param \Paysafe\CustomerVault\Mandate $mandate
     * @return \Paysafe\CustomerVault\Mandate
     * @throws PaysafeException
     */
    public function createMandates(CustomerVault\Mandates $mandates ,$bankaccounts) {
         $mandates->setRequiredFields(array(
             'reference'
        ));
        $mandates->checkRequiredFields();
        
           $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/profiles/" . $mandates->profileID."/".$bankaccounts."/".$mandates->bankAccountId."/mandates"),
             'body' => $mandates
            ));

        $response = $this->client->processRequest($request);
        return new CustomerVault\Mandates($response);
        
    }
       /**
         * Process Look Up a Mandates
         * @param \Paysafe\CustomerVault\Mandate $mandates
         * @return \Paysafe\CustomerVault\Mandates
         * @throws PaysafeException
         */
    
     public function getMandates(CustomerVault\Mandates $mandates) {
      
        $mandates->setRequiredFields(array(
             'id'
        ));
        $mandates->checkRequiredFields();
        $request = new Request(array(
              'method' => Request::GET,
              'uri' => $this->prepareURI("/profiles/" . $mandates->profileID."/mandates/".$mandates->id),
              'body' => $mandates
            ));
        $response = $this->client->processRequest($request);
        return new CustomerVault\Mandates($response);
        
    }
    /**
         * Process Update a Mandates
         * @param \Paysafe\CustomerVault\Mandate $mandates
         * @return \Paysafe\CustomerVault\Mandates
         * @throws PaysafeException
         */
    public function updateMandates(CustomerVault\Mandates $mandates) {
     
        $mandates->setRequiredFields(array(
             'status' 
        ));
        $mandates->checkRequiredFields();
        $request = new Request(array(
             'method' => Request::PUT,
             'uri' => $this->prepareURI("/profiles/" . $mandates->profileID."/mandates/".$mandates->id)
            ,'body' => $mandates
            ));
        
        $response = $this->client->processRequest($request);
        return new CustomerVault\Mandates($response);
        
    }
    
        /**
         * Process Delete a Mandates
         * @param \Paysafe\CustomerVault\Mandate $mandates
         * @return \Paysafe\CustomerVault\Mandates
         * @throws PaysafeException
         */
    public function deleteMandates(CustomerVault\Mandates $mandates) {
        $request = new Request(array(
             'method' => Request::DELETE,
             'uri' => $this->prepareURI("/profiles/" . $mandates->profileID."/mandates/".$mandates->id),
              'body' => $mandates
            ));
        $response = $this->client->processRequest($request);
        return $response;
        
    }
}
