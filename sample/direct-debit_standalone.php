<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\DirectDebit\StandaloneCredits;
use Paysafe\DirectDebit\Filter;

if ($_POST) {
    $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
    try {
        if (isset($_POST['standalonecredit'])) {
            $standaloneCreditRequest = $_POST['standalonecredit'];
        }
        if ($standaloneCreditRequest == 'ach_Without_Token' || $standaloneCreditRequest == 'ach_With_Token' || $standaloneCreditRequest == "lookupStandaloneRequestACH" || $standaloneCreditRequest == 'cancelStandaloneRequestACH' || $standaloneCreditRequest == 'lookupStandaloneRequestACHMRN') {
            $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
        } elseif ($standaloneCreditRequest == 'eft_Without_Token' || $standaloneCreditRequest == 'eft_With_Token' || $standaloneCreditRequest == "lookupStandaloneRequestEFT" || $standaloneCreditRequest == 'cancelStandaloneRequestEFT' || $standaloneCreditRequest == 'lookupStandaloneRequestMRN') {
            $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
        } elseif ($standaloneCreditRequest == 'bacs_Without_Token' || $standaloneCreditRequest == 'bacs_With_Token' || $standaloneCreditRequest == "lookupStandaloneRequestBACS" || $standaloneCreditRequest == 'cancelStandaloneRequestBACS' || $standaloneCreditRequest == 'lookupStandaloneRequestBACSMRN') {
            $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
        } else {
            $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
        }

        if ($standaloneCreditRequest == "ach_Without_Token") {

            $standalone = $client->directDebitService()->standaloneCredits(new StandaloneCredits(array(
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
            print_r($standalone);
            echo "</pre>";
            die;
        }
        /* ACH using Payment  Token */ else if ($standaloneCreditRequest == "ach_With_Token") {
            $standalone = $client->directDebitService()->standaloneCredits(new StandaloneCredits(array(
                'merchantRefNum' => $_POST['merchant_ref_num'],
                'amount' => $_POST['amount'],
                'ach' => array(
                    'paymentToken' => $_POST['paymentToken'],
                    'payMethod' => "WEB" // DQSSTfrd2TlkTMQ
                )
            )));
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        }


        /* EFT without Payment Token */ else if ($standaloneCreditRequest == "eft_Without_Token") {

            $standalone = $client->directDebitService()->standaloneCredits(new StandaloneCredits(array(
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
            print_r($standalone);
            echo "</pre>";
            die;
        }

        /* EFT using payment Token */ else if ($standaloneCreditRequest == "eft_With_Token") {
            $standalone = $client->directDebitService()->standaloneCredits(new StandaloneCredits(array(
                'merchantRefNum' => $_POST['merchant_ref_num'],
                'amount' => $_POST['amount'],
                'eft' => array(
                    'paymentToken' => $_POST['paymentToken']//DQSSTfrd2TlkTMQ
                )
            )));
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        }


        /* BACS without Payment Token */ else if ($standaloneCreditRequest == "bacs_Without_Token") {
            $standalone = $client->directDebitService()->standaloneCredits(new StandaloneCredits(array(
                'merchantRefNum' => $_POST['merchant_ref_num'],
                'amount' => $_POST['amount'],
                'bacs' => array(
                    'accountHolderName' => "XYZ Company",
                    'accountNumber' => "19706829",
                    'sortCode' => "070246",
                    'mandateReference' => "SUBSCRIP10"
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
            print_r($standalone);
            echo "</pre>";
            die;
        }

        /* BACS  USing Payment Token */ else if ($standaloneCreditRequest == "bacs_With_Token") {
            $standalone = $client->directDebitService()->standaloneCredits(new StandaloneCredits(array(
                'merchantRefNum' => $_POST['merchant_ref_num'],
                'amount' => $_POST['amount'],
                'bacs' => array(
                    'paymentToken' => $_POST['paymentToken'],
                )
            )));
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        } else if ($standaloneCreditRequest == 'cancelStandaloneRequestACH' || $standaloneCreditRequest == 'cancelStandaloneRequestBACS' || $standaloneCreditRequest == 'cancelStandaloneRequestEFT') {
            $standalone = $client->directDebitService()->cancelStandaloneCredits(new StandaloneCredits(array(
                'id' => $_POST['paymentID'],
                'status' => "CANCELLED"
            )));
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        } else if ($standaloneCreditRequest == 'lookupStandaloneRequestACH' || $standaloneCreditRequest == 'lookupStandaloneRequestEFT' || $standaloneCreditRequest == 'lookupStandaloneRequestBACS') {
            $standalone = $client->directDebitService()->getStandaloneCredit(new StandaloneCredits(array(
                'id' => $_POST['paymentID'],
                'status' => "CANCELLED"
            )));
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        } else if ($standaloneCreditRequest == 'lookupStandaloneRequestACHMRN' || $standaloneCreditRequest == 'lookupStandaloneRequestEFTMRN' || $standaloneCreditRequest == 'lookupStandaloneRequestBACSMRN') {
            $standalone = $client->directDebitService()->getStandaloneCredits(new StandaloneCredits(array(
                'merchantRefNum' => $_POST['merchant_ref_num']
                    )), new Filter(array(
                'limit' => 15,
                'offset' => 0
            )));
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        } else if ($standaloneCreditRequest == 'moniter_service') {
            $standalone = $client->directDebitService()->monitor();
            echo "<pre>";
            print_r($standalone);
            echo "</pre>";
            die;
        }

        die('Payment successful! ID: ' . $standalone->id);
    } catch (Paysafe\PaysafeException $e) {
        echo '<pre>';
        var_dump($e->getMessage());
        if ($e->fieldErrors) {
            var_dump($e->fieldErrors);
        }
        if ($e->links) {
            var_dump($e->links);
        }
        echo '</pre>';
    } catch (\Paysafe\PaysafeException $e) {
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
if (isset($_POST['street'])) {
    $_POST['street'];
} else {
    echo "100 Queen Street West";
}
?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Street 2:
                        <input type="input" name="street2" value="<?php
if (isset($_POST['street2'])) {
    echo $_POST['street2'];
}
?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        City:
                        <input type="input" name="city" value="<?php
if (isset($_POST['city'])) {
    $_POST['city'];
} else {
    echo "Los Angeles";
}
?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        State/Province:
                        <input type="input" name="state" value="<?php
                        if (isset($_POST['state'])) {
                            echo $_POST['state'];
                        } else {
                            echo "CA";
                        }
                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Country:
                        <select name="country">
                            <option value="CA"<?php
                        if (isset($_POST['country']) && $_POST['country'] == 'CA') {
                            echo ' selected';
                        }
                        ?>>Canada</option>
                            <option value="US"<?php
                               if (isset($_POST['country']) && $_POST['country'] == 'US') {
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
                               if (isset($_POST['zip'])) {
                                   echo $_POST['zip'];
                               } else {
                                   echo "M5H 2N2";
                               }
                               ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Phone:
                        <input type="input" name="phone" value="<?php
                               if (isset($_POST['phone'])) {
                                   echo $_POST['phone'];
                               } else {
                                   echo "3102649010";
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
                            if (isset($_POST['firstName'])) {
                                $_POST['firstName'];
                            } else {
                                echo "John";
                            }
                            ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Last Name:
                        <input type="input" name="lastName" value="<?php
                        if (isset($_POST['lastName'])) {
                            $_POST['lastName'];
                        } else {
                            echo "Smith";
                        }
                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Email:
                        <input type="input" name="email" value="<?php
                        if (isset($_POST['email'])) {
                            echo $_POST['email'];
                        } else {
                            echo "Joe.Smith@canada.com";
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
                        if (isset($_POST['merchant_ref_num'])) {
                            echo $_POST['merchant_ref_num'];
                        } else {
                            echo uniqid(date('Ymd-'));
                        }
                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        Amount:
                        <input type="input" name="amount" value="<?php
                        if (isset($_POST['amount'])) {
                            echo $_POST['amount'];
                        } else {
                            echo "100";
                        }
                        ?>"/>
                    </label>
                </div>

                <div>
                    Payment token : <input type="text" name="paymentToken" id="paymentToken" value="<?php
                        if (isset($_POST['paymentToken'])) {
                            echo $_POST['paymentToken'];
                        } else {
                            echo "DmeucrpwVXlrLkw";
                        }
                        ?>"/>
                </div>
                <div>
                    Payment ID: <input type="text" name="paymentID" id="paymentID" value="<?php
                        if (isset($_POST['paymentID'])) {
                            echo $_POST['paymentID'];
                        } else {
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
                                    Do Standalone
                                    </thead>
                                    <tbody>
                                        <tr>
                       <td>
                        <input type="radio" name="standalonecredit" value="ach_Without_Token"/>
                       ACH
                     </td>
                     <td>
                      <input type="radio" name="standalonecredit" value="ach_With_Token"/>
                       ACH with Payment Token:
                    </td>
                    </tr>
                    <tr>

                    <td>
                    <input type="radio" name="standalonecredit" value="eft_Without_Token"/>
                       EFT
                   </td>

                   <td>
                       <input type="radio" name="standalonecredit" value="eft_With_Token"/>
                        EFT with Payment Token:
                   </td>
                    </tr>
                    <tr>

                   <td>
                       <input type="radio" name="standalonecredit" value="bacs_With_Token"/>
                        BACS with Payment Token:
                   </td>
                    </tr>
                                    </tbody>
                                </table>
                            </td><td>
                                <br>
                                <table border="1">
                                    <thead>
                                    Lookup Stanalone
                                    </thead>
                                    <tbody>
                                        <tr><td>
                                               <input type="radio" name="standalonecredit" value="lookupStandaloneRequestACH" /> ACH
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                                <input type="radio" name="standalonecredit" value="lookupStandaloneRequestEFT" />EFT
                                            </td>
                                        </tr>
                                        <tr><td>
                                                  <input type="radio" name="standalonecredit" value="lookupStandaloneRequestBACS" />BACS
                                                    </td></tr>
                                    </tbody>
                                </table>
                            </td><td>
                                <br>
                                <table border="1">
                                    <thead>
                                     Cancel Stanalone
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" name="standalonecredit" value="cancelStandaloneRequestACH" /> ACH
                                                </td>
                                        </tr>
                                        <tr><td>
                                                <input type="radio" name="standalonecredit" value="cancelStandaloneRequestEFT" /> EFT
                                            </td></tr>
                                        <tr><td>
                                                <input type="radio" name="standalonecredit" value="cancelStandaloneRequestBACS" />BACS
                                                </td></tr>
                                    </tbody></table>
</td><td>
                                <br>
                                <table border="1">
                                    <thead>
                                    Lookup Stanalone using merchant Ref
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" name="standalonecredit" value="lookupStandaloneRequestACHMRN" />ACH
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <input type="radio" name="standalonecredit" value="lookupStandaloneRequestEFTMRN" />EFT
                                            </td></tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="standalonecredit" value="lookupStandaloneRequestBACSMRN" />BACS
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