<?php

namespace Paysafe\AccountManagement;

use Paysafe\PaysafeException;

/**
 * Class Transfer
 * @package Paysafe\AccountManagement
 *
 * @property string $id
 * @property int $amount
 * @property string $detail
 * @property bool $dupCheck
 * @property string $linkedAccount
 * @property string $merchantRefNum
 * @property \Paysafe\Error $error
 * @property string $status
 * @property \Paysafe\Link[] $links
 */
class Transfer extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "transfers";
    }

    protected static $fieldTypes = array(
        'id' => 'string',
        'amount' => 'int',
        'detail' => 'string',
        'dupCheck' => 'bool',
        'linkedAccount' => 'string',
        'merchantRefNum' => 'string',
        'error' => '\Paysafe\Error',
        'status' => array(
            'RECEIVED',
            'PENDING',
            'PROCESSING',
            'COMPLETED',
            'FAILED',
            'CANCELLED'
        ),
        'links' => 'array:\Paysafe\Link'
    );

    /**
     *
     * @param string $linkName
     * @return \Paysafe\Link
     * @throws PaysafeException
     */
    public function getLink( $linkName ) {
        if (!empty($this->links)) {
            foreach ($this->links as $link) {
                if ($link->rel == $linkName) {
                    return $link;
                }
            }
        }
        throw new PaysafeException("Link $linkName not found in Transfer.");
    }
}
