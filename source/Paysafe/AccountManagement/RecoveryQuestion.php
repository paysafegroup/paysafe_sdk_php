<?php

namespace Paysafe\AccountManagement;

/**
 * Class RecoveryQuestion
 * @package Paysafe\AccountManagement
 *
 * @property integer $questionId
 * @property string $question
 * @property string $answer
 */
class RecoveryQuestion extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'questionId' => 'int',
        'question' => 'string',
        'answer' => 'string',
    );
}
