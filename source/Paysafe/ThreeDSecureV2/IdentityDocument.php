<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $type
 * @property string $documentNumber
 * @property string $issuingCountry
 * @property string $issuingCountrySubdvision	
 * @property '\Paysafe\JSONObject\IssueDate'
 * @property '\Paysafe\JSONObject\ExpiryDate'
 * 	
 * 
 */
class IdentityDocument extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
     'type' => array(
        'PASSPORT',
        'IDENTITY_CARD',
        'DRIVING_LICENSE',
        'SOCIAL_SECURITY',
        'NATIONAL_IDENTITY',
        'TAX_IDENTIFICATION',
        'REGISTRATION_ID',
        'ACRA',
        'LICENSE_NUMBER',
        'REGISTRATION_NUMBER'      
     )   
     'documentNumber' => 'String',
     'issuingCountry' => 'string',
     'issuingCountrySubdvision' => 'string',
     'issueDate' => '\Paysafe\JSONObject\IssueDate',
     'expiryDate' => '\Paysafe\JSONObject\ExpiryDate'
    );
    
}
