<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 8/29/17
 * Time: 3:21 PM
 */

namespace Paysafe;

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
}
