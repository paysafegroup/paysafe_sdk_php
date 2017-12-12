<?php
/*
 * TODO insert appropriate copyright notice
 */

namespace Paysafe\DirectDebit;

/**
 * @property string $linkedAccount
 * @property number $percent
 * @property integer $amount
 */
class SplitPay extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'linkedAccount' => 'string',
        'percent' => 'float',
        'amount' => 'int',
    );
}
