<?php
/**
 * Created by PhpStorm.
 * User: bjohnson
 * Date: 8/30/17
 * Time: 4:38 PM
 */

namespace Paysafe\AccountManagement;


use function json_encode;
use Paysafe\JSONObject;
use Paysafe\Link;
use Paysafe\Pageable;
use Paysafe\PaysafeException;

class TransferTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $t = new Transfer();
        $this->assertThat($t, $this->isInstanceOf(Transfer::class));
        $this->assertThat($t, $this->isInstanceOf(JSONObject::class));
        $this->assertThat($t, $this->isInstanceOf(Pageable::class));
    }

    public function testGetPageableArrayKey()
    {
        $this->assertThat(Transfer::getPageableArrayKey(), $this->equalTo('transfers'));
    }

    public function testGetLink()
    {
        $foo_rel = 'foo';
        $foo_href = 'http://foo.bar/bax';

        $t = new Transfer([
            'links' => [
                ['rel' => $foo_rel, 'href' => $foo_href]
            ]
        ]);

        $thelink = $t->getLink($foo_rel);
        $this->assertThat($thelink, $this->isInstanceOf(Link::class));
        $this->assertThat($thelink->rel, $this->equalTo($foo_rel));
        $this->assertThat($thelink->href, $this->equalTo($foo_href));
    }

    public function testGetLinkUnknownLink()
    {
        $bad_rel = 'something_else';
        $foo_rel = 'foo';
        $foo_href = 'http://foo.bar/bax';

        $t = new Transfer([
            'links' => [
                ['rel' => $foo_rel, 'href' => $foo_href]
            ]
        ]);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionMessage('Link '. $bad_rel . ' not found in Transfer.');
        $this->expectExceptionCode(0);
        $t->getLink($bad_rel);
    }

    public function testGetLinkNoLinks()
    {
        $bad_rel = 'something_else';

        $t = new Transfer();

        $this->expectException(PaysafeException::class);
        $this->expectExceptionMessage('Link '. $bad_rel . ' not found in Transfer.');
        $this->expectExceptionCode(0);
        $t->getLink($bad_rel);
    }

    public function testMissingRequiredFields()
    {
        $t = new Transfer();
        $required_fields = ['amount', 'linkedAccount', 'merchantRefNum'];
        $t->setRequiredFields($required_fields);

        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Missing required properties: ' . join(', ', $required_fields));
        $t->checkRequiredFields();
    }

    public function testConstructWithBogusProperty()
    {
        $t = new Transfer(['bogusproperty' => new \stdClass()]);
        // when passing a property absent from the fieldTypes array to the constructor, the bogus property should be
        // ignored
        // we expect to receive an empty JSON object
        $this->assertThat($t->toJson(), $this->equalTo('{}'));
    }

    public function testSetBogusProperty()
    {
        $t = new Transfer();

        // when calling the setter on a property absent from the fieldTypes array, we expect an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid property bogusproperty for class Paysafe\AccountManagement\Transfer.');
        $t->bogusproperty = new \stdClass();
    }

    public function testConstructWithValidProperty()
    {
        $t = new Transfer(['merchantRefNum' => 'foo']);
        $this->assertThat($t->toJson(), $this->equalTo('{"merchantRefNum":"foo"}'));
    }

    public function testConstructWithMultipleValidProperties()
    {
        $t = new Transfer([
            'merchantRefNum' => 'foo',
            'amount' => 5
        ]);
        $this->assertThat($t->toJson(), $this->equalTo('{"merchantRefNum":"foo","amount":5}'));
    }

    public function testConstructWithInvalidValue()
    {
        $t_array = [
            'merchantRefNum' => new \stdClass(),
            'amount' => 5
        ];
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . 'Paysafe\AccountManagement\Transfer. String expected.');
        new Transfer($t_array);
    }

    public function testSetInvalidValue()
    {
        $t = new Transfer();
        // merchantRefNum should be a string; object should throw an exception
        $this->expectException(PaysafeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Invalid value for property merchantRefNum for class '
            . 'Paysafe\AccountManagement\Transfer. String expected.');
        $t->merchantRefNum = new \stdClass();
    }

    public function testAllFieldsValidValues()
    {
        $id = 'id'; // string
        $amount = 1; // int
        $detail = 'detail'; //string
        $dupCheck = true; // bool
        $linkedAccount = 'linkedAccount'; // string
        $merchantRefNum = 'merchantRefNum'; // string
        $error = [ // \Paysafe\Error
            'code' => 'code', // string
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
        ];
        $status = 'RECEIVED'; // enum
        $links = [[ // 'array:\Paysafe\Link'
            'rel' => 'rel', // 'string',
            'href' => 'gopher://foo.bar', // 'url'
        ]];

        $t_array = [
            'id' => $id,
            'amount' => $amount,
            'detail' => $detail,
            'dupCheck' => $dupCheck,
            'linkedAccount' => $linkedAccount,
            'merchantRefNum' => $merchantRefNum,
            'error' => $error,
            'status' => $status,
            'links' => $links,
        ];

        $t = new Transfer($t_array);

        /*
         * This may seem like a trivial test, but behind the scenes toJson triggers data validation. Bad data will
         * result in an exception.
         * Not only does this test ensure the proper operation of the json encoding in JSONObject, but it validates
         * our understanding of the data requirements in Transfer
         */
        $this->assertThat($t->toJson(), $this->equalTo(json_encode($t_array)));
    }
}
