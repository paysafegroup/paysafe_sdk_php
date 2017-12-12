<?php
/**
 * TODO appropriate copyright notice
 */

namespace Paysafe;

/*
 * This class provides incomplete coverage of DirectDebitService. I'm only writing today to test splitypay for ACH/EFT
 * TODO complete coverage
 */

use function json_decode;
use function json_encode;
use Paysafe\DirectDebit\Purchase;
use PHPUnit_Framework_Error;

class DirectDebitServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject $mock_api_client */
    private $mock_api_client;

    public function setUp()
    {
        parent::setUp();

        $this->mock_api_client = $this->createMock(PaysafeApiClient::class);
        $this->mock_api_client->method('getAccount')->willReturn('bogus_account_num');
    }

    /**
     * This is a bad test as it simply confirms current undesirable behavior. If no type is specified in the Purchase
     * object (ach, eft, etc), then a PHP Error is generated. Ideally, the code would gracefully handle this situation.
     * See: https://github.com/paysafegroup/paysafe_sdk_php/issues/13
     */
    public function testSubmitNoTypeSpecified()
    {
        $this->expectException(PHPUnit_Framework_Error::class);
        $this->expectExceptionMessage('Undefined variable: return');
        /*
         * When https://github.com/paysafegroup/paysafe_sdk_php/issues/13 is resolved, we would likely replace the
         * previous two expectations with something like:
         * $this->expectException(PaysafeException::class);
         * $this->expectExceptionCode(500);
         * $this->expectExceptionMessage('Some appropriate message about there not being a type specified');
         */

        $dds = new DirectDebitService($this->mock_api_client);
        $empty_purchase = new Purchase();
        $dds->submit($empty_purchase);
    }

    /*
     * This is a test to confirm that the DirectDebitService sets the required parameters we expect for a Submit call.
     * If no token is specified, the service first checks that required Profile parameters were included.
     */
    public function testSubmitAchMissingProfileRequiredFields()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: firstName, lastName');

        $dds = new DirectDebitService($this->mock_api_client);
        /*
         * Note: we have to at least specify an empty ach or there will be a PHP Error.
         * See https://github.com/paysafegroup/paysafe_sdk_php/issues/13
         */
        $ach_purchase_array = [ 'ach' => [] ];
        $dds->submit(new Purchase($ach_purchase_array));
    }

    /*
     * This is a test to confirm that the DirectDebitService sets the required parameters we expect for a Submit call.
     * If a token is specified we expect to validate merchantRefNum, amount, and ach
     */
    public function testSubmitAchMissingRequiredFieldsWithToken()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: merchantRefNum, amount');

        $dds = new DirectDebitService($this->mock_api_client);
        $ach_purchase_array = [
            'ach' => [
                'paymentToken' => 'bogus_payment_token',
            ]
        ];
        $dds->submit(new Purchase($ach_purchase_array));
    }

    /*
     * This is a test to confirm that the DirectDebitService sets the required parameters we expect for a Submit call.
     * If no token is specified, but required Profile params are, we expect to validate merchantRefNum, amount, and ach
     */
    public function testSubmitAchMissingRequiredFieldsNoToken()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: merchantRefNum, amount, billingDetails');

        $dds = new DirectDebitService($this->mock_api_client);
        /*
         * Note: we have to at least specify an empty ach or there will be a PHP Error.
         * See https://github.com/paysafegroup/paysafe_sdk_php/issues/13
         */
        $ach_purchase_array = [
            'ach' => [ ],
            'profile' => [
                'firstName' => 'firstname',
                'lastName' => 'lastname',
            ],
        ];
        $dds->submit(new Purchase($ach_purchase_array));
    }

    /*
     * This is a test to confirm that the DirectDebitService sets expected values for required/optional fields. If a
     * parameter is set in the Purchase obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     *
     * This test omits the token and instead includes profile information. The required/optional lists are built
     * slightly differently in each case
     */
    public function testSubmitAchNoTokenInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $ach_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'ach' => [
                'accountType' => 'CHECKING',
            ],
            'profile' => [
                'firstName' => 'firstname',
                'lastName' => 'lastname',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
            'billingDetails' => [
                'zip' => '10007',
            ],
        ];

        $retval = $dds->submit(new Purchase($ach_purchase_array));
        $param_no_id = $ach_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }

    /*
     * This is a test to confirm that the DirectDebitService sets expected values for required/optional fields. If a
     * parameter is set in the Purchase obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     *
     * This test includes the token and omits profile information. The required/optional lists are built
     * slightly differently in each case
     */
    public function testSubmitAchWithTokenInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $ach_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'ach' => [
                'paymentToken' => 'myspecialtoken',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
        ];

        $retval = $dds->submit(new Purchase($ach_purchase_array));
        $param_no_id = $ach_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }

    /*
     * This test builds upon the information we learned in testSubmitAchNoTokenInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Purchase object returned
     * by DirectDebitService::submit -- thus confirming that submitPurchaseACH included splitpay in the optional field
     * list
     */
    public function testSubmitAchNoTokenWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $ach_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'ach' => [
                'accountType' => 'CHECKING',
            ],
            'profile' => [
                'firstName' => 'firstname',
                'lastName' => 'lastname',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
            'billingDetails' => [
                'zip' => '10007',
            ],
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
        ];

        $retval = $dds->submit(new Purchase($ach_purchase_array));
        $param_no_id = $ach_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }

    /*
     * This test builds upon the information we learned in testSubmitAchWithTokenInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Purchase object returned
     * by DirectDebitService::submit -- thus confirming that submitPurchaseACH included splitpay in the optional field
     * list
     */
    public function testSubmitAchWithTokenWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $ach_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'ach' => [
                'paymentToken' => 'myspecialtoken',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
        ];

        $retval = $dds->submit(new Purchase($ach_purchase_array));
        $param_no_id = $ach_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }
    /*
     * This is a test to confirm that the DirectDebitService sets the required parameters we expect for a Submit call.
     * If no token is specified, the service first checks that required Profile parameters were included.
     */
    public function testSubmitEftMissingProfileRequiredFields()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: firstName, lastName');

        $dds = new DirectDebitService($this->mock_api_client);
        /*
         * Note: we have to at least specify an empty eft or there will be a PHP Error.
         * See https://github.com/paysafegroup/paysafe_sdk_php/issues/13
         */
        $eft_purchase_array = [ 'eft' => [] ];
        $dds->submit(new Purchase($eft_purchase_array));
    }

    /*
     * This is a test to confirm that the DirectDebitService sets the required parameters we expect for a Submit call.
     * If a token is specified we expect to validate merchantRefNum, amount, and eft
     */
    public function testSubmitEftMissingRequiredFieldsWithToken()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: merchantRefNum, amount');

        $dds = new DirectDebitService($this->mock_api_client);
        $eft_purchase_array = [
            'eft' => [
                'paymentToken' => 'bogus_payment_token',
            ]
        ];
        $dds->submit(new Purchase($eft_purchase_array));
    }

    /*
     * This is a test to confirm that the DirectDebitService sets the required parameters we expect for a Submit call.
     * If no token is specified, but required Profile params are, we expect to validate merchantRefNum, amount, and eft
     */
    public function testSubmitEftMissingRequiredFieldsNoToken()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: merchantRefNum, amount, billingDetails');

        $dds = new DirectDebitService($this->mock_api_client);
        /*
         * Note: we have to at least specify an empty eft or there will be a PHP Error.
         * See https://github.com/paysafegroup/paysafe_sdk_php/issues/13
         */
        $eft_purchase_array = [
            'eft' => [ ],
            'profile' => [
                'firstName' => 'firstname',
                'lastName' => 'lastname',
            ],
        ];
        $dds->submit(new Purchase($eft_purchase_array));
    }

    /*
     * This is a test to confirm that the DirectDebitService sets expected values for required/optional fields. If a
     * parameter is set in the Purchase obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     *
     * This test omits the token and instead includes profile information. The required/optional lists are built
     * slightly differently in each case
     */
    public function testSubmitEftNoTokenInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $eft_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'eft' => [
                'accountHolderName' => 'John',
            ],
            'profile' => [
                'firstName' => 'firstname',
                'lastName' => 'lastname',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
            'billingDetails' => [
                'zip' => '10007',
            ],
        ];

        $retval = $dds->submit(new Purchase($eft_purchase_array));
        $param_no_id = $eft_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }

    /*
     * This is a test to confirm that the DirectDebitService sets expected values for required/optional fields. If a
     * parameter is set in the Purchase obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     *
     * This test includes the token and omits profile information. The required/optional lists are built
     * slightly differently in each case
     */
    public function testSubmitEftWithTokenInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $eft_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'eft' => [
                'paymentToken' => 'myspecialtoken',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
        ];

        $retval = $dds->submit(new Purchase($eft_purchase_array));
        $param_no_id = $eft_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }

    /*
     * This test builds upon the information we learned in testSubmitEftNoTokenInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Purchase object returned
     * by DirectDebitService::submit -- thus confirming that submitPurchaseEFT included splitpay in the optional field
     * list
     */
    public function testSubmitEftNoTokenWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $eft_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'eft' => [
                'accountHolderName' => 'John',
            ],
            'profile' => [
                'firstName' => 'firstname',
                'lastName' => 'lastname',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
            'billingDetails' => [
                'zip' => '10007',
            ],
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
        ];

        $retval = $dds->submit(new Purchase($eft_purchase_array));
        $param_no_id = $eft_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }

    /*
     * This test builds upon the information we learned in testSubmitEftWithTokenInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Purchase object returned
     * by DirectDebitService::submit -- thus confirming that submitPurchaseEFT included splitpay in the optional field
     * list
     */
    public function testSubmitEftWithTokenWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $dds = new DirectDebitService($this->mock_api_client);

        $eft_purchase_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'eft' => [
                'paymentToken' => 'myspecialtoken',
            ],
            'merchantRefNum' => 'merchantrefnum',
            'amount' => '555',
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
        ];

        $retval = $dds->submit(new Purchase($eft_purchase_array));
        $param_no_id = $eft_purchase_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)),
            'Did not receive expected return from DirectDebitService::submit');
    }
}
