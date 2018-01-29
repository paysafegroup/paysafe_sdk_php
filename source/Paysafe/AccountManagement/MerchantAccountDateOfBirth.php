<?php

namespace Paysafe\AccountManagement;

/**
 * Class MerchantAccountDateOfBirth
 * @package Paysafe\AccountManagement
 *
 * @property string $day
 * @property string $month
 * @property string $year
 */
class MerchantAccountDateOfBirth extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'day' => 'string',
        'month' => 'string',
        'year' => 'string'
    );
}
