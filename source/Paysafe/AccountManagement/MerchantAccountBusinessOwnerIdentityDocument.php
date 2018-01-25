<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantAccountBusinessOwnerIdentityDocument
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\Link[] $links
 * @property string $id
 * @property string $number
 * @property string $province
 * @property \Paysafe\AccountManagement\ExpiryDate $issueDate
 * @property \Paysafe\AccountManagement\IssueDate $expiryDate
 */
class MerchantAccountBusinessOwnerIdentityDocument extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "merchantAccountBusinessOwnerIdentityDocument";
    }

    protected static $fieldTypes = array(
        'links' => 'array:\Paysafe\Link',
        'id' => 'string',
        'businnessOwnerId' => 'string',
        'number' => 'string',
        'province' => 'string',
        'issueDate' => '\Paysafe\AccountManagement\ExpiryDate',
        'expiryDate' => '\Paysafe\AccountManagement\IssueDate',
    );
}
