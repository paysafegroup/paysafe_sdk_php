<?php

namespace Paysafe\AccountManagement;

/**
 * Class ExpiryDate
 * @package Paysafe\AccountManagement
 *
 * @property string $day
 * @property string $month
 * @property string $year
 */
class ExpiryDate extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'day' => 'string',
        'month' => 'string',
        'year' => 'string'
    );
}
