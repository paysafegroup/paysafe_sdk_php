<?php

namespace Paysafe\AccountManagement;

/**
 * Class IssueDate
 * @package Paysafe\AccountManagement
 *
 * @property string $day
 * @property string $month
 * @property string $year
 */
class IssueDate extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'day' => 'string',
        'month' => 'string',
        'year' => 'string'
    );
}
