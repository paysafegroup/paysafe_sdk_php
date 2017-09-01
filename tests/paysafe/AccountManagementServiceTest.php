<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 8/29/17
 * Time: 3:21 PM
 */

namespace Paysafe;
use function json_encode;
use Paysafe\AccountManagement\Transfer;

/**
 * Class AccountManagementServiceTest
 * @package Paysafe
 */
class AccountManagementServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject $mock_api_client */
    private $mock_api_client;

    public function setUp()
    {
        parent::setUp();

        $this->mock_api_client = $this->createMock(PaysafeApiClient::class);
        $this->mock_api_client->method('getAccount')->willReturn('bogus_account_num');
    }

    public function testMonitor()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn(['status' => 'READY']); // the expected return for success

        $ams = new AccountManagementService($this->mock_api_client);
        $this->assertThat($ams->monitor(), $this->isTrue(), 'monitor did not return true as expected');
    }

    public function testMonitorNoStatus()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn([]); // what happens if we get an empty array?

        $ams = new AccountManagementService($this->mock_api_client);
        // we *expect* false because anything other than status:READY is a fail
        $this->assertThat($ams->monitor(), $this->isFalse(), 'monitor did not return false as expected');
    }

    public function testMonitorStatusNotReady()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn(['status' => 'some string other than READY']);

        $ams = new AccountManagementService($this->mock_api_client);
        // we *expect* false because anything other than status:READY is a fail
        $this->assertThat($ams->monitor(), $this->isFalse(), 'monitor did not return false as expected');
    }

    public function testMonitorException()
    {
        $exception_msg = 'this is an expected test exception';
        $exception_code = 123;
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->willThrowException(new PaysafeException($exception_msg, $exception_code));

        // processRequest may throw an exception; monitor is expected to let that bubble up
        $this->expectException(PaysafeException::class);
        $this->expectExceptionMessage('this is an expected test exception');
        $this->expectExceptionCode($exception_code);

        $ams = new AccountManagementService($this->mock_api_client);
        $ams->monitor();
    }

    /*
     * This is a test to confirm that the AcccountManagementService sets the required parameters we expect for a
     * transferDebit call. A real API client, among other things, would call toJson on the Transfer object behind the
     * scenes. If required params are missing, it will throw an exception specifying the problem fields.
     */
    public function testTransferDebitMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $ams = new AccountManagementService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: amount, linkedAccount, merchantRefNum');

        $ams->transferDebit(new Transfer());
    }

    /*
     * This is a test to confirm that the AcccountManagementService sets expected values for required/optional fields.
     * If a parameter is set in the Transfer obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     */
    public function testTransferDebitInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $ams = new AccountManagementService($this->mock_api_client);

        $transfer_param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'amount' => 100,
            'linkedAccount' => '123',
            'merchantRefNum' => 'abc',
        ];

        $retval = $ams->transferDebit(new Transfer($transfer_param_array));
        $param_no_id = $transfer_param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));

    }

    /*
     * This is a test to confirm that the AcccountManagementService sets the required parameters we expect for a
     * transferDebit call. A real API client, among other things, would call toJson on the Transfer object behind the
     * scenes. If required params are missing, it will throw an exception specifying the problem fields.
     */
    public function testTransferCreditMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $ams = new AccountManagementService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: amount, linkedAccount, merchantRefNum');

        $ams->transferCredit(new Transfer());
    }

    /*
     * This is a test to confirm that the AcccountManagementService sets expected values for required/optional fields.
     * If a parameter is set in the Transfer obj, but not in the required or optional lists, it will be omitted from the
     * JSON created by toJson. (toJson is called by processRequest in the api client).
     *
     * So, we'll make our mock api client call toJson, and confirm the output lacks the field that doesn't appear in
     * required/optional.
     */
    public function testTransferCreditInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $ams = new AccountManagementService($this->mock_api_client);

        $transfer_param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'amount' => 100,
            'linkedAccount' => '123',
            'merchantRefNum' => 'abc',
        ];

        $retval = $ams->transferCredit(new Transfer($transfer_param_array));
        $param_no_id = $transfer_param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));

    }
}
