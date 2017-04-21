<?php

    require_once('config.php');

    use Paysafe\PaysafeApiClient;
    use Paysafe\Environment;
    use Paysafe\CustomerVault\Profile;
    use Paysafe\CustomerVault\Address;
    use Paysafe\CustomerVault\Card;
    use Paysafe\CustomerVault\Mandates;
    use Paysafe\CardPayments\Authorization;

if ($_POST)
    {
        $accountCreation = "";
        if (isset($_POST['paysafe']))
        {
            $accountCreation = $_POST['paysafe'];
            if ($accountCreation == "ACHcreate" || $accountCreation == "ACHlookup" || $accountCreation == "ACHupdate" || $accountCreation == "ACHdelete")
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else if ($accountCreation == "EFTcreate" || $accountCreation == "EFTlookup" || $accountCreation == "EFTupdate" || $accountCreation == "EFTdelete")
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else if ($accountCreation == "BACScreate" || $accountCreation == "BACSlookup" || $accountCreation == "BACSupdate" || $accountCreation == "BACSdelete")
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else if ($accountCreation == "SEPAcreate" || $accountCreation == "SEPAlookup" || $accountCreation == "SEPAupdate" || $accountCreation == "SEPAdelete")
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else if ($accountCreation == "create_sepa_mantade" || $accountCreation == "lookup_sepa_mantade" || $accountCreation == "update_sepa_mantade" || $accountCreation == "delete_sepa_mantade")
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else if ($accountCreation == "create_bacs_mantade" || $accountCreation == "lookup_bacs_mantade" || $accountCreation == "update_bacs_mantade" || $accountCreation == "delete_bacs_mantade")
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            }
        } else
        {
            $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
        }


        try
        {
            if ($accountCreation == "ACHcreate")
            {
                $profile = $client->customerVaultService()->createProfile(new Profile(array(
                    "merchantCustomerId" => $_POST['merchant_customer_id'],
                    "locale" => "en_US",
                    "firstName" => $_POST['first_name'],
                    "lastName" => $_POST['last_name'],
                    "email" => $_POST['email']
                )));
                echo "<pre> Profile created : <br>";
                print_r($profile);
                echo "</pre>";

                $address = $client->customerVaultService()->createAddress(new Address(array(
                    "nickName" => "home",
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip' => $_POST['zip'],
                    "profileID" => $profile->id
                )));

                echo "<pre> Address created <br>";
                print_r($address);
                echo "</pre>";


                $bankAccount = $client->customerVaultService()->createACHBankAccount(new Paysafe\CustomerVault\ACHBankaccounts(array(
                    'id' => $profile->id, //$_POST['profileid'],
                    'accountHolderName' => $_POST['first_name'],
                    'accountNumber' => rand(0, 999999999), //'988234423',
                    'routingNumber' => '211589828',
                    'billingAddressId' => $address->id,
                    'accountType' => 'SAVINGS'
                )));
                echo "<pre>  ACH Bank account created : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "ACHlookup")
            {
                $bankAccount = $client->customerVaultService()->getACHBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\ACHBankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>ACH account found:<br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "ACHupdate")
            {
                $bankAccount = $client->customerVaultService()->updateACHBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid'])), new Paysafe\CustomerVault\ACHBankaccounts(array(
                    'id' => $_POST['bankAccountId'],
                    'accountNumber' => $_POST['accountNumber'],
                    'routingNumber' => $_POST['routingNumber'],
                    'accountHolderName' => $_POST['accountHolderName'],
                    'billingAddressId' => $_POST['billingAddressId'],
                    'accountType' => $_POST['accountType']
                )));
                echo "<pre>Successfully updated ACH Bank account<br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "ACHdelete")
            {
                $bankAccount = $client->customerVaultService()->deleteACHBankAccount(new Paysafe\CustomerVault\Profile(array('id' => $_POST['profileid']))
                        , new Paysafe\CustomerVault\ACHBankaccounts(array(
                    'id' => $_POST['bankAccountId'])));
                echo "<pre>Successfully deleted ACH Bank account<br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "EFTcreate")
            {
                $profile = $client->customerVaultService()->createProfile(new Profile(array(
                    "merchantCustomerId" => $_POST['merchant_customer_id'],
                    "locale" => "en_US",
                    "firstName" => $_POST['first_name'],
                    "lastName" => $_POST['last_name'],
                    "email" => $_POST['email']
                )));
                echo "<pre> Profile created : <br>";
                print_r($profile);
                echo "</pre>";

                $address = $client->customerVaultService()->createAddress(new Address(array(
                    "nickName" => "home",
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip' => $_POST['zip'],
                    "profileID" => $profile->id
                )));
                echo "<pre> Address created <br>";
                print_r($address);
                echo "</pre>";

                $bankAccount = $client->customerVaultService()->createEFTBankAccount(new Paysafe\CustomerVault\EFTBankaccounts(array(
                    'id' => $profile->id, //"628817c7-b58b-4f4b-bdcc-1c451376736a", //$profile->id,
                    'accountNumber' => rand(0, 999999999),
                    'transitNumber' => '25039', //'988234423',
                    'institutionId' => '002',
                    'accountHolderName' => $_POST['first_name'],
                    'billingAddressId' => $address->id
                )));
                echo "<pre>  EFT Bank account created : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "EFTlookup")
            {
                $bankAccount = $client->customerVaultService()->getEFTBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\EFTBankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>EFT account found:<br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "EFTupdate")
            {
                $bankAccount = $client->customerVaultService()->updateEFTBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid'])), new Paysafe\CustomerVault\EFTBankaccounts(array(
                    'id' => $_POST['bankAccountId'],
                    'transitNumber' => "25039",
                    'institutionId' => "003",
                    'accountHolderName' => $_POST['accountHolderName'],
                    'billingAddressId' => $_POST['billingAddressId']
                        //optional attribs
                        //,"nickName"=>"nick name"
                        //,"merchantRefNum"=>$_POST['merchantRefNum']
                        //,"accountNumber"=>$_POST['accountNumber']
                )));
                echo "<pre>Successfully updated EFT Bank account<br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "EFTdelete")
            {
                $bankAccount = $client->customerVaultService()->deleteEFTBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\EFTBankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>Successfully deleted EFT Bank account<br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "BACScreate")
            {
                $profile = $client->customerVaultService()->createProfile(new Profile(array(
                    "merchantCustomerId" => $_POST['merchant_customer_id'],
                    "locale" => "en_US",
                    "firstName" => $_POST['first_name'],
                    "lastName" => $_POST['last_name'],
                    "email" => $_POST['email']
                )));
                echo "<pre> Profile created : <br>";
                print_r($profile);
                echo "</pre>";

                $address = $client->customerVaultService()->createAddress(new Address(array(
                    "nickName" => "home",
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip' => $_POST['zip'],
                    "profileID" => $profile->id
                )));
                echo "<pre> Address created <br>";
                print_r($address);
                echo "</pre>";

                $bankAccount = $client->customerVaultService()->createBACSBankAccount(new Paysafe\CustomerVault\BACSBankaccounts(array(
                    'id' => $profile->id,
                    'accountNumber' => rand(0, 999999999), //'988234423',
                    'sortCode' => $_POST['sortCode'], //'211589',
                    'accountHolderName' => $_POST['first_name'],
                    'billingAddressId' => $address->id
                )));
                echo "<pre>  BACS Bank account created : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "BACScreateMandate")
            {
                $profile = $client->customerVaultService()->createProfile(new Profile(array(
                    "merchantCustomerId" => $_POST['merchant_customer_id'],
                    "locale" => "en_US",
                    "firstName" => $_POST['first_name'],
                    "lastName" => $_POST['last_name'],
                    "email" => $_POST['email']
                )));
                echo "<pre>Profile created : <br>";
                print_r($profile);
                echo "</pre>";

                $address = $client->customerVaultService()->createAddress(new Address(array(
                    "nickName" => "home",
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip' => $_POST['zip'],
                    "profileID" => $profile->id
                )));
                echo "<pre>Address created : <br>";
                print_r($address);
                echo "</pre>";

                $bankAccount = $client->customerVaultService()->createBACSBankAccount(new Paysafe\CustomerVault\BACSBankaccounts(array(
                    'id' => $profile->id, //$_POST['profileid'], //$profile->id,
                    'accountNumber' => '80829064', //rand(0, 99999999), //'988234423',
                    'sortCode' => $_POST['sortCode'], //'207405',
                    'accountHolderName' => $_POST['first_name'],
                    'billingAddressId' => $address->id, //$address->id,
                    'mandate' => array("reference" => "ABCAAFGHIJ")
                )));
                echo "<pre>  BACS Bank account created with mandate: <br>";
                print_r($bankAccount);
                echo "</pre>";
            } else if ($accountCreation == "BACSlookup")
            {

                $bankAccount = $client->customerVaultService()->getBACSBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\BACSBankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>  BACS Bank account found : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "BACSupdate")
            {
                $bankAccount = $client->customerVaultService()->updateBACSBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid'])), new Paysafe\CustomerVault\BACSBankaccounts(array(
                    'id' => $_POST['bankAccountId'],
                    'accountHolderName' => $_POST['accountHolderName'],
                    "sortCode" => $_POST['sortCode'],
                    "accountNumber" => $_POST['accountNumber'],
                    'billingAddressId' => $_POST['billingAddressId']
                )));
                echo "<pre>  BACS Bank account updated : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "BACSdelete")
            {
                $bankAccount = $client->customerVaultService()->deleteBACSBankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\BACSBankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>  BACS Bank account deleted : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "SEPAcreate")
            {
                $profile = $client->customerVaultService()->createProfile(new Profile(array(
                    "merchantCustomerId" => $_POST['merchant_customer_id'],
                    "locale" => "en_US",
                    "firstName" => $_POST['first_name'],
                    "lastName" => $_POST['last_name'],
                    "email" => $_POST['email']
                )));
                echo "<pre>Profile created : <br>";
                print_r($profile);
                echo "</pre>";

                $address = $client->customerVaultService()->createAddress(new Address(array(
                    "nickName" => "home",
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip' => $_POST['zip'],
                    "profileID" => $profile->id
                )));
                echo "<pre>Address created : <br>";
                print_r($address);
                echo "</pre>";

                $bankAccount = $client->customerVaultService()->createSEPABankAccount(new Paysafe\CustomerVault\SEPABankaccounts(array(
                    'id' => $profile->id, //$_POST['profileid'], //$profile->id,
                    'iban' => $_POST['iban'],
                    'accountHolderName' => $_POST['first_name'],
                    'billingAddressId' => $address->id
                )));
                echo "<pre>SEPA Bank account created : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "SEPAlookup")
            {
                $bankAccount = $client->customerVaultService()->getSEPABankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\SEPABankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>SEPA Bank account found: <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "SEPAupdate")
            {
                $bankAccount = $client->customerVaultService()->updateSEPABankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid'])), new Paysafe\CustomerVault\SEPABankaccounts(array(
                    'id' => $_POST['bankAccountId'],
                    'accountHolderName' => $_POST['accountHolderName'],
                    'iban' => $_POST['iban'],
                    'billingAddressId' => $_POST['billingAddressId'],
                )));
                echo "<pre>  SEPA Bank account updated : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "SEPAdelete")
            {
                $bankAccount = $client->customerVaultService()->deleteSEPABankAccount(new Paysafe\CustomerVault\Profile(array(
                    'id' => $_POST['profileid']
                        ))
                        , new Paysafe\CustomerVault\SEPABankaccounts(array(
                    'id' => $_POST['bankAccountId']
                )));
                echo "<pre>  SEPA Bank account deleted : <br>";
                print_r($bankAccount);
                echo "</pre>";
                die;
            } else if ($accountCreation == "lookupprofile")
            {
                $includeAddresses = $includeCards = $includeachbankaccount = $includeeftbankaccount = $includebacsbankaccount = $includesepabankaccount = false;
                if (isset($_POST['addresslookupinprofile']) && $_POST['addresslookupinprofile'] == 'on')
                {
                    $includeAddresses = true;
                }
                if (isset($_POST['cardslookupinprofile']) && $_POST['cardslookupinprofile'] == 'on')
                {
                    $includeCards = true;
                }if (isset($_POST['achlookupinprofile']) && $_POST['achlookupinprofile'] == 'on')
                {
                    $includeachbankaccount = true;
                }if (isset($_POST['eftlookupinprofile']) && $_POST['eftlookupinprofile'] == 'on')
                {
                    $includeeftbankaccount = true;
                }if (isset($_POST['bacslookupinprofile']) && $_POST['bacslookupinprofile'] == 'on')
                {
                    $includebacsbankaccount = true;
                }if (isset($_POST['sepalookupinprofile']) && $_POST['sepalookupinprofile'] == 'on')
                {
                    $includesepabankaccount = true;
                }

                $profile = $client->customerVaultService()->getProfile(new Profile(array('id' => $_POST['profileid'])), $includeAddresses, $includeCards, $includeachbankaccount, $includeeftbankaccount, $includebacsbankaccount, $includesepabankaccount);
            } else if ($accountCreation == 'create_sepa_mantade' || $accountCreation == 'create_bacs_mantade')
            {
                if ($accountCreation == 'create_sepa_mantade')
                {
                    $bankaccounts = "sepabankaccounts";
                } else
                {
                    $bankaccounts = "bacsbankaccounts";
                }
                $mandates = $client->customerVaultService()->createMandates(new Mandates(array(
                    "reference" => $_POST['reference_id'],
                    "profileID" => $_POST['profileid'],
                    "bankAccountId" => $_POST['bankAccountId']
                        )), $bankaccounts);
                echo "<pre>  $bankaccounts created : <br>";
                print_r($mandates);
                echo "</pre>";
                die;
            } else if ($accountCreation == 'lookup_sepa_mantade' || $accountCreation == 'lookup_bacs_mantade')
            {
                $mandates = $client->customerVaultService()->getMandates(new Mandates(array(
                    "id" => $_POST['mandate_id'],
                    "profileID" => $_POST['profileid']
                )));
                echo "<pre>";
                print_r($mandates);
                echo "</pre>";
                die;
            } else if ($accountCreation == 'update_sepa_mantade' || $accountCreation == 'update_bacs_mantade')
            {
                $mandates = $client->customerVaultService()->updateMandates(new Mandates(array(
                    "id" => $_POST['mandate_id'],
                    "status" => "CANCELLED",
                    "profileID" => $_POST['profileid']
                )));
                echo "<pre>";
                print_r($mandates);
                echo "</pre>";
                die;
            } else if ($accountCreation == 'delete_sepa_mantade' || $accountCreation == 'delete_bacs_mantade')
            {
                $mandates = $client->customerVaultService()->deleteMandates(new Mandates(array(
                    "id" => $_POST['mandate_id'],
                    "profileID" => $_POST['profileid']
                )));
                echo "<pre>";
                print_r($mandates);
                echo "</pre>";
                die;
            } else
            {
                $profile = $client->customerVaultService()->createProfile(new Profile(array(
                    "merchantCustomerId" => $_POST['merchant_customer_id'],
                    "locale" => "en_US",
                    "firstName" => $_POST['first_name'],
                    "lastName" => $_POST['last_name'],
                    "email" => $_POST['email']
                )));
                echo "<pre>";
                print_r($profile);
                echo "</pre>";

                $address = $client->customerVaultService()->createAddress(new Address(array(
                    "nickName" => "home",
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip' => $_POST['zip'],
                    "profileID" => $profile->id
                )));
                echo "<pre>";
                print_r($address);
                echo "</pre>";

                $card = $client->customerVaultService()->createCard(new Card(array(
                    "nickName" => "Default Card",
                    'cardNum' => $_POST['card_number'],
                    'cardExpiry' => array(
                        'month' => $_POST['card_exp_month'],
                        'year' => $_POST['card_exp_year']
                    ),
                    'billingAddressId' => $address->id,
                    "profileID" => $profile->id
                )));
                echo "<pre>";
                print_r($card);
                echo "</pre>";

                $auth = $client->cardPaymentService()->authorize(new Authorization(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'] * $currencyBaseUnitsMultiplier,
                    'settleWithAuth' => true,
                    'card' => array(
                        'paymentToken' => $card->paymentToken
                    )
                )));
                echo "<pre>";
                print_r($card);
                echo "</pre>";
                die;
            }
        } catch (Paysafe\PaysafeException $e)
        {
            echo '<pre>';
            var_dump($e->getMessage());
            if ($e->fieldErrors)
            {
                var_dump($e->fieldErrors);
            }
            if ($e->links)
            {
                var_dump($e->links);
            }
            echo '</pre>';
        } catch (Paysafe\PaysafeException $e)
        {
            var_dump($e->getMessage());
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paysafe SDK - CardPayment With Customer Vault</title>
    </head>
    <body>
        <form method="post">
            <fieldset>
                <legend>Billing Details</legend>
                <div>
                    <label>
                        Merchant Customer Id:
                        <input type="input" name="merchant_customer_id" size="30" value="<?php

                            if (isset($_POST['merchant_customer_id']))
                            {
                                echo $_POST['merchant_customer_id'];
                            } else
                            {
                                echo uniqid('cust-' . date('Ymd-'));
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        First Name:
                        <input type="input" name="first_name" value="<?php

                            if (isset($_POST['first_name']))
                            {
                                echo $_POST['first_name'];
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Last Name:
                        <input type="input" name="last_name" value="<?php

                            if (isset($_POST['last_name']))
                            {
                                echo $_POST['last_name'];
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Email:
                        <input type="input" name="email" value="<?php

                            if (isset($_POST['email']))
                            {
                                echo $_POST['email'];
                            } else
                            {
                                echo "test@test.com";
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Street:
                        <input type="input" name="street" value="<?php

                            if (isset($_POST['street']))
                            {
                                echo $_POST['street'];
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        City:
                        <input type="input" name="city" value="<?php

                            if (isset($_POST['city']))
                            {
                                echo $_POST['city'];
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        State/Province:
                        <input type="input" name="state" value="<?php

                            if (isset($_POST['state']))
                            {
                                echo $_POST['state'];
                            } else
                            {
                                echo "ON";
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Country:
                        <select name="country">
                            <option value="CA"<?php

                                if (isset($_POST['country']) && $_POST['country'] == 'CA')
                                {
                                    echo ' selected';
                                }

                            ?>>Canada</option>
                            <option value="US"<?php

                                if (isset($_POST['country']) && $_POST['country'] == 'US')
                                {
                                    echo ' selected';
                                }

                            ?>>USA</option>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        Zip/Postal Code:
                        <input type="input" name="zip" value="<?php

                            if (isset($_POST['zip']))
                            {
                                echo $_POST['zip'];
                            } else
                            {
                                echo "M5H 2N2";
                            }

                        ?>"/>
                    </label>
                </div>
            </fieldset>
            <fieldset>
                <legend>Order Details</legend>
                <div>
                    <label>
                        Merchant Ref Num:
                        <input type="input" name="merchant_ref_num" value="<?php

                            if (isset($_POST['merchant_ref_num']))
                            {
                                echo $_POST['merchant_ref_num'];
                            } else
                            {
                                echo uniqid(date('Ymd-'));
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Amount:
                        <input type="input" name="amount" value="<?php

                            if (isset($_POST['amount']))
                            {
                                echo $_POST['amount'];
                            } else
                            {
                                echo "100.00";
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Card Number:
                        <input type="input" autocomplete="off" name="card_number" value="<?php

                            if (isset($_POST['card_number']))
                            {
                                echo $_POST['card_number'];
                            } else
                            {
                                echo "4444333322221111";
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Card Expiry:
                        <select name="card_exp_month">
                            <?php

                                $currentMonth = Date('n');
                                for ($i = 1; $i <= 12; $i++)
                                {
                                    echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_month']) && $_POST['card_exp_month'] == $i) || (!isset($_POST['card_exp_month']) && $i == $currentMonth)) ? ' selected' : '') . '>' . DateTime::createFromFormat('!m', $i)->format('F') . '</option>';
                                }

                            ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        Card Expiry:
                        <select name="card_exp_year">
                            <?php

                                $currentYear = Date('Y');
                                for ($i = $currentYear; $i < $currentYear + 5; $i++)
                                {
                                    echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_year']) && $_POST['card_exp_year'] == $i) || (!isset($_POST['card_exp_year']) && $i == $currentYear)) ? ' selected' : '') . '>' . $i . '</option>';
                                }

                            ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>IBAN. REQD for SEPA account
                        <input type="text" id="iban" name="iban"/>
                    </label>
                </div>
            </fieldset>
            <fieldset>
                <legend>Profile lookup's fields</legend>
                <div>
                    <label>Profile Id
                        <input type="text" id="profileid" name="profileid"/>
                    </label>
                    <label>
                        <input type="checkbox" id="achlookupinprofile" name="addresslookupinprofile" checked/>address in lookup
                    </label>
                    <label>
                        <input type="checkbox" id="achlookupinprofile" name="cardslookupinprofile" checked/>cards in lookup
                    </label>
                    <label>
                        <input type="checkbox" id="achlookupinprofile" name="achlookupinprofile" checked/>ACH in lookup
                    </label>
                    <label>
                        <input type="checkbox" id="eftlookupinprofile" name="eftlookupinprofile" />EFT in lookup
                    </label>
                    <label>
                        <input type="checkbox" id="bacslookupinprofile" name="bacslookupinprofile"/>BACS in lookup
                    </label>
                    <label>
                        <input type="checkbox" id="sepalookupinprofile" name="sepalookupinprofile"/>SEPA in lookup
                    </label>
                </div></fieldset>
            <fieldset>
                <legend>Bank account lookup's fields</legend>
                <div>
                    <label>Profile Id
                        <input type="text" id="profileid" name="profileid"/>
                    </label>
                    <label>Bank Account Id
                        <input type="text" id="bankAccountId" name="bankAccountId"/>
                    </label>
                </div></fieldset>
            <fieldset>
                <legend>Bank account updation fields</legend>
                <div>
                    <label>new Bank account Number
                        <input type="text" id="accountNumber" name="accountNumber"/>
                    </label>
                    <label>new Bank routing Number
                        <input type="text" id="routingNumber" name="routingNumber"/>
                    </label>
                    <br ><label>new Bank account Holder Name
                        <input type="text" id="accountHolderName" name="accountHolderName"/>
                    </label>
                    <label>new billing Address Id
                        <input type="text" id="billingAddressId" name="billingAddressId"/>
                    </label>
                    <label>new accountType
                        <input type="text" id="accountType" name="accountType"/>
                    </label>
                    <label>sort code
                        <input type="text" id="sortCode" name="sortCode"/>
                    </label>
                </div>
            </fieldset>
            <fieldset>
                <legend>Mandates</legend>
                <label>
                    Reference:
                    <input type="input" autocomplete="off" name="reference_id" value="<?php

                        if (isset($_POST['reference_id']))
                        {
                            echo $_POST['reference_id'];
                        } else
                        {
                            echo "SUBSCRIPTION123";
                        }

                    ?>"/>
                </label>

                <!--                                      <label>
                                                                Profile ID:
                                                                <input type="input" autocomplete="off" name="profile_id" value="<?php

                    if (isset($_POST['profile_id']))
                    {
                        echo $_POST['profile_id'];
                    }

                ?>"/>
                                                        </label>
                                                    <label>
                                                                Bank Account ID:
                                                                <input type="input" autocomplete="off" name="bank_id" value="<?php

                    if (isset($_POST['bank_id']))
                    {
                        echo $_POST['bank_id'];
                    } else
                    {
                        echo "85d31c5d-b1d0-4269-b317-e390326f09a9";
                    }

                ?>"/>
                                                        </label>

                                                    <label>-->
                Mandate ID:
                <input type="input" autocomplete="off" name="mandate_id" value="<?php

                    if (isset($_POST['mandate_id']))
                    {
                        echo $_POST['mandate_id'];
                    } else
                    {
                        echo "";
                    }

                ?>"/>
                </label>
            </fieldset>

        </fieldset>
        <fieldset>
            <legend>operations</legend>
            <div>
                <label>
                    <input type="radio" name="paysafe" value="lookupprofile" />Lookup profile
                </label>
            </div>
            <div>
                ACH
                <label>
                    <input type="radio" name="paysafe" value="ACHcreate" />create
                </label>
                <label>
                    <input type="radio" name="paysafe" value="ACHlookup" />lookup
                </label>
                <label>
                    <input type="radio" name="paysafe" value="ACHupdate" />update
                </label>
                <label>
                    <input type="radio" name="paysafe" value="ACHdelete" />delete
                </label>
            </div>
            <div>
                EFT
                <label>
                    <input type="radio" name="paysafe" value="EFTcreate" />create
                </label>
                <label>
                    <input type="radio" name="paysafe" value="EFTlookup" />lookup
                </label>
                <label>
                    <input type="radio" name="paysafe" value="EFTupdate" />update
                </label>
                <label>
                    <input type="radio" name="paysafe" value="EFTdelete" />delete
                </label>
            </div>

            <div>
                BACS
                <label>
                    <input type="radio" name="paysafe" value="BACScreate" />create
                </label>
                <label>
                    <input type="radio" name="paysafe" value="BACScreateMandate" />create with mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="BACSlookup" />lookup
                </label>
                <label>
                    <input type="radio" name="paysafe" value="BACSupdate" />update
                </label>
                <label>
                    <input type="radio" name="paysafe" value="BACSdelete" />delete
                </label>
            </div>

            <div>
                SEPA
                <label>
                    <input type="radio" name="paysafe" value="SEPAcreate" />create
                </label>

                <label>
                    <input type="radio" name="paysafe" value="SEPAlookup" />lookup
                </label>
                <label>
                    <input type="radio" name="paysafe" value="SEPAupdate" />update
                </label>
                <label>
                    <input type="radio" name="paysafe" value="SEPAdelete" />delete
                </label>
            </div>

        </fieldset>
        <fieldset>
            <legend>Mandates Operations</legend>

            <div>SEPA
                <label>
                    <input type="radio" name="paysafe" value="create_sepa_mantade" />Create Mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="lookup_sepa_mantade" />Lookup Mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="update_sepa_mantade" />Update Mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="delete_sepa_mantade" />Delete Mandate
                </label>
            </div>
            <div>
                BACS
                <label>
                    <input type="radio" name="paysafe" value="create_bacs_mantade" />Create Mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="lookup_bacs_mantade" />Lookup Mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="update_bacs_mantade" />Update Mandate
                </label>
                <label>
                    <input type="radio" name="paysafe" value="delete_bacs_mantade" />Delete Mandate
                </label>
            </div>
        </fieldset>

        <input type="submit" />
    </form>
</body>
</html>