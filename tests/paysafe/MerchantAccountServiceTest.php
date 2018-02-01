<?php

namespace Paysafe;
use function json_encode;
use Paysafe\AccountManagement\MerchantAccount;
use Paysafe\AccountManagement\MerchantAccountAddress;
use Paysafe\AccountManagement\MerchantAccountBusinessOwner;
use Paysafe\AccountManagement\MerchantAccountBusinessOwnerAddress;
use Paysafe\AccountManagement\MerchantAccountBusinessOwnerIdentityDocument;
use Paysafe\AccountManagement\MerchantEftBankAccount;
use Paysafe\AccountManagement\MerchantSubAccount;
use Paysafe\AccountManagement\TermsAndConditions;
use Paysafe\AccountManagement\Transfer;
use Paysafe\AccountManagement\User;

/**
 * Class MerchantAccountServiceTest
 * @package Paysafe
 */
class MerchantAccountServiceTest extends \PHPUnit_Framework_TestCase
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

        $mas = new MerchantAccountService($this->mock_api_client);
        $this->assertThat($mas->monitor(), $this->isTrue(), 'monitor did not return true as expected');
    }

    public function testMonitorNoStatus()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn([]); // what happens if we get an empty array?

        $mas = new MerchantAccountService($this->mock_api_client);
        // we *expect* false because anything other than status:READY is a fail
        $this->assertThat($mas->monitor(), $this->isFalse(), 'monitor did not return false as expected');
    }

    public function testMonitorStatusNotReady()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn(['status' => 'some string other than READY']);

        $mas = new MerchantAccountService($this->mock_api_client);
        // we *expect* false because anything other than status:READY is a fail
        $this->assertThat($mas->monitor(), $this->isFalse(), 'monitor did not return false as expected');
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

        $mas = new MerchantAccountService($this->mock_api_client);
        $mas->monitor();
    }

    public function testCreateMerchantAccountMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: name, currency, region, legalEntity, productCode, category, phone, yearlyVolumeRange, averageTransactionAmount, merchantDescriptor, caAccountDetails');

        $mas->createMerchantAccount(new MerchantAccount());
    }

    public function testCreateMerchantAccountInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'name' => '123',
            'currency' => 'abc',
            'region' => 'abc',
            'legalEntity' => 'abc',
            'productCode' => 'abc',
            'category' => 'abc',
            'phone' => 'abc',
            'yearlyVolumeRange' => 'abc',
            'averageTransactionAmount' => 1234,
            'merchantDescriptor' => array(
                'dynamicDescriptor' => 'string',
                'phone' => 'string',
            ),
            'caAccountDetails' => [
                'type' => 'abc',
                'description' => 'abc',
                'isCardPresent' => true,
                'hasPreviouslyProcessedCards' => true,
                'shipsGoods' => true,
                'deliveryTimeRange' => 'abc',
                'refundPolicy' => true,
                'refundPolicyDescription' => 'abc',
                'federalTaxNumber' => 'abc',
                'additionalPaymentMethods' => ['abc']
            ],
        ];

        $retval = $mas->createMerchantAccount(new MerchantAccount($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));

    }

    public function testCreateNewUserMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: userName, password, email, recoveryQuestion');

        $mas->createNewUser(new User());
    }

    public function testCreateNewUserInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'userName' => 'string',
            'password' => 'string',
            'email' => 'email@gmail.com',
            'recoveryQuestion' => [
                'questionId' => 1,
                'question' => 'string',
                'answer' => 'string',
            ]
        ];

        $retval = $mas->createNewUser(new User($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testCreateMerchantAccountAddressMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: street, city, state, country, zip');

        $mas->createMerchantAccountAddress(new MerchantAccountAddress());
    }

    public function testCreateMerchantAccountAddressInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'street' => 'string',
            'street2' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'zip' => 'string'
        ];

        $retval = $mas->createMerchantAccountAddress(new MerchantAccountAddress($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testCreateMerchantAccountBusinessOwnerMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: firstName, lastName, jobTitle, phone, dateOfBirth, dateOfBirth');

        $mas->createMerchantAccountBusinessOwner(new MerchantAccountBusinessOwner());
    }

    public function testCreateMerchantAccountBusinessOwnerInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'firstName' => 'string',
            'middleName' => 'string',
            'lastName' => 'string',
            'email' => 'string',
            'jobTitle' => 'string',
            'phone' => 'string',
            'dateOfBirth'=> [
                'day' => 'string',
                'month' => 'string',
                'year' => 'string'
            ],
            'ssn' => 'string'
        ];

        $retval = $mas->createMerchantAccountBusinessOwner(new MerchantAccountBusinessOwner($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testCreateMerchantAccountBusinessOwnerAddressMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: businnessOwnerId, street, city, state, country, zip, yearsAtAddress');

        $mas->createMerchantAccountBusinessOwnerAddress(new MerchantAccountBusinessOwnerAddress());
    }

    public function testCreateMerchantAccountBusinessOwnerAddressInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'businnessOwnerId' => 'string',
            'street' => 'string',
            'street2' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'zip' => 'string',
            'yearsAtAddress' => 'string'
        ];

        $retval = $mas->createMerchantAccountBusinessOwnerAddress(new MerchantAccountBusinessOwnerAddress($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testCreateMerchantAccountBusinessOwnerAddressPreviousMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: businnessOwnerId, street, city, state, country, zip, yearsAtAddress');

        $mas->createMerchantAccountBusinessOwnerAddressPrevious(new MerchantAccountBusinessOwnerAddress());
    }

    public function testCreateMerchantAccountBusinessOwnerAddressPreviousInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'businnessOwnerId' => 'string',
            'street' => 'string',
            'street2' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'zip' => 'string',
            'yearsAtAddress' => 'string'
        ];

        $retval = $mas->createMerchantAccountBusinessOwnerAddressPrevious(new MerchantAccountBusinessOwnerAddress($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testAddBusinessOwnerIdentityDocumentMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: businnessOwnerId, number, province');

        $mas->addBusinessOwnerIdentityDocument(new MerchantAccountBusinessOwnerIdentityDocument());
    }

    public function testaddBusinessOwnerIdentityDocumentInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'businnessOwnerId' => 'string',
            'number' => 'string',
            'province' => 'string'
        ];

        $retval = $mas->addBusinessOwnerIdentityDocument(new MerchantAccountBusinessOwnerIdentityDocument($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testAddMerchantEftBankAccountMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: accountNumber, transitNumber, institutionId');

        $mas->addMerchantEftBankAccount(new MerchantEftBankAccount());
    }

    public function testAddMerchantEftBankAccountInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'accountNumber' => 'string',
            'transitNumber' => 'string',
            'institutionId' => 'string',
        ];

        $retval = $mas->addMerchantEftBankAccount(new MerchantEftBankAccount($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testAcceptTermsAndConditionsMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: version');

        $mas->acceptTermsAndConditions(new TermsAndConditions());
    }

    public function testAcceptTermsAndConditionsInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'version' => 'string'
        ];

        $retval = $mas->acceptTermsAndConditions(new TermsAndConditions($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }

    public function testCreateMerchantSubAccountMissingRequiredFields()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return $param->body->toJson();
            }));

        $mas = new MerchantAccountService($this->mock_api_client);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: name');

        $mas->createMerchantSubAccount(new MerchantSubAccount());
    }

    public function testCreateMerchantSubAccountInvalidField()
    {
        $this->mock_api_client
            ->expects($this->once())
            ->method('processRequest')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnCallback(function (Request $param) {
                return json_decode($param->body->toJson(), true);
            }));
        $mas = new MerchantAccountService($this->mock_api_client);

        $param_array = [
            'id' => 'id is a valid param, but not in required or optional list',
            'name' => 'string',
            'eftId' => 'string',
        ];

        $retval = $mas->createMerchantSubAccount(new MerchantSubAccount($param_array));
        $param_no_id = $param_array;
        unset($param_no_id['id']);
        $this->assertThat($retval->toJson(), $this->equalTo(json_encode($param_no_id)));
    }
}
