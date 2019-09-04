<?php

namespace Paysafe\ThreeDSecureV2;

/**
 * @property string $title
 * @property string $firstName
 * @property string $lastName
 * @property string $email	
 * @property '\Paysafe\JSONObject\DateOfBirth'
 * @property string 'gender'
 * @property '\Paysafe\JSONObject\IdentityDocument'
 * @property string $kycStatus
 * @property string $phone
 * @property string $cellphone
 * @property string $locale
 * 
 */
class Profile extends \Paysafe\JSONObject
{

    protected static $fieldTypes = array(
   
     'title' => 'String',
     'firstName' => 'string',
     'lastName' => 'string',
     'email' => 'string',
     'dateOfBirth' => '\Paysafe\JSONObject\DateOfBirth',
     'gender' => array(
        'M',
        'F',
        'O',
        'N'
     ),
     'identityDocuments' => '\Paysafe\JSONObject\IdentityDocument',
     'kycStatus' => array(
       'UNVERIFIED',
       'PARTIALLY_VERIFIED',
       'VERIFIED'
     ),
     'phone' => 'string'
     'cellphone' => 'string'
     'locale' => array(
      'en_US',
      'fr_CA',
      'en_GB'
     )
    );
    
}
