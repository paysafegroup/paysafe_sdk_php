<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantAccountBusinessOwner
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
class MerchantAccountBusinessOwner extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantAccountBusinessOwner";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'firstName' => 'string',
        'middleName' => 'string',
        'lastName' => 'string',
        'email' => 'string',
        'jobTitle' => 'string',
        'phone' => 'string',
        'dateOfBirth'=>'\Paysafe\AccountManagement\MerchantAccountDateOfBirth',
        'ssn' => 'string',
    );
}
