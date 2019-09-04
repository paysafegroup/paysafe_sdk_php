<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property bool $javaEnabled
 * @property bool $javascriptEnabled
 * @property string $language
 * @property int $colorDepthBits
 * @property int $screenHeight
 * @property int $screenWidth
 * @property int $timezoneOffset
 * @property string $userAgent
 * @property string $acceptHeader
 * @property string $customerIp
 * 
 */
class BrowserDetails extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
     'javaEnabled' => 'bool',
     'javascriptEnabled' => 'bool',
     'language' => 'string',
     'colorDepthBits' => array(
        1,
        4,
        8,
        15,
        16,
        24,
        32,
        48
     ),
    
     'screenHeight' => 'int',
     'screenWidth' => 'int',
     'timezoneOffset' => 'int',
     'userAgent' => 'string',
     'acceptHeader' => 'string',
     'customerIp' => 'string'
    
    );

}
