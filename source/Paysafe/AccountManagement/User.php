<?php

namespace Paysafe\AccountManagement;

/**
 * Class User
 * @package Paysafe\AccountManagement
 *
 * @property string $userName
 * @property string $password
 * @property string $email
 * @property \Paysafe\AccountManagement\RecoveryQuestion $recoveryQuestion
 * @property \Paysafe\Link[] $links
 */
class User extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey() {
        return "user";
    }

    protected static $fieldTypes = array(
        'userName' => 'string',
        'password' => 'string',
        'email' => 'email',
        'recoveryQuestion' => '\Paysafe\AccountManagement\RecoveryQuestion',
        'links' => 'array:\Paysafe\Link'
    );
}
