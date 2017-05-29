<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 5/26/17
 * Time: 5:03 PM
 */

namespace Paysafe;

/*
 * This class provides incomplete coverage of the CardPaymentService; I'm writing today just to test splitpay
 * TODO complete coverage
 */
use function json_encode;
use Paysafe\CardPayments\Authorization;
use Paysafe\CardPayments\Settlement;

class CardPaymentServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject $mock_api_client */
    private $mock_api_client;

    public function setUp()
    {
        parent::setUp();

        $this->mock_api_client = $this->createMock(PaysafeApiClient::class);
        $this->mock_api_client->method('getAccount')->willReturn('bogus_account_num');
    }

    /*
     * This is a test to confirm that the CardPaymentService sets the required parameters we expect for an
     * authorize call. A real API client, among other things, would call toJson on the Authorization object behind the
     * scenes. If required params are missing, it will throw an exception specifying the problem fields.
     */
    public function testAuthorizeMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $cps = new CardPaymentService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: merchantRefNum, amount, card');

        $cps->authorize(new Authorization());
    }

    /*
     * This is a test to confirm that the CardPaymentService sets expected values for required/optional fields. If a
     * parameter is set in the Authorize obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     */
    public function testAuthorizeInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $auth_param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'card' => [
                'cardNum' => '4111111111111111',
                'cvv' => '123',
                'cardExpiry' => [
                    'month' => 6,
                    'year' => 2020,
                ],
            ],
            'merchantRefNum' => 'merchantRefNum',
            'amount' => 555,
        ];

        $retval = $cps->authorize(new Authorization($auth_param_array));
        $param_no_id = $auth_param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    /*
     * This test builds upon the information we learned in testAuthorizeInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Authorize object returned
     * by CardPaymentService::authorize -- thus confirming that authorize included splitpay in the optional field list     *
     */
    public function testAuthorizeWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $auth_param_array = [
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
            'card' => [
                'cardNum' => '4111111111111111',
                'cvv' => '123',
                'cardExpiry' => [
                    'month' => 6,
                    'year' => 2020,
                ],
            ],
            'merchantRefNum' => 'merchantRefNum',
            'amount' => 555,
        ];

        $retval = $cps->authorize(new Authorization($auth_param_array));
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($auth_param_array)));
    }

    /*
     * This is a test to confirm that the CardPaymentService sets and checks the required authorizationID parameter as
     * we expect for a settlement call.
     *
     * When the authorizationID param is missing, an exception is thrown before any call to the api client
     */
    public function testSettlementMissingRequiredAuthorizationId()
    {
        $cps = new CardPaymentService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: authorizationID');

        $cps->settlement(new Settlement());
    }

    /*
     * In this test we submit a valid value for authorizationID so that we can get past that check and actually call
     * processRequest. As in testAuthorizeMissingRequiredFields we make our mock call toJson to trigger the validation
     * that would normally happen in the real client's processRequest. toJson should throw an exception since not all
     * required params were passed.
     */
    public function testSettlementMissingRequiredMerchantRefNum()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: merchantRefNum');

        $cps->settlement(new Settlement(['authorizationID' => 'authorizationID']));
    }

    /*
     * This is a test to confirm that the CardPaymentService sets expected values for required/optional fields. If a
     * parameter is set in the Settlement obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     */
    public function testSettlementInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $settlement_param_array = [
            'authorizationID' => 'authorizationID',
            'merchantRefNum' => 'merchantRefNum',
            'id' => 'id is a valid param, but not in required or optional list',
        ];

        $retval = $cps->settlement(new Settlement($settlement_param_array));
        $expected_params = $settlement_param_array;
        unset($expected_params['id']); // remove item not in required/optional list
        // we also remove authorizationID; settlement() puts this value in URL and removes from body
        unset($expected_params['authorizationID']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($expected_params)));
    }

    /*
     * This test builds upon the information we learned in testSettlementInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Settlement object returned
     * by CardPaymentService::settlement -- thus confirming that settlement included splitpay in the optional field list
     */
    public function testSettlementWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $settlement_param_array = [
            'authorizationID' => 'authorizationID',
            'merchantRefNum' => 'merchantRefNum',
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
        ];

        $retval = $cps->settlement(new Settlement($settlement_param_array));
        $expected_params = $settlement_param_array;
        // we also remove authorizationID; settlement() puts this value in URL and removes from body
        unset($expected_params['authorizationID']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($expected_params)));
    }
}
