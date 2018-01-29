<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantAccountBusinessOwnerAddress
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\Link[] $links
 * @property string $id
 * @property string $street
 * @property string $street2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $yearsAtAddress
 */
class MerchantAccountBusinessOwnerAddress extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantAccountBusinessOwnerAddress";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'businnessOwnerId' => 'string',
        'street' => 'string',
        'street2' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'zip' => 'string',
        'yearsAtAddress' => 'string',
    );
}
