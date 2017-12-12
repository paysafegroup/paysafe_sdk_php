<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 11/28/17
 * Time: 1:52 PM
 */

namespace Paysafe;

use Paysafe\CardPayments\Refund;

/**
 * Class CardPaymentServiceRefundTest
 * This class provides coverage of the CardPaymentService::refund function
 * @package Paysafe
 */
class CardPaymentServiceRefundTest extends \PHPUnit_Framework_TestCase
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
     * This is a test to confirm that the CardPaymentService sets and checks the required settlementID field as
     * expected.
     *
     * When settlementID is missing, an exception is thrown before any call to the api client
     */
    public function testRefundMissingRequiredSettlementId()
    {
        $cps = new CardPaymentService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: settlementID');

        $cps->refund(new Refund());
    }

    /*
     * In this test we submit a valid value for settlementID so that we can get past that check and actually call
     * processRequest. We make our mock call toJson to trigger the validation that would normally happen in the real
     * client's processRequest. toJson should throw an exception since not all required params were passed.
     */
    public function testRefundMissingRequiredMerchantRefNum()
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

        $cps->refund(new Refund(['settlementID' => 'settlementID']));
    }

    /*
     * This is a test to confirm that the CardPaymentService sets expected values for required/optional fields. If a
     * parameter is set in the Refund obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     */
    public function testRefundInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $refund_param_array = [
            'settlementID' => 'settlementID',
            'merchantRefNum' => 'merchantRefNum',
            'id' => 'id is a valid param, but not in required or optional list',
        ];

        $retval = $cps->refund(new Refund($refund_param_array));
        $expected_params = $refund_param_array;
        unset($expected_params['id']); // remove item not in required/optional list
        // we also remove settlementID; refund() puts this value in URL and removes from body
        unset($expected_params['settlementID']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($expected_params)));
    }

    /*
     * This test builds upon the information we learned in testRefundInvalidField. This time, we will include
     * splitpay in the param list, and we will assert that it is still present in the Refund object returned
     * by CardPaymentService::refund -- thus confirming that refund included splitpay in the optional field list
     */
    public function testRefundWithSplitPay()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $cps = new CardPaymentService($this->mock_api_client);

        $refund_param_array = [
            'settlementID' => 'settlementID',
            'merchantRefNum' => 'merchantRefNum',
            'splitpay' => [[
                'linkedAccount' => 'linkedAccount',
                'amount' => 5,
            ]],
        ];

        $retval = $cps->refund(new Refund($refund_param_array));
        $expected_params = $refund_param_array;
        // we remove settlementID; refund() puts this value in URL and removes from body
        unset($expected_params['settlementID']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($expected_params)));
    }
}
