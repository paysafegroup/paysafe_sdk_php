<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 11/28/17
 * Time: 10:30 AM
 */

namespace Paysafe\CardPayments;


use Paysafe\PaysafeException;

class RefundTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $refund = new Refund();
        $this->assertThat($refund, $this->isInstanceOf(Refund::class));
    }

    public function testGetPageableArrayKey()
    {
        $pak = Refund::getPageableArrayKey();
        $this->assertThat($pak, $this->equalTo('refunds'));
    }

    public function testMissingRequiredFields()
    {
        $refund = new Refund();
        $required_fields = ['settlementID', 'merchantRefNum'];
        $refund->setRequiredFields($required_fields);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: ' . join(', ', $required_fields));

        $refund->checkRequiredFields();
    }

    public function testConstructWithBogusProperty()
    {
        $refund = new Refund(['bogusproperty' => new \stdClass()]);
        // when passing a property absent from the fieldTypes array to the constructor, the bogus property should be
        // ignored
        // we expect to receive an empty JSON object
        $this->assertThat($refund->toJson(), $this->equalTo('{}'));
    }

    public function testConstructWithValidProperty()
    {
        $refund = new Refund(['merchantRefNum' => 'foo']);
        $this->assertThat($refund->toJson(), $this->equalTo('{"merchantRefNum":"foo"}'));
    }

    public function testConstructWithMultipleValidProperties()
    {
        $refund = new Refund([
            'merchantRefNum' => 'foo',
            'amount' => 5,
        ]);
        $this->assertThat($refund->toJson(), $this->equalTo('{"merchantRefNum":"foo","amount":5}'));
    }

    public function testConstructWithInvalidValue()
    {
        $refund_array = [
            'merchantRefNum' => new \stdClass(),
            'amount' => 5
        ];
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . Refund::class . '. String expected.');
        $refund = new Refund($refund_array);
    }

    public function testSetInvalidValue()
    {
        $refund = new Refund();
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . Refund::class . '. String expected.');
        $refund->merchantRefNum = new \stdClass();
    }

    public function testAllFieldsValueValues()
    {
        $id = 'id'; // string
        $merchantRefNum = 'merchantRefNum'; // string
        $amount = 1; // int
        $childAccountNum = 'childAccountNum'; // string
        $dupCheck = true; // bool
        $txnTime = 'txnTime'; // string
        $status = 'status'; // string
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
        $settlementID = 'settlementID'; // string

        $refund_array = [
            'id' => $id,
            'merchantRefNum' => $merchantRefNum,
            'amount' => $amount,
            'childAccountNum' => $childAccountNum,
            'dupCheck' => $dupCheck,
            'txnTime' => $txnTime,
            'status' => $status,
            'riskReasonCode' => $riskReasonCode,
            'acquirerResponse' => $acquirerResponse,
            'error' => $error,
            'links' => $links,
            'settlementID' => $settlementID,
        ];

        $refund = new Refund($refund_array);
        /*
         * This may seem like a trivial test, but behind the scenes toJson triggers data validation. Bad data will
         * result in an exception.
         * Not only does this test ensure the proper operation of the json encoding in JSONObject, but it validates
         * our understanding of the data requirements in Authorization
         */
        $this->assertThat($refund->toJson(), $this->equalTo(json_encode($refund_array)));
    }
}
