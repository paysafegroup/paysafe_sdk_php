<?php

namespace Paysafe;

class ThreeDSecureV2Service
{
    /**
	 * @var PaysafeApiClient
	 */
    private $client;

    /**
	 * The uri for the threed secure v2 api.
	 * @var string
	 */
    private $uri = "threedsecure/v2/accounts/";

    /**
	 * Initialize the threedsecurev2 payment service.
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
             'uri' => 'threedsecure/monitor'
        ));

        $response = $this->client->processRequest($request);
        return ($response['status'] == 'READY');
    }

    /**
	 * Authentications.
	 *
	 * @param  \Paysafe\ThreeDSecureV2\Authentications $authentications
	 * @return ThreeDSecureV2\Authentications
	 * @throws PaysafeException
	 */
    public function authentications(ThreeDSecureV2\Authentications $authentications)
    {
        $authentications->setRequiredFields(array(
         
             'deviceFingerprintingId',
             'merchantRefNum',
             'amount',
             'currency',
             'card',
             'merchantUrl',
             'authenticationPurpose',
             'deviceChannel',
             'messageCategory'
            
        ));
        $authentications->setOptionalFields(array(
             'orderItemDetails',
             'requestorChallengePreference',
             'purchasedGiftCardDetails',
             'browserDetails',
             'userAccountDetails',
             'billingDetails',
             'shippingDetails',
             'profile',
             'maxAuthorizationsForInstalmentPayment',
             'transactionIntent',
             'billingCycle',
             'initialPurchaseTime',
             'mcc',
             'merchantName',
             'electronicDelivery' 

        ));

        $request = new Request(array(
             'method' => Request::POST,
             'uri' => $this->prepareURI("/authentications"),
             'body' => $authentications
        ));
        $response = $this->client->processRequest($request);

        return new ThreeDSecureV2\Authentications($response);
    }
 /**
     * Look Up an authentications Using an ID
     * @param \Paysafe\ThreeDSecureV2\Authentications $authentications
     * @return \Paysafe\ThreeDSecureV2\Authentications
     * @throws PaysafeException
     */
    public function getAuthenticationV2( ThreeDSecureV2\Authentications $authentications )
    {
        $authentications->setRequiredFields(array(
            'id'
        ));
        $authentications->checkRequiredFields();
        $request = new Request(array(
            'method' => Request::GET,
            'uri' => $this->prepareURI("/authentications/" . $authentications->id),
            'body' => $authentications
        ));
        $response = $this->client->processRequest($request);
        return new ThreeDSecureV2\Authentications($response);
    }

    private function prepareURI( $path )
    {
        if (!$this->client->getAccount())
        {
            throw new PaysafeException('Missing or invalid account', 500);
        }
        return $this->uri. $this->client->getAccount(). $path;
    }
}

?>
