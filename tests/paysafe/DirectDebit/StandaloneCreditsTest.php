<?php
/**
 * Created by PhpStorm.
 * Date: 12/12/17
 * Time: 9:10 AM
 */

namespace Paysafe\DirectDebit;

use Paysafe\Link;
use Paysafe\PaysafeException;

class StandaloneCreditsTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $sac = new StandaloneCredits();
        $this->assertThat($sac, $this->isInstanceOf(StandaloneCredits::class));
    }

    public function testGetPageableArrayKey()
    {
        $pak = StandaloneCredits::getPageableArrayKey();
        $this->assertThat($pak, $this->equalTo('standaloneCredits'));
    }

    public function testGetLinkEmpty()
    {
        $bad_link_name = 'foo';
        $this->expectException(PaysafeException::class);
        $this->expectExceptionMessage("Link $bad_link_name not found in stand alone credit");
        $this->expectExceptionCode(0);

        $sac = new StandaloneCredits();
        $sac->getLink($bad_link_name);
    }

    public function testGetLink()
    {
        $link_name = 'bar';
        $link_value = 'gopher://foo.ba';
        $links = [['rel' => $link_name, 'href' => $link_value]];
        $sac = new StandaloneCredits(['links' => $links]);

        $returned_link = $sac->getLink($link_name);
        $this->assertThat($returned_link, $this->isInstanceOf(Link::class));
        $this->assertThat($returned_link->href, $this->equalTo($link_value));
        $this->assertThat($returned_link->rel, $this->equalTo($link_name));
    }

    public function testMissingRequiredFields()
    {
        $sac = new StandaloneCredits();
        $required_fields = ['id', 'merchantRefNum'];
        $sac->setRequiredFields($required_fields);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: ' . join(', ', $required_fields));

        $sac->checkRequiredFields();
    }

    public function testConstructWithBogusProperty()
    {
        $sac = new StandaloneCredits(['bogusproperty' => new \stdClass()]);
        // when passing a property absent from the fieldTypes array to the constructor, the bogus property should be
        // ignored
        // we expect to receive an empty JSON object
        $this->assertThat($sac->toJson(), $this->equalTo('{}'));
    }

    public function testSetBogusProperty()
    {
        $sac = new StandaloneCredits();

        // when calling the setter on a property absent from the fieldTypes array, we expect an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid property bogusproperty for class ' . StandaloneCredits::class . '.');
        $sac->bogusproperty = new \stdClass();
    }

    public function testConstructWithValidProperty()
    {
        $sac = new StandaloneCredits(['merchantRefNum' => 'foo']);
        $this->assertThat($sac->toJson(), $this->equalTo('{"merchantRefNum":"foo"}'));
    }

    public function testConstructWithMultipleValidProperties()
    {
        $sac = new StandaloneCredits([
            'merchantRefNum' => 'foo',
            'amount' => 5,
        ]);
        $this->assertThat($sac->toJson(), $this->equalTo('{"merchantRefNum":"foo","amount":5}'));
    }

    public function testConstructWithInvalidValue()
    {
        $sac_array = [
            'merchantRefNum' => new \stdClass(),
            'amount' => 5
        ];
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . StandaloneCredits::class . '. String expected.');
        $sac = new StandaloneCredits($sac_array);
    }

    public function testSetInvalidValue()
    {
        $sac = new StandaloneCredits();
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . StandaloneCredits::class . '. String expected.');
        $sac->merchantRefNum = new \stdClass();
    }

    public function testAllFieldsValueValues()
    {
        $id = 'id'; // string
        $merchantRefNum = 'merchantRefNum'; // string
        $amount = 1; // int
        // $ach should be an array acceptable to the Paysafe\DirectDebit\ACH constructor
        $ach = [
            'paymentToken' => 'paymentToken', // string
            'payMethod' => 'WEB', // string - enum
            'paymentDescriptor' => 'paymentDescriptor', // string
            'accountHolderName' => 'accountHolderName', // string
            'accountType' => 'SAVINGS', // string - enum
            'accountNumber' => 'accountNumber', // string
            'routingNumber' => 'routingNumber', // string
            'lastDigits' => 'lastDigits', // string
        ];
        // $eft should be an array acceptable to the Paysafe\DirectDebit\EFT constructor
        $eft = [
            'paymentToken' => 'paymentToken', // string
            'paymentDescriptor' => 'paymentDescriptor', // string
            'accountHolderName' => 'accountHolderName', // string
            'accountNumber' => 'accountNumber', // string
            'transitNumber' => 'transitNumber', // string
            'institutionId' => 'institutionId', // string
            'lastDigits' => 'lastDigits', // string
        ];
        // $bacs should be an array acceptable to the Paysafe\DirectDebit\BACS constructor
        $bacs = [
            'paymentToken' => 'paymentToken', // string
            'accountHolderName' => 'accountHolderName', // string
            'sortCode' => 'sortCode', // string
            'accountNumber' => 'accountNumber', // string
            'mandateReference' => 'mandateReference', // string
            'lastDigits' => 'lastDigits', // string
        ];
        // $profile should be an array acceptable to the Paysafe\DirectDebit\Profile constructor
        $profile = [
            'firstName' => 'firstName', // string
            'lastName' => 'lastName', // string
            'email' => 'email', // string
            'ssn' => 'ssn', // string
            'dateOfBirth' => [
                'day' => 1, // int
                'month' => 2, // int
                'year' => 3, // int
            ]
        ];
        // $filter should be an array acceptable to the Paysafe\DirectDebit\Filter constructor
        $filter = [
            'limit' => 1, // int
            'offset' => 2, // int
            'startDate' => 'startDate', // string
            'endDate' => 'endDate', // string
        ];
        // $billingDetails should be an array acceptable to the Paysafe\DirectDebit\BillingDetails constructor
        $billingDetails = [
            'street' => 'street', // string
            'street2' => 'street2', // string
            'city' => 'city', // string
            'state' => 'state', // string
            'country' => 'country', // string
            'zip' => 'zip', // string
            'phone' => 'phone', // string
        ];
        // $shippingDetails should be an array acceptable to the Paysafe\DirectDebit\ShippingDetails constructor
        $shippingDetails = [
            'carrier' => 'APC', // string - enum
            'shipMethod' => 'N', // string - enum
            'recipientName' => 'string', // string
            'street' => 'street', // string
            'street2' => 'street2', // string
            'city' => 'city', // string
            'state' => 'state', // string
            'country' => 'country', // string
            'zip' => 'zip', // string
        ];
        $customerIp = 'customerIp'; // string
        $dupCheck = true; // bool
        $txnTime = 'txnTime'; // string
        $currencyCode = 'currencyCode'; // string
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
        $status = 'RECEIVED'; // string - enum
        $links = [[ // 'array:\Paysafe\Link',
            'rel' => 'rel', // 'string',
            'href' => 'gopher://foo.ba', // 'url'
        ]];
        // array:\Paysafe\DirectDebit\SplitPay
        $splitpay = [
            [
                'linkedAccount' => 'link_account_id_1',
                'amount' => 500,
            ],
            [
                'linkedAccount' => 'link_account_id_2',
                'amount' => 600,
            ],
        ];

        $sac_array = [
            'id' => $id,
            'merchantRefNum' => $merchantRefNum,
            'amount' => $amount,
            'ach' => $ach,
            'eft' => $eft,
            'bacs' => $bacs,
            'profile' => $profile,
            'filter' => $filter,
            'billingDetails' => $billingDetails,
            'shippingDetails' => $shippingDetails,
            'customerIp' => $customerIp,
            'dupCheck' => $dupCheck,
            'txnTime' => $txnTime,
            'currencyCode' => $currencyCode,
            'error' => $error,
            'status' => $status,
            'links' => $links,
            'splitpay' => $splitpay,
        ];

        $sac = new StandaloneCredits($sac_array);
        /*
         * This may seem like a trivial test, but behind the scenes toJson triggers data validation. Bad data will
         * result in an exception.
         * Not only does this test ensure the proper operation of the json encoding in JSONObject, but it validates
         * our understanding of the data requirements in StandAloneCredits
         */
        $this->assertThat($sac->toJson(), $this->equalTo(json_encode($sac_array)));
    }

    public function testConstructEmptySplitPay()
    {
        $sac = new StandaloneCredits([
            'splitpay' => [[]],
        ]);

        $this->assertThat($sac->toJson(), $this->equalTo('{"splitpay":[{}]}'));
    }

    public function testSetEmptySplitPay()
    {
        $sac = new StandaloneCredits();
        $sac->splitpay = [[]];

        $this->assertThat($sac->toJson(), $this->equalTo('{"splitpay":[{}]}'));
    }

    public function testConstructBadSplitPay()
    {
        $bad_sp_array = ['linkedAccount' => new \stdClass()];

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property linkedAccount for class ' . SplitPay::class . '.'
            . ' String expected.');
        $sac = new StandaloneCredits([
            'splitpay' => [$bad_sp_array],
        ]);
    }

    public function testConstructSingleSPObjInsteadOfArray()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property splitpay for class ' . StandaloneCredits::class
            . '. Array expected.');

        $sac = new StandaloneCredits([
            'splitpay' => new SplitPay(),
        ]);
    }

    public function testConstructGoodSP()
    {
        $sac = new StandaloneCredits([
            'splitpay' => [[
                'linkedAccount' => 'link_account_id',
                'amount' => 500,
            ]]
        ]);

        $this->assertThat($sac->toJson(),
            $this->equalTo('{"splitpay":[{"linkedAccount":"link_account_id","amount":500}]}'));
    }

    public function testSetGoodSP()
    {
        $sac = new StandaloneCredits();
        $sac->splitpay = [[
            'linkedAccount' => 'link_account_id',
            'amount' => 500,
        ]];

        $this->assertThat($sac->toJson(),
            $this->equalTo('{"splitpay":[{"linkedAccount":"link_account_id","amount":500}]}'));
    }

    public function testSetSingleSPObjInsteadOfArray()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property splitpay for class ' . StandaloneCredits::class
            . '. Array expected.');

        $sac = new StandaloneCredits();
        $sac->splitpay = new SplitPay();
    }
}
