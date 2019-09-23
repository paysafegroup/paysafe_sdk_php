<?php

//namespace Paysafe\ThreeDSecureV2;

require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\ThreeDSecureV2\Authentications;
use Paysafe\PaysafeException;
use PHPUnit\Framework\TestCase;


require_once 'PHPUnit/Autoload.php';


class AuthenticationTest extends PHPUnit_Framework_TestCase {

    protected static $authenticationId;
    
	public function testThreeDSecureV2ServiceAvailable() {
		$this->assertTrue($this->getClient()->threeDSecureV2Service()->monitor());
    }

    
    public function testProcessAuthentication() {
        
		$response = $this->getClient()->threeDSecureV2Service()->authentications(new Authentications(array(
			       'amount' => 123,
             'currency' => "EUR",
             'mcc' => "0742",
             'merchantName' => "Merchant Name Inc",
             'merchantRefNum' => uniqid($this->generateRandomString()),
             'merchantUrl'=> "https://mysite.com",
             'card' => array(
                'cardExpiry' => array(
                      'month' => Date('n'),
                      'year' => Date('Y'),
                ),
                'cardNum' => "4111111111111111",
                'holderName' => "John Smith"    
           ),

			 'billingDetails' => array(
                 'city' => "New York",
                 'country' => "US",
                 'state' => 'AL',
                 'street' => "My street 1",
                 'street2' => "My street 2",
                'zip' => "M5H 2N2",
                'useAsShippingAddress' => 'false'
             ),
             'shippingDetails'=> array(
                'city' =>  "New York",
                'country'=> "US",
                'state' => "AL",
                'street' => "My street 1",
                'street2' => "My street 2",
                'zip' => "CHY987",
                'shipMethod' => "S"
             ),
              'profile'=> array (
                'cellPhone' => "+154657854697",
                'email' => "example@example.com",
                'phone' => "+154657854697"
        ),

 'deviceFingerprintingId' => "dd45e08a-8eab-443a-a6f3-4361f92bc7d9",
  'deviceChannel' => "BROWSER",
  'requestorChallengePreference' => "NO_PREFERENCE",
  'messageCategory' => "PAYMENT",
  'transactionIntent' => "GOODS_OR_SERVICE_PURCHASE",
  'authenticationPurpose' => "PAYMENT_TRANSACTION",
  'maxAuthorizationsForInstalmentPayment' => 2,
  'initialPurchaseTime' => "2019-01-21T14:47:31.540Z",
  'billingCycle' => array(
    'endDate' => "2014-01-26",
    'frequency' => 1

  ),
  'orderItemDetails' => array(
    'preOrderItemAvailabilityDate' =>  "2014-01-26",
    'preOrderPurchaseIndicator' => "MERCHANDISE_AVAILABLE",
    'reorderItemsIndicator' => "FIRST_TIME_ORDER",
    'shippingIndicator' => "SHIP_TO_BILLING_ADDRESS"
  ),

  'purchasedGiftCardDetails' => array(
    'amount' => 1234,
    'count' => 2,
    'currency' => "USD"
  ),

  'userAccountDetails' => array(
    'addCardAttemptsForLastDay' => 1,
    'changedDate' => "2010-01-26",
    'changedRange' => "DURING_TRANSACTION",
    'createdDate' => "2010-01-26",
    'createdRange' => "NO_ACCOUNT",
    'passwordChangedDate' => "2012-01-26",
    'passwordChangedRange' => "NO_CHANGE",
    'paymentAccountDetails' => array(
      'createdRange' => "NO_ACCOUNT",
      'createdDate' => "2010-01-26"
    ),
    'priorThreeDSAuthentication' => array(
      'data' => "Some up to 2048 bytes undefined data",
      'method' => "FRICTIONLESS_AUTHENTICATION",
      'id' => "123e4567-e89b-12d3-a456-426655440000",
      'time' => "2014-01-26T10:32:28Z"
  ),
  'shippingDetailsUsage' => array(
    'cardHolderNameMatch' => true,
    'initialUsageDate' => "2014-01-26",
    'initialUsageRange' => "CURRENT_TRANSACTION"
  ),
  'suspiciousAccountActivity' => true,
  'totalPurchasesSixMonthCount' => 1,
  'transactionCountForPreviousDay' => 1,
  'transactionCountForPreviousYear' => 3,
  'travelDetails' => array(
    'isAirTravel' => true,
    'airlineCarrier' =>  "Wizz air",
    'departureDate' => "2014-01-26",
    'destination' => "SOF",
    'origin' => "BCN",
    'passengerFirstName' => "John",
    'passengerLastName' => "Smith"
  ),
  'userLogin' => array(
    'authenticationMethod' => "NO_LOGIN",
    'data' => "Some up to 2048 bytes undefined data",
    'time' => "2014-01-26T10:32:28Z"
  )
  ),
'browserDetails' => array(
  'acceptHeader' => "*/*",
  'colorDepthBits' => "24",
  'customerIp' => "207.48.141.20",
  'javascriptEnabled' => true,
  'javaEnabled' => true,
  'language' => "en-US",
  'screenHeight' => 768,
  'screenWidth' => 1024,
  'timezoneOffset' => 240,
  'userAgent' => "Mozilla/4.0 (compatible; Win32; WinHttp.WinHttpRequest.5)"
)
)));

		self::$authenticationId = $response->id;

  }
  public function testProcessAuthenticationwithpaymentToken() {
        
		$response = $this->getClient()->threeDSecureV2Service()->authentications(new Authentications(array(
			 'amount' => 123,
             'currency' => "EUR",
             'mcc' => "0742",
             'merchantName' => "Merchant Name Inc",
             'merchantRefNum' => uniqid($this->generateRandomString()),
             'merchantUrl'=> "https://mysite.com",
             'card' => array(
              'paymentToken' =>  $this->generateSingleUseToken()
           ),

			 'billingDetails' => array(
                 'city' => "New York",
                 'country' => "US",
                 'state' => 'AL',
                 'street' => "My street 1",
                 'street2' => "My street 2",
                  'zip' => "M5H 2N2",
                  'useAsShippingAddress' => 'false'
             ),
             'shippingDetails'=> array(
                'city' =>  "New York",
                'country'=> "US",
                'state' => "AL",
                'street' => "My street 1",
                'street2' => "My street 2",
                'zip' => "CHY987",
                'shipMethod' => "S"
             ),
              'profile'=> array (
                'cellPhone' => "+154657854697",
                'email' => "example@example.com",
                'phone' => "+154657854697"
        ),

 'deviceFingerprintingId' => "dd45e08a-8eab-443a-a6f3-4361f92bc7d9",
  'deviceChannel' => "BROWSER",
  'requestorChallengePreference' => "NO_PREFERENCE",
  'messageCategory' => "PAYMENT",
  'transactionIntent' => "GOODS_OR_SERVICE_PURCHASE",
  'authenticationPurpose' => "PAYMENT_TRANSACTION",
  'maxAuthorizationsForInstalmentPayment' => 2,
  'initialPurchaseTime' => "2019-01-21T14:47:31.540Z",
  'billingCycle' => array(
    'endDate' => "2014-01-26",
    'frequency' => 1

  ),
  'orderItemDetails' => array(
    'preOrderItemAvailabilityDate' =>  "2014-01-26",
    'preOrderPurchaseIndicator' => "MERCHANDISE_AVAILABLE",
    'reorderItemsIndicator' => "FIRST_TIME_ORDER",
    'shippingIndicator' => "SHIP_TO_BILLING_ADDRESS"
  ),

  'purchasedGiftCardDetails' => array(
    'amount' => 1234,
    'count' => 2,
    'currency' => "USD"
  ),

  'userAccountDetails' => array(
    'addCardAttemptsForLastDay' => 1,
    'changedDate' => "2010-01-26",
    'changedRange' => "DURING_TRANSACTION",
    'createdDate' => "2010-01-26",
    'createdRange' => "NO_ACCOUNT",
    'passwordChangedDate' => "2012-01-26",
    'passwordChangedRange' => "NO_CHANGE",
    'paymentAccountDetails' => array(
      'createdRange' => "NO_ACCOUNT",
      'createdDate' => "2010-01-26"
    ),
    'priorThreeDSAuthentication' => array(
      'data' => "Some up to 2048 bytes undefined data",
      'method' => "FRICTIONLESS_AUTHENTICATION",
      'id' => "123e4567-e89b-12d3-a456-426655440000",
      'time' => "2014-01-26T10:32:28Z"
  ),
  'shippingDetailsUsage' => array(
    'cardHolderNameMatch' => true,
    'initialUsageDate' => "2014-01-26",
    'initialUsageRange' => "CURRENT_TRANSACTION"
  ),
  'suspiciousAccountActivity' => true,
  'totalPurchasesSixMonthCount' => 1,
  'transactionCountForPreviousDay' => 1,
  'transactionCountForPreviousYear' => 3,
  'travelDetails' => array(
    'isAirTravel' => true,
    'airlineCarrier' =>  "Wizz air",
    'departureDate' => "2014-01-26",
    'destination' => "SOF",
    'origin' => "BCN",
    'passengerFirstName' => "John",
    'passengerLastName' => "Smith"
  ),
  'userLogin' => array(
    'authenticationMethod' => "NO_LOGIN",
    'data' => "Some up to 2048 bytes undefined data",
    'time' => "2014-01-26T10:32:28Z"
  )
  ),
'browserDetails' => array(
  'acceptHeader' => "*/*",
  'colorDepthBits' => "24",
  'customerIp' => "207.48.141.20",
  'javascriptEnabled' => true,
  'javaEnabled' => true,
  'language' => "en-US",
  'screenHeight' => 768,
  'screenWidth' => 1024,
  'timezoneOffset' => 240,
  'userAgent' => "Mozilla/4.0 (compatible; Win32; WinHttp.WinHttpRequest.5)"
)
)));

		self::$authenticationId = $response->id;

	}

