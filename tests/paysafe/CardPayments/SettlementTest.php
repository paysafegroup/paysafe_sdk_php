<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 5/23/17
 * Time: 9:52 AM
 */

namespace Paysafe\CardPayments;

use Paysafe\PaysafeException;

class SettlementTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $settlement = new Settlement();
        $this->assertThat($settlement, $this->isInstanceOf(Settlement::class));
    }

    public function testGetPageableArrayKey()
    {
        $pak = Settlement::getPageableArrayKey();
        $this->assertThat($pak, $this->equalTo('settlements'));
    }

    public function testMissingRequiredFields()
    {
        $settlement = new Settlement();
        $required_fields = ['merchantRefNum', 'amount'];
        $settlement->setRequiredFields($required_fields);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: ' . join(', ', $required_fields));
        $settlement->checkRequiredFields();
    }

    public function testConstructWithBogusProperty()
    {
        $settlement = new Settlement(['bogusproperty' => new \stdClass()]);
        // when passing a property absent from the fieldTypes array to the constructor, the bogus property should be
        // ignored
        // we expect to receive an empty JSON object
        $this->assertThat($settlement->toJson(), $this->equalTo('{}'));
    }

    public function testSetBogusProperty()
    {
        $settlement = new Settlement();

        // when calling the setter on a property absent from the fieldTypes array, we expect an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid property bogusproperty for class Paysafe\CardPayments\Settlement.');
        $settlement->bogusproperty = new \stdClass();
    }

    public function testConstructWithValidProperty()
    {
        $settlement = new Settlement(['merchantRefNum' => 'foo']);
        $this->assertThat($settlement->toJson(), $this->equalTo('{"merchantRefNum":"foo"}'));
    }

    public function testConstructWithMultipleValidProperties()
    {
        $settlement = new Settlement([
            'merchantRefNum' => 'foo',
            'amount' => 5
        ]);
        $this->assertThat($settlement->toJson(), $this->equalTo('{"merchantRefNum":"foo","amount":5}'));
    }

    public function testConstructWithInvalidValue()
    {
        $param_array = [
            'merchantRefNum' => new \stdClass(),
            'amount' => 5
        ];
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . 'Paysafe\CardPayments\Settlement. String expected.');
        $settlement = new Settlement($param_array);
    }

    public function testSetInvalidValue()
    {
        $settlement = new Settlement();
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . 'Paysafe\CardPayments\Settlement. String expected.');
        $settlement->merchantRefNum = new \stdClass();
    }

    public function testAllFieldsValidValues()
    {
        $param_array = [
            'id' => 'id', // string
            'merchantRefNum' => 'merchantRefNum', // string
            'amount' => 5, // int
            'availableToRefund' => 5, // int
            'childAccountNum' => 'childAccountNum', // string
            'txnTime' => 'txnTime', // string
            'dupCheck' => false, // bool
            'status' => 'PENDING', // enum
            'riskReasonCode' => [0,1], // array:int
            'acquirerResponse' => [ // \Paysafe\CardPayments\AcquirerResponse
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
            'error' => [ // \Paysafe\Error
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
                ]]
            ],
            'links' => [[ // array:\Paysafe\Link
                'rel' => 'rel', // 'string',
                'href' => 'gopher://foo.bar', // 'url'
            ]],
            'authorizationID' => 'authorizationID', // string
            'splitpay' => [[ // array:\Paysafe\CardPayments\SplitPay
                'linkedAccount' => 'link_account_id',
                'amount' => 500,
            ]],
        ];

        $settlement = new Settlement($param_array);
        /*
         * This may seem like a trivial test, but behind the scenes toJson triggers data validation. Bad data will
         * result in an exception.
         * Not only does this test ensure the proper operation of the json encoding in JSONObject, but it validates
         * our understanding of the data requirements in Settlement
         */
        $this->assertThat($settlement->toJson(), $this->equalTo(json_encode($param_array)));
    }

    public function testConstructEmptySplitPay()
    {
        $settlement = new Settlement([
            'splitpay' => [[]],
        ]);

        $this->assertThat($settlement->toJson(), $this->equalTo('{"splitpay":[{}]}'));
    }

    public function testSetEmptySplitPay()
    {
        $settlement = new Settlement();

        $settlement->splitpay = [[]];

        $this->assertThat($settlement->toJson(), $this->equalTo('{"splitpay":[{}]}'));
    }

    public function testConstructBadSplitPay()
    {
        $bad_sp_array = ['linkedAccount' => new \stdClass()];

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property linkedAccount for class Paysafe\CardPayments\SplitPay.'
            . ' String expected.');
        new Settlement([
            'splitpay' => [$bad_sp_array],
        ]);
    }

    public function testConstructSingleSPObjInsteadOfArray()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property splitpay for class Paysafe\CardPayments\Settlement.'
            . ' Array expected.');

        new Settlement([
            'splitpay' => new SplitPay(),
        ]);
    }

    public function testConstructGoodSP()
    {
        $settlement = new Settlement([
            'splitpay' => [[
                'linkedAccount' => 'link_account_id',
                'amount' => 500,
            ]]
        ]);

        $this->assertThat($settlement->toJson(),
            $this->equalTo('{"splitpay":[{"linkedAccount":"link_account_id","amount":500}]}'));
    }

    public function testSetGoodSP()
    {
        $settlement = new Settlement();
        $settlement->splitpay = [[
            'linkedAccount' => 'link_account_id',
            'amount' => 500,
        ]];

        $this->assertThat($settlement->toJson(),
            $this->equalTo('{"splitpay":[{"linkedAccount":"link_account_id","amount":500}]}'));
    }

    public function testSetSingleSPObjInsteadOfArray()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property splitpay for class Paysafe\CardPayments\Settlement.'
            . ' Array expected.');

        $settlement = new Settlement();
        $settlement->splitpay = new SplitPay();
    }
}
