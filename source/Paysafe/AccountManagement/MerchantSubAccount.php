<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantSubAccount
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\Link[] $links
 * @property string $id
 * @property string $name
 * @property string $status
 * @property string $eftId
 * @property string $achId
 * @property string $paymentScheduleId
 */
class MerchantSubAccount extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantEftBankAccount";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'name' => 'string',
        'status' => 'string',
        'eftId' => 'string',
        'achId' => 'string',
        'paymentScheduleId' => 'string',
    );
}
