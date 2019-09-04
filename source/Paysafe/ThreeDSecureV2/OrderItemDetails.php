<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $preOrderItemAvailabilityDate
 * @property string $preOrderPurchaseIndicator
 * @property string $reorderItemsIndicator
 * @property string $shippingIndicator
 */
class OrderItemDetails  extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
     'preOrderItemAvailabilityDate' => 'string',
     'preOrderPurchaseIndicator' => array(
       'MERCHANDISE_AVAILABLE',
       'FUTURE_AVAILABILITY'  
     ),
     'reorderItemsIndicator' => array(
         'FIRST_TIME_ORDER',
         'REORDER'
     ),
      'shippingIndicator' => array(
          'SHIP_TO_BILLING_ADDRESS',
          'SHIP_TO_VERIFIED_ADDRESS',
          'SHIP_TO_DIFFERENT_ADDRESS',
          'SHIP_TO_STORE',
          'DIGITAL_GOODS',
          'TRAVEL_AND_EVENT_TICKETS',
          'OTHER'
      )
    );

}
