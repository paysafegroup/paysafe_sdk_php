<?php

namespace Paysafe\AccountManagement;

/**
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\Link[] $links
 * @property string $id
 * @property string $accountNumber
 * @property string $routingNumber
 * @property string $merchantId
 */
class MerchantAchBankAccount extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantAchBankAccount";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'accountNumber' => 'string',
        'routingNumber' => 'string',
        'merchantId' => 'string'
    );
}
