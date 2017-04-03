<?php
/*
 * Copyright (c) 2014 OptimalPayments
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Paysafe\CustomerVault;

/**
 * @property string $id
 * @property string $status
 * @property string $merchantCustomerId
 * @property string $local
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 * @property \OptimalPayments\CustomerVault\DateOfBirth $dateOfBirth
 * @property string $ip
 * @property string $gender
 * @property string $nationality
 * @property string $email
 * @property string $phone
 * @property string $cellPhone
 * @property string $paymentToken
 * @property \OptimalPayments\CustomerVault\Address[] $addresses
 * @property \OptimalPayments\CustomerVault\Card[] $cards
 * @property \OptimalPayments\Error $error
 * @property \OptimalPayments\Link[] $links
 * @property \OptimalPayments\achbankaccount $achBankAccounts
 * @property \OptimalPayments\bacsbankaccounts $bacsBankAccounts
 * @property \OptimalPayments\eftbankaccounts $eftBankAccounts
 * @property \OptimalPayments\sepabankaccounts $sepaBankAccounts
 */
class Profile extends \Paysafe\JSONObject
{
    protected static $fieldTypes = array(
         'id'=>'string',
         'status' => array(
              'INITIAL',
              'ACTIVE'
         ),
         'merchantCustomerId'=>'string',
         'locale'=>array(
              'en_US',
              'fr_CA',
              'en_GB'
         ),
         'firstName'=>'string',
         'middleName'=>'string',
         'lastName'=>'string',
         'dateOfBirth'=>'\Paysafe\CustomerVault\DateOfBirth',
         'ip'=>'string',
         'gender'=>array(
              'M',
              'F'
         ),
         'nationality'=>'string',
         'email'=>'email',
         'phone'=>'string',
         'cellPhone'=>'string',
         'paymentToken'=>'string',
         'addresses'=>'array:\Paysafe\CustomerVault\Address',
         'cards'=>'array:\Paysafe\CustomerVault\Card',
         'error' => '\Paysafe\Error',
         'links' => 'array:\Paysafe\Link',
		 'achBankAccounts' => '\Paysafe\CustomerVault\ACHBankaccounts',
         'bacsBankAccounts' => '\Paysafe\CustomerVault\BACSBankaccounts',
         'eftBankAccounts' => '\Paysafe\CustomerVault\EFTBankaccounts',
         'sepaBankAccounts' => '\Paysafe\CustomerVault\SEPABankaccounts'
    );

}
