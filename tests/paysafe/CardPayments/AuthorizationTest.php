<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 5/15/17
 * Time: 4:47 PM
 */

namespace Paysafe\CardPayments;


use function json_encode;
use Paysafe\PaysafeException;

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $auth = new Authorization();
        $this->assertThat($auth, $this->isInstanceOf(Authorization::class));
    }

    public function testGetPageableArrayKey()
    {
        $pak = Authorization::getPageableArrayKey();
        $this->assertThat($pak, $this->equalTo('auths'));
    }

    public function testMissingRequiredFields()
    {
        $auth = new Authorization();
        $required_fields = ['merchantRefNum', 'amount', 'card'];
        $auth->setRequiredFields($required_fields);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: ' . join(', ', $required_fields));
        $auth->checkRequiredFields();
    }

    public function testConstructWithBogusProperty()
    {
        $auth = new Authorization(['bogusproperty' => new \stdClass()]);
        // when passing a property absent from the fieldTypes array to the constructor, the bogus property should be
        // ignored
        // we expect to receive an empty JSON object
        $this->assertThat($auth->toJson(), $this->equalTo('{}'));
    }

    public function testSetBogusProperty()
    {
        $auth = new Authorization();

        // when calling the setter on a property absent from the fieldTypes array, we expect an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid property bogusproperty for class Paysafe\CardPayments\Authorization.');
        $auth->bogusproperty = new \stdClass();
    }

    public function testConstructWithValidProperty()
    {
        $auth = new Authorization(['merchantRefNum' => 'foo']);
        $this->assertThat($auth->toJson(), $this->equalTo('{"merchantRefNum":"foo"}'));
    }

    public function testConstructWithMultipleValidProperties()
    {
        $auth = new Authorization([
            'merchantRefNum' => 'foo',
            'amount' => 5
        ]);
        $this->assertThat($auth->toJson(), $this->equalTo('{"merchantRefNum":"foo","amount":5}'));
    }

    public function testConstructWithInvalidValue()
    {
        $auth_array = [
            'merchantRefNum' => new \stdClass(),
            'amount' => 5
        ];
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . 'Paysafe\CardPayments\Authorization. String expected.');
        $auth = new Authorization($auth_array);
    }

    public function testSetInvalidValue()
    {
        $auth = new Authorization();
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . 'Paysafe\CardPayments\Authorization. String expected.');
        $auth->merchantRefNum = new \stdClass();
    }

    public function testAllFieldsValidValues()
    {
        $id = 'id'; // string
        $merchantRefNum = 'merchantRefNum'; // string
        $amount = 1; // int
        $settleWithAuth = false; // bool
        $availableToSettle = 1; // int
        $childAccountNum = 'childAccountNum'; // string
        // $card should be an array acceptable to the Paysafe\CardPayments\Card constructor
        $card = [
            'cardNum' => '4111111111111111', // string
            'cvv' => '123', // string
            'cardExpiry' => [
                'month' => 6, // int
                'year' => 2020, // int
            ],
        ];
        // $authentication should be an array acceptable to the Paysafe\CardPayments\Authentication constructor
        $authentication = [
            'eci' => 1, // int
            'cavv' => 'cavv', // string
            'xid' => 'xid', // string
            'threeDEnrollment' => 'threeDEnrollment', // string
            'threeDResult' => 'threeDResult', // string
            'signatureStatus' => 'string', // string
        ];
        $authCode = 'authCode'; // string
        // $profile should be an array acceptable to the Paysafe\CardPayments\Profile constructor
        $profile = [
            'firstName' => 'firstName', // string
            'lastName' => 'lastName', // string
            'email' => 'user@host.com', // email
        ];
        // $billingDetails should be an array acceptable to the Paysafe\CardPayments\BillingDetails constructor
        $billingDetails = [
            'street' => 'street', // string
            'street2' => 'street2', // string
            'city' => 'city', // string
            'state' => 'state', // string
            'country' => 'country', // string
            'zip' => 'zip', // string
            'phone' => 'phone', // string
        ];
        // $shippingDetails should be an array acceptable to the Paysafe\CardPayments\ShippingDetails constructor
        $shippingDetails = [
            'recipientName' => 'recipientName', // string
            'street' => 'street', // string
            'street2' => 'street2', // string
            'city' => 'city', // string
            'state' => 'state', // string
            'country' => 'country', // string
            'zip' => 'zip', // string
            'phone' => 'phone', // string
            'carrier' => 'APC', // enum
            'shipMethod' => 'N', // enum
        ];
        $recurring = 'INITIAL'; // enum
        $customerIp = 'customerIp'; // string
        $dupCheck = false; // bool
        $keywords = [ 'keyword1', 'keyword2' ]; // array:string
        // $merchantDescriptor should be an array acceptable to the Paysafe\CardPayments\MerchantDescriptor constructor
        $merchantDescriptor = [
            'dynamicDescriptor' => 'dynamicDescriptor', // string
            'phone' => 'phone', // string
        ];
        // $accordD should be an array acceptable to the Paysafe\CardPayments\AccordD constructor
        $accordD = [
            'financingType' => 'DEFERRED_PAYMENT', // enum
            'plan' => 'plan', // string
            'gracePeriod' => 1, // int
            'term' => 1, // int
        ];
        $description = 'description'; // string
        // $masterPass should be an array acceptable to the Paysafe\CardPayments\MasterPass constructor
        $masterPass = [
            'payPassWalletIndicator' => 'payPassWalletIndicator', // string
            'authenticationMethod' => 'authenticationMethod', // string
            'cardEnrollementMethod' => 'cardEnrollementMethod', // string
            'masterCardAssignedId' => 'masterCardAssignedId', // string
        ];
        $txnTime = 'txnTime'; // string
        $currencyCode = 'currencyCode'; // string
        $avsResponse = 'MATCH'; // enum
        $cvvVerification = 'MATCH'; // enum
        $status = 'RECEIVED'; // enum
        $riskReasonCode = [1, 2]; // array:int
        // $acquirerResponse should be an array acceptable to the Paysafe\CardPayments\AcquirerResponse constructor
        $acquirerResponse = [
            'code' => 'code', // string
            'responseCode' => 'responseCode', // string
            'avsCode' => 'avsCode', // string
            'balanceResponse' => 'balanceResponse', // string
            'batchNumber' => 'batchNumber', // string
            'effectiveDate' => 'effectiveDate', // string
            'financingType' => 'financingType', // string
            'gracePeriod' => 'gracePeriod', // string
            'plan' => 'plan', // string
            'seqNumber' => 'seqNumber', // string
            'term' => 'term', // string
            'terminalId' => 'terminalId', // string
            'responseId' => 'responseId', // string
            'requestId' => 'requestId', // string
            'description' => 'description', // string
            'authCode' => 'authCode', // string
            'txnDateTime' => 'txnDateTime', // string
            'referenceNbr' => 'referenceNbr', // string
            'responseReasonCode' => 'responseReasonCode', // string
            'cvv2Result' => 'cvv2Result', // string
            'mid' => 'mid', // string
        ];
        // visaAdditionalAuthData should be an array acceptable to the Paysafe\CardPayments\VisaAdditionalAuthData
        // constructor
        $visaAdditionalAuthData = [
            'recipientDateOfBirth' => [ // '\Paysafe\CardPayments\DateOfBirth',
                'day' => 45, // int
                'month' => 15, // int
                'year' => -1000 // int
            ],
            'recipientZip' => 'recipientZip',
            'recipientLastName' => 'recipientLastName',
            'recipientAccountNumber' => 'recipientAccountNumber'
        ];
        // settlements should be an array of arrays that are acceptable to the Paysafe\CardPayments\Settlement
        // constructor
        $settlements = [
            [
                'id' => 'id1', // string
                'merchantRefNum' => 'merchantRefNum1', // string
                'amount' => 1, // int
                'availableToRefund' => 1, // int
                'childAccountNum' => 'childAccountNum1', // string
                'txnTime' => 'txnTime1', // string
                'dupCheck' => false, // bool
                'status' => 'RECEIVED', // enum
                'riskReasonCode' => [0,1], //  'array:int',
                'acquirerResponse' => [ // '\Paysafe\CardPayments\AcquirerResponse',
                    'code' => 'code', // string
                    'responseCode' => 'responseCode', // string
                    'avsCode' => 'avsCode', // string
                    'balanceResponse' => 'balanceResponse', // string
                    'batchNumber' => 'batchNumber', // string
                    'effectiveDate' => 'effectiveDate', // string
                    'financingType' => 'financingType', // string
                    'gracePeriod' => 'gracePeriod', // string
                    'plan' => 'plan', // string
                    'seqNumber' => 'seqNumber', // string
                    'term' => 'term', // string
                    'terminalId' => 'terminalId', // string
                    'responseId' => 'responseId', // string
                    'requestId' => 'requestId', // string
                    'description' => 'description', // string
                    'authCode' => 'authCode', // string
                    'txnDateTime' => 'txnDateTime', // string
                    'referenceNbr' => 'referenceNbr', // string
                    'responseReasonCode' => 'responseReasonCode', // string
                    'cvv2Result' => 'cvv2Result', // string
                    'mid' => 'mid', // string
                ],
                'error' => [ // '\Paysafe\Error',
                    'code' => 'code',// 'string',
                    'message' => 'message', // 'string',
                    'details' => ['details1','details2'], // 'array:string',
                    'fieldErrors' => [[  // 'array:\Paysafe\FieldError',
                        'field' => 'field', // string
                        'error' => 'error', // string
                    ]],
                    'links' => [[ // 'array:\Paysafe\Link'
                        'rel' => 'rel', // 'string',
                        'href' => 'gopher://foo.bar', // 'url'
                    ]],
                ],
                'links' => [[ // 'array:\Paysafe\Link',
                    'rel' => 'rel', // 'string',
                    'href' => 'gopher://foo.bar', // 'url'
                ]],
                'authorizationID' => 'authorizationID', // string
            ],
            [
                'id' => 'id2', // string
                'merchantRefNum' => 'merchantRefNum2', // string
                'amount' => 2, // int
                'availableToRefund' => 2, // int
                'childAccountNum' => 'childAccountNum2', // string
                'txnTime' => 'txnTime2', // string
                'dupCheck' => false, // bool
                'status' => 'RECEIVED', // enum
                'riskReasonCode' => [2,3], //  'array:int',
                'acquirerResponse' => [ // '\Paysafe\CardPayments\AcquirerResponse',
                    'code' => 'code', // string
                    'responseCode' => 'responseCode', // string
                    'avsCode' => 'avsCode', // string
                    'balanceResponse' => 'balanceResponse', // string
                    'batchNumber' => 'batchNumber', // string
                    'effectiveDate' => 'effectiveDate', // string
                    'financingType' => 'financingType', // string
                    'gracePeriod' => 'gracePeriod', // string
                    'plan' => 'plan', // string
                    'seqNumber' => 'seqNumber', // string
                    'term' => 'term', // string
                    'terminalId' => 'terminalId', // string
                    'responseId' => 'responseId', // string
                    'requestId' => 'requestId', // string
                    'description' => 'description', // string
                    'authCode' => 'authCode', // string
                    'txnDateTime' => 'txnDateTime', // string
                    'referenceNbr' => 'referenceNbr', // string
                    'responseReasonCode' => 'responseReasonCode', // string
                    'cvv2Result' => 'cvv2Result', // string
                    'mid' => 'mid', // string
                ],
                'error' => [ // '\Paysafe\Error',
                    'code' => 'code',// 'string',
                    'message' => 'message', // 'string',
                    'details' => ['details1','details2'], // 'array:string',
                    'fieldErrors' => [[  // 'array:\Paysafe\FieldError',
                        'field' => 'field', // string
                        'error' => 'error', // string
                    ]],
                    'links' => [[ // 'array:\Paysafe\Link'
                        'rel' => 'rel', // 'string',
                        'href' => 'gopher://foo.bar', // 'url'
                    ]],
                ],
                'links' => [[ // 'array:\Paysafe\Link',
                    'rel' => 'rel', // 'string',
                    'href' => 'gopher://foo.bar', // 'url'
                ]],
                'authorizationID' => 'authorizationID2', // string
            ],
        ];
        $error = [ // '\Paysafe\Error',
            'code' => 'code',// 'string',
            'message' => 'message', // 'string',
            'details' => ['details1','details2'], // 'array:string',
            'fieldErrors' => [[  // 'array:\Paysafe\FieldError',
                'field' => 'field', // string
                'error' => 'error', // string
            ]],
            'links' => [[ // 'array:\Paysafe\Link'
                'rel' => 'rel', // 'string',
                'href' => 'gopher://foo.ba', // 'url'
            ]],
        ];
        $links = [[ // 'array:\Paysafe\Link',
            'rel' => 'rel', // 'string',
            'href' => 'gopher://foo.ba', // 'url'
        ]];

        $auth_array = [
            'id' => $id,
            'merchantRefNum' => $merchantRefNum,
            'amount' => $amount,
            'settleWithAuth' => $settleWithAuth,
            'availableToSettle' => $availableToSettle,
            'childAccountNum' => $childAccountNum,
            'card' => $card,
            'authentication' => $authentication,
            'authCode' => $authCode,
            'profile' => $profile,
            'billingDetails' => $billingDetails,
            'shippingDetails' => $shippingDetails,
            'recurring' => $recurring,
            'customerIp' => $customerIp,
            'dupCheck' => $dupCheck,
            'keywords' => $keywords,
            'merchantDescriptor' => $merchantDescriptor,
            'accordD' => $accordD,
            'description' => $description,
            'masterPass' => $masterPass,
            'txnTime' => $txnTime,
            'currencyCode' => $currencyCode,
            'avsResponse' => $avsResponse,
            'cvvVerification' => $cvvVerification,
            'status' => $status,
            'riskReasonCode' => $riskReasonCode,
            'acquirerResponse' => $acquirerResponse,
            'visaAdditionalAuthData' => $visaAdditionalAuthData,
            'settlements' => $settlements,
            'error' => $error,
            'links' => $links,
            'splitpay' => [[
                'linkedAccount' => 'link_account_id',
                'amount' => 500,
            ]],
            'storedCredential' => [
                'type' => 'RECURRING',
                'occurrence' => 'SUBSEQUENT'
            ]
        ];
        $auth = new Authorization($auth_array);

        /*
         * This may seem like a trivial test, but behind the scenes toJson triggers data validation. Bad data will
         * result in an exception.
         * Not only does this test ensure the proper operation of the json encoding in JSONObject, but it validates
         * our understanding of the data requirements in Authorization
         */
        $this->assertThat($auth->toJson(), $this->equalTo(json_encode($auth_array)));
    }

    public function testConstructEmptySplitPay()
    {
        $auth = new Authorization([
            'splitpay' => [[]],
        ]);

        $this->assertThat($auth->toJson(), $this->equalTo('{"splitpay":[{}]}'));
    }

    public function testSetEmptySplitPay()
    {
        $auth = new Authorization();

        $auth->splitpay = [[]];

        $this->assertThat($auth->toJson(), $this->equalTo('{"splitpay":[{}]}'));
    }

    public function testConstructBadSplitPay()
    {
        $bad_sp_array = ['linkedAccount' => new \stdClass()];

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property linkedAccount for class Paysafe\CardPayments\SplitPay.'
            . ' String expected.');
        $auth = new Authorization([
            'splitpay' => [$bad_sp_array],
        ]);
    }

    public function testConstructSingleSPObjInsteadOfArray()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property splitpay for class Paysafe\CardPayments\Authorization.'
            . ' Array expected.');

        $auth = new Authorization([
            'splitpay' => new SplitPay(),
        ]);
    }

    public function testConstructGoodSP()
    {
        $auth = new Authorization([
            'splitpay' => [[
                'linkedAccount' => 'link_account_id',
                'amount' => 500,
            ]]
        ]);

        $this->assertThat($auth->toJson(), $this->equalTo('{"splitpay":[{"linkedAccount":"link_account_id","amount":500}]}'));
    }

    public function testSetGoodSP()
    {
        $auth = new Authorization();
        $auth->splitpay = [[
            'linkedAccount' => 'link_account_id',
            'amount' => 500,
        ]];

        $this->assertThat($auth->toJson(), $this->equalTo('{"splitpay":[{"linkedAccount":"link_account_id","amount":500}]}'));
    }

    public function testSetSingleSPObjInsteadOfArray()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property splitpay for class Paysafe\CardPayments\Authorization.'
            . ' Array expected.');

        $auth = new Authorization();
        $auth->splitpay = new SplitPay();
    }
}
