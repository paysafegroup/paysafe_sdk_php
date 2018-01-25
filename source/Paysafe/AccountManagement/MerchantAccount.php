<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantAccount
 * @package Paysafe\AccountManagement
 *
 * @property string $name
 * @property string $currency
 * @property string $region
 * @property string $legalEntity
 * @property string $productCode
 */
class MerchantAccount extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantAccoant";
    }

    protected static $fieldTypes = array(
        'id' => 'string',
        'merchantId' => 'string',
        'name' => 'string',
        'currency' => 'string',
        'region' => 'string',
        'legalEntity' => 'string',
        'productCode' => 'string'
    );
}
