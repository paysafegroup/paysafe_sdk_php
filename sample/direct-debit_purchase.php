<?php

    require_once('config.php');

    use Paysafe\PaysafeApiClient;
    use Paysafe\Environment;
    use Paysafe\DirectDebit\Purchase;
    use Paysafe\DirectDebit\Filter;

if ($_POST)
    {
        try
        {
            if ($_POST['Paysafe'])
            {
                $submitPurchase = $_POST['Paysafe'];
            }
            if ($submitPurchase == 'ach_without_token' || $submitPurchase == 'ach_with_token' || $submitPurchase == "lookupPurchaseRequestACH" || $submitPurchase == 'cancelPurchaseRequestACH' || $submitPurchase == 'lookupPurchaseRequestACHMRN')
            {

                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } elseif ($submitPurchase == 'eft_without_token' || $submitPurchase == 'eft_with_token' || $submitPurchase == "lookupPurchaseRequestEFT" || $submitPurchase == 'cancelPurchaseRequestEFT' || $submitPurchase == 'lookupPurchaseRequestEFTMRN')
            {

                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } elseif ($submitPurchase == 'bacs_without_token' || $submitPurchase == 'bacs_with_token' || $submitPurchase == "lookupPurchaseRequestBACS" || $submitPurchase == 'cancelPurchaseRequestBACS' || $submitPurchase == 'lookupPurchaseRequestBACSMRN')
            {

                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } elseif ($submitPurchase == 'sepa_without_token' || $submitPurchase == 'sepa_with_token' || $submitPurchase == "lookupPurchaseRequestSEPA" || $submitPurchase == 'cancelPurchaseRequestSEPA' || $submitPurchase == 'lookupPurchaseRequestSEPAMRN')
            {

                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            } else
            {
                $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
            }

            if ($submitPurchase == 'ach_without_token')
            {
                $purchase = $client->directDebitService()->submit(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'],
                    'ach' => array(
                        'accountHolderName' => "XYZ Company",
                        'accountType' => "CHECKING",
                        'accountNumber' => "988772192",
                        'routingNumber' => "211589828",
                        'payMethod' => "PPD"
                    ),
                    'profile' => array(
                        'firstName' => $_POST['firstName'],
                        'lastName' => $_POST['lastName'],
                        'email' => $_POST['email']
                    ),
                    'billingDetails' => array(
                        'street' => $_POST['street'],
                        'city' => $_POST['city'],
                        'state' => $_POST['state'],
                        'country' => $_POST['country'],
                        'zip' => $_POST['zip'],
                        'phone' => $_POST['phone']
                    )
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            }
            /* ACH using Payment  Token */ else if ($submitPurchase == 'ach_with_token')
            {

                $purchase = $client->directDebitService()->submit(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'],
                    'ach' => array(
                        //you will get payment tokenm, after account created.
                        'paymentToken' => $_POST['paymentToken'],
                        'payMethod' => "WEB"
                    )
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            }
            /* END ACH Using Payment Token */

            /* EFT without Payment Token */ else if ($submitPurchase == 'eft_without_token')
            {
                $purchase = $client->directDebitService()->submit(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'],
                    'eft' => array(
                        'accountHolderName' => "XYZ Company",
                        'accountNumber' => "336612",
                        'transitNumber' => "22446",
                        'institutionId' => "001"
                    ),
                    'profile' => array(
                        'firstName' => $_POST['firstName'],
                        'lastName' => $_POST['lastName'],
                        'email' => $_POST['email']
                    ),
                    'billingDetails' => array(
                        'street' => $_POST['street'],
                        'city' => $_POST['city'],
                        'state' => $_POST['state'],
                        'country' => $_POST['country'],
                        'zip' => $_POST['zip'],
                        'phone' => $_POST['phone']
                    )
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            }
            /* End EFT Without Payment Token */

            /*
             * EFT using payment Token
             */ else if ($submitPurchase == 'eft_with_token')
            {
                echo "<br /> in $submitPurchase";
                $purchase = $client->directDebitService()->submit(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'],
                    'eft' => array(
                        'paymentToken' => 'Dw6TqO65OiBamTA'//$_POST['paymentToken']//DQSSTfrd2TlkTMQ
                    )
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            }
            /* END EFT using Payment Token */


            /* BACS  USing Payment Token */ else if ($submitPurchase == 'bacs_with_token')
            {
                $purchase = $client->directDebitService()->submit(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'],
                    'bacs' => array(
                        'paymentToken' => $_POST['paymentToken']
                    )
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            } else if ($submitPurchase == 'sepa_with_token')
            {
                $purchase = $client->directDebitService()->submit(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num'],
                    'amount' => $_POST['amount'],
                    'sepa' => array(
                        'paymentToken' => $_POST['paymentToken']//DQSSTfrd2TlkTMQ
                    )
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            }
            /* END BACS  USing Payment Token */
            /* Cancel ACH without Payment Token */ else if ($submitPurchase == 'cancelPurchaseRequestACH' || $submitPurchase == 'cancelPurchaseRequestSEPA' || $submitPurchase == 'cancelPurchaseRequestBACS' || $submitPurchase == 'cancelPurchaseRequestEFT')
            {
                $purchase = $client->directDebitService()->cancelPurchase(new Purchase(array(
                    'id' => $_POST['paymentID'],
                    'status' => "CANCELLED"
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            } else if ($submitPurchase == 'lookupPurchaseRequestACH' || $submitPurchase == 'lookupPurchaseRequestEFT' || $submitPurchase == 'lookupPurchaseRequestSEPA' || $submitPurchase == 'lookupPurchaseRequestBACS')
            {
                $purchase = $client->directDebitService()->getPurchase(new Purchase(array(
                    'id' => $_POST['paymentID'],
                    'status' => "CANCELLED"
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            } else if ($submitPurchase == 'lookupPurchaseRequestACHMRN' || $submitPurchase == 'lookupPurchaseRequestEFTMRN' || $submitPurchase == 'lookupPurchaseRequestSEPAMRN' || $submitPurchase == 'lookupPurchaseRequestBACSMRN')
            {
                $purchase = $client->directDebitService()->getPurchases(new Purchase(array(
                    'merchantRefNum' => $_POST['merchant_ref_num']
                        )), new Filter(array(
                    'limit' => 15,
                    'offset' => 0
                )));
                echo "<pre>";
                print_r($purchase);
                echo "</pre>";
                die;
            }
            /* End cancel ACH without Payment Token */
            die('Payment successful! ID: ' . $purchase->id);
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
            //for debug only, these errors should be properly handled before production
            var_dump($e->getMessage());
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paysafe SDK -Direct Debit</title>
    </head>
    <body>
        <form method="post">
            <fieldset>
                <legend>Billing Details</legend>
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
                        Street 2:
                        <input type="input" name="street2" value="<?php

                            if (isset($_POST['street2']))
                            {
                                echo $_POST['street2'];
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
                <div>
                    <label>
                        Phone:
                        <input type="input" name="phone" value="<?php

                            if (isset($_POST['phone']))
                            {
                                echo $_POST['phone'];
                            } else
                            {
                                echo "9988776655";
                            }

                        ?>"/>
                    </label>
                </div>

            </fieldset>

            <fieldset>
                <div>
                    <label>
                        First Name:
                        <input type="input" name="firstName" value="<?php

                            if (isset($_POST['firstName']))
                            {
                                echo $_POST['firstName'];
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Last Name:
                        <input type="input" name="lastName" value="<?php

                            if (isset($_POST['lastName']))
                            {
                                echo $_POST['lastName'];
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
                                echo "Joe.Smith@canada.com";
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        SSN:
                        <input type="input" name="ssn" value="<?php

                            if (isset($_POST['ssn']))
                            {
                                echo $_POST['ssn'];
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Date OF Birth:
                        Date
                        <input type="input" name="day" value="<?php

                            if (isset($_POST['day']))
                            {
                                echo $_POST['day'];
                            }

                        ?>"/>
                        Month
                        <input type="input" name="month" value="<?php

                            if (isset($_POST['month']))
                            {
                                echo $_POST['month'];
                            }

                        ?>"/>
                        Year
                        <input type="input" name="year" value="<?php

                            if (isset($_POST['year']))
                            {
                                echo $_POST['year'];
                            }

                        ?>"/>
                    </label>
                </div>
            </fieldset>
            <fieldset>
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
                                echo "100";
                            }

                        ?>"/>
                    </label>
                </div>
                <div>
                    Payment token : <input type="text" name="paymentToken" id="paymentToken" value="<?php

                        if (isset($_POST['paymentToken']))
                        {
                            echo $_POST['paymentToken'];
                        } else
                        {
                            echo "DmeucrpwVXlrLkw";
                        }

                    ?>"/> (required for EFT purchase with token)
                </div>
                <div>
                    Payment ID: <input type="text" name="paymentID" id="paymentID" value="<?php

                                           if (isset($_POST['paymentID']))
                                           {
                                               echo $_POST['paymentID'];
                                           } else
                                           {
                                               echo "f34369ee-8bd8-44d4-9554-7cec7d6ba4dc";
                                           }

                                       ?>"/>
                </div>


            </fieldset>

            <fieldset>
                <table border="0">
                    <tbody>
                        <tr><td>
                                <table border="1">
                                    <thead>
                                    <caption>Do Purchase</caption>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="ach_without_token"/>
                                                ACH
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="ach_with_token"/>
                                                ACH with token

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="eft_without_token"/>EFT
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="eft_with_token"/>EFT  With Token
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="bacs_without_token"/>BACS
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="bacs_with_token"/>BACS  With Token


                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="sepa_without_token"/>SEPA  </td><td>
                                                <input type="radio" name="Paysafe" value="sepa_with_token"/>SEPA  With Token</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td><td>
                                <br>
                                <table border="1">
                                    <thead>
                                    <caption>Lookup Purchase</caption>
                                    </thead>
                                    <tbody>
                                        <tr><td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestACH" />ACH
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestEFT" />EFT
                                            </td>
                                        <tr><td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestSEPA" />SEPA
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestBACS" />BACS
                                            </td></tr>
                                    </tbody>
                                </table>
                            </td><td>
                                <br>
                                <table border="1">
                                    <thead>
                                    <caption>Cancel Purchase</caption>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="cancelPurchaseRequestACH" /> ACH
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="cancelPurchaseRequestEFT" /> EFT
                                            </td></tr>
                                        <tr><td>
                                                <input type="radio" name="Paysafe" value="cancelPurchaseRequestSEPA" />SEPA
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="cancelPurchaseRequestBACS" /> BACS
                                            </td></tr>
                                    </tbody></table>
                            </td><td>
                                <br>
                                <table border="1">
                                    <thead>
                                    <caption>Lookup Purchase using merchant Ref</caption>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestACHMRN" />ACH
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestEFTMRN" />EFT</td></tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestSEPAMRN" />SEPA
                                            </td><td>
                                                <input type="radio" name="Paysafe" value="lookupPurchaseRequestBACSMRN" />BACS
                                            </td></tr>
                                    </tbody></table>
                            </td></tr>
                    </tbody>
                </table>
            </fieldset>
            <input type="submit" />
        </form>
    </body>
</html>