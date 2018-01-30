<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantAccountAddress
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\Link[] $links
 * @property string $id
 * @property string $street
 * @property string $street2
 * @property string $city
 * @property string $state
 * @property string $country
 */
class MerchantAccountAddress extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantAccoantAddress";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'street' => 'string',
        'street2' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'zip' => 'string'
    );
}
