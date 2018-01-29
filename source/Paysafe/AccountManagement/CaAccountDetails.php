<?php

namespace Paysafe\AccountManagement;

/**
 * Class CaAccountDetails
 * @package Paysafe\AccountManagement
 *
 * @property string $type
 * @property string $description
 */
class CaAccountDetails extends \Paysafe\JSONObject {

    protected static $fieldTypes = array(
        'type' => 'string',
        'description' => 'string',
        'isCardPresent' => 'bool',
        'hasPreviouslyProcessedCards' => 'bool',
        'shipsGoods' => 'bool',
        'deliveryTimeRange' => 'string',
        'refundPolicy' => 'bool',
        'refundPolicyDescription' => 'string',
        'federalTaxNumber' => 'string',
        'additionalPaymentMethods' => 'array:string'
    );
}
