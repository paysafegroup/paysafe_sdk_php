<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantDescriptor
 * @package Paysafe\AccountManagement
 *
 * @property string $dynamicDescriptor
 * @property string $phone
 */
class MerchantDescriptor extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'dynamicDescriptor' => 'string',
        'phone' => 'string',
    );
}
