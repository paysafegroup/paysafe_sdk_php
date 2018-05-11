<?php

namespace Paysafe\AccountManagement;

/**
 * Class Merchant
 * @package Paysafe\AccountManagement
 *
 * @property string $id
 * @property string $name
 * @property \Paysafe\Link[] $links
 */
class Merchant extends \Paysafe\JSONObject implements \Paysafe\Pageable {

    public static function getPageableArrayKey()
    {
        return 'merchant';
    }

    protected static $fieldTypes = array(
        'id' => 'string',
        'name' => 'string',
        'links' => 'array:\Paysafe\Link'
    );
}
