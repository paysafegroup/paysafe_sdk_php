<?php

namespace Paysafe\AccountManagement;

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
     * @param type $linkName
     * @return \Paysafe\HostedPayment\Link
     * @throws PaysafeException
     */
    public function getLink( $linkName ) {
        if (!empty($this->link)) {
            foreach ($this->link as $link) {
                if ($link->rel == $linkName) {
                    return $link;
                }
            }
        }
        throw new PaysafeException("Link $linkName not found in purchase.");
    }
}