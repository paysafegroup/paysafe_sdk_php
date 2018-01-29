<?php

namespace Paysafe\AccountManagement;

/**
 * Class RecoveryQuestionsList
 * @package Paysafe\AccountManagement
 *
 * @property \Paysafe\AccountManagement\RecoveryQuestion[] $question
 * @property \Paysafe\Link[] $links
 */
class RecoveryQuestionsList extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
        'questions' => 'array:\Paysafe\AccountManagement\RecoveryQuestion',
        'links' => 'array:\Paysafe\Link'
    );
}
