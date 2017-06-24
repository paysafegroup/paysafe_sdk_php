<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 5/22/17
 * Time: 3:43 PM
 */

namespace Paysafe\DirectDebit;


use Paysafe\PaysafeException;

class SplitPayTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $splitpay = new SplitPay();
        $this->assertThat($splitpay, $this->isInstanceOf(SplitPay::class));
    }

    public function testMissingRequiredFields()
    {
        $splitpay = new SplitPay();
        $required_fields = ['linkedAccount', 'percent', 'amount'];
        $splitpay->setRequiredFields($required_fields);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: ' . join(', ', $required_fields));

        $splitpay->checkRequiredFields();
    }

    public function testConstructWithBogusProperty()
    {
        $splitpay = new SplitPay(['bogusproperty' => new \stdClass()]);
        // when passing a property absent from the fieldTypes array to the constructor, the bogus property should be
        // ignored
        // we expect to receive an empty JSON object
        $this->assertThat($splitpay->toJson(), $this->equalTo('{}'));
    }

    public function testSetBogusProperty()
    {
        $splitpay = new SplitPay();
        $bogusproperty_name = 'bogusproperty';

        // when calling the setter on a property absent from the fieldTypes array, we expect an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid property '. $bogusproperty_name . ' for class ' . SplitPay::class . '.');
        $splitpay->$bogusproperty_name = new \stdClass();
    }

    public function testConstructWithValidProperty()
    {
        $splitpay = new SplitPay(['linkedAccount' => 'linked_account_id']);
        $this->assertThat($splitpay->toJson(), $this->equalTo('{"linkedAccount":"linked_account_id"}'));
    }

    public function testConstructWithMultipleValidProperties()
    {
        $splitpay = new SplitPay([
            'linkedAccount' => 'linked_account_id',
            'amount' => 500,
        ]);

        $this->assertThat($splitpay->toJson(), $this->equalTo('{"linkedAccount":"linked_account_id","amount":500}'));
    }

    public function testConstructWithInvalidLinkedAccount()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property linkedAccount for class '
            . 'Paysafe\DirectDebit\SplitPay. String expected.');

        // linkedAccount should be a string; an object should throw an exception
        $splitpay = new SplitPay([
            'linkedAccount' => new \stdClass(),
        ]);
    }

    public function testConstructWithInvalidAmount()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property amount for class '
            . 'Paysafe\DirectDebit\SplitPay. Integer expected.');

        // amount should be an int; an object should throw an exception
        $splitpay = new SplitPay([
            'amount' => new \stdClass(),
        ]);
    }

    public function testConstructWithInvalidPercent()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property percent for class '
            . 'Paysafe\DirectDebit\SplitPay. Float expected.');

        // percent should be an int; an object should throw an exception
        $splitpay = new SplitPay([
            'percent' => new \stdClass(),
        ]);
    }

    public function testConstructWithMultipleInvalids()
    {
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property linkedAccount for class '
            . 'Paysafe\DirectDebit\SplitPay. String expected.');

        // this will fail on the first invalid item; so the exception will only mention linkedAccount
        $sp_array = [
            'linkedAccount' => new \stdClass(),
            'amount' => 'this_is_not_numeric',
            'percent' => 'neither_is_this',
        ];

        new SplitPay($sp_array);
    }

    public function testConstructPercentNoDecimal()
    {
        $sp = new SplitPay(['percent' => 5]);
        $this->assertThat($sp->toJson(), $this->equalTo('{"percent":5}'));
    }

    public function testConstructAllValid()
    {
        $linked_account = 'linked_account';
        $amount = 5;
        $percent = 3.2;
        $sp = new SplitPay([
            'linkedAccount' => $linked_account,
            'amount' => $amount,
            'percent' => $percent,
        ]);

        $this->assertThat($sp->toJson(), $this->equalTo('{"linkedAccount":"linked_account","amount":5,"percent":3.2}'));
    }
}