		public function testLookupAuthenticationsByID() {
		$this->assertNotEmpty(self::$authenticationId);

		$response = $this->getClient()->ThreeDSecureV2Service()->getAuthenticationV2(new Authentications(array(
			 'id' => self::$authenticationId
		)));

		$this->assertNotEmpty($response);
	}
	
	/**
	 * @var \Paysafe\pasyafeClient
	 */
	private $_client;

	/**
	 * 
	 * @param type $length
	 * @return string
	 */
	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	/**
	 * 
	 * @return \Paysafe\PaysafeClient
	 */
	private function getClient() {
		if (is_null($this->_client)) {
			$this->_client = new PaysafeApiClient(PAYSAFE_API_KEY, PAYSAFE_API_SECRET, Environment::TEST, PAYSAFE_ACCOUNT_NUMBER);
			}
		return $this->_client;
  }
  protected function generateSingleUseToken(){                                  
    $data= (array(              
   'card'=>array(
   "holderName"=> "MR. JOHN SMITH",
   "cardNum"=> "4917484589897107",
   "cardExpiry"=>array(
       'month'=> "12",
       'year'=> "2019"
   ),
 "billingAddress"=>array (  
     'street'=> "100 Queen Street West",
       'street2'=> "Unit 201",
       'city'=> "Toronto",
     'state'=> "ON",
     'country'=> "CA",                   
       'zip'=> "M5H 2N2"
       ))));            
   

    $method="POST";
    $uri ="/customervault/v1/singleusetokens" ;
    $body = $data;
    
 $curl = curl_init("https://api.test.netbanx.com/customervault/v1/singleusetokens");
$opts = array(
CURLOPT_URL => "https://api.test.netbanx.com/customervault/v1/singleusetokens",
CURLOPT_HTTPHEADER => array(
     'Authorization: Basic ' . base64_encode('PAYSAFE_API_KEY : PAYSAFE_API_SECRET'),
     'Content-Type: application/json; charset=utf-8'
),
CURLOPT_RETURNTRANSFER => true,
CURLOPT_SSL_VERIFYPEER => FALSE,
 CURLOPT_SSL_VERIFYPEER => FALSE,			 
);



$jsonData = json_encode($data);

$opts[CURLOPT_CUSTOMREQUEST] = $method;
$opts[CURLOPT_POSTFIELDS] = $jsonData;
$opts[CURLOPT_HTTPHEADER][] = 'Content-Length: ' . strlen($jsonData);

curl_setopt_array($curl, $opts);       


$response = curl_exec($curl);
$response=  json_decode($response);    
return ($response->paymentToken);      
  }
}
$authenticationTest = new AuthenticationTest; 
	
   $authenticationTest->testThreeDSecureV2ServiceAvailable();
   $authenticationTest->testProcessAuthentication();
   $authenticationTest->testLookupAuthenticationsByID();
   $authenticationTest->testProcessAuthenticationwithpaymentToken();

