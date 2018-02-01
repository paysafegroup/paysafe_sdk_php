<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantEftBankAccount
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\Link[] $links
 * @property string $id
 * @property string $accountNumber
 * @property string $transitNumber
 * @property string $institutionId
 * @property string $merchantId
 */
class MerchantEftBankAccount extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantEftBankAccount";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'accountNumber' => 'string',
        'transitNumber' => 'string',
        'institutionId' => 'string',
        'merchantId' => 'string'
    );
}
