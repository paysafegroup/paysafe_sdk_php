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
 * @property \Paysafe\CustomerVault\DateOfBirth $dateOfBirth
 * @property \Paysafe\CustomerVault\Card $card
 * @property string $ip
 * @property string $gender
 * @property string $nationality
 * @property string $email
 * @property string $phone
 * @property string $cellPhone
 * @property string $paymentToken
 * @property \Paysafe\CustomerVault\Address[] $addresses
 * @property \Paysafe\CustomerVault\Card[] $cards
 * @property \Paysafe\Error $error
 * @property \Paysafe\Link[] $links
 * @property \Paysafe\achbankaccount $achBankAccounts
 * @property \Paysafe\bacsbankaccounts $bacsBankAccounts
 * @property \Paysafe\eftbankaccounts $eftBankAccounts
 * @property \Paysafe\sepabankaccounts $sepaBankAccounts
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
		 'card' => '\Paysafe\CustomerVault\Card',
         'cards'=>'array:\Paysafe\CustomerVault\Card',
         'error' => '\Paysafe\Error',
         'links' => 'array:\Paysafe\Link',
		     'achBankAccounts' => 'array:\Paysafe\CustomerVault\ACHBankaccounts',
         'bacsBankAccounts' => 'array:\Paysafe\CustomerVault\BACSBankaccounts',
         'eftBankAccounts' => 'array:\Paysafe\CustomerVault\EFTBankaccounts',
         'sepaBankAccounts' => 'array:\Paysafe\CustomerVault\SEPABankaccounts'
    );

}
