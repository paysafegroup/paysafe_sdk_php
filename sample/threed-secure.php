<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\ThreeDSecure\ThreeDEnrollment;
use Paysafe\ThreeDSecure\Authentications;

if ($_POST) {
    try {
        if ($_POST['threed_secure']) {
            $threed_secure = $_POST['threed_secure'];
        }

        if ($threed_secure == 'submit_enroll' || $threed_secure == 'lookup_enroll' || $threed_secure == "authentication_request" || $threed_secure == 'lookup_authentication' || $threed_secure == 'lookup_authentication_enroll' || $threed_secure == "moniter_service") {
            $client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
        }
        if ($threed_secure == 'submit_enroll') {
            $threedsecure = $client->threeDSecureService()->enrollmentChecks(new ThreeDEnrollment(array(
                'merchantRefNum' => $_POST['merchant_ref_num'],
                'amount' => "100",
                'currency' => "USD",
                'card' => array(
                    'cardNum' => $_POST['card_number'],
                    'cardExpiry' => array(
                        'month' => $_POST['card_exp_month'],
                        'year' => $_POST['card_exp_year']
                    )
                ),
                'customerIp' => "10.10.18.115",
                'userAgent' => "36.0.1985.125",
                'acceptHeader' => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
                'merchantUrl' => "https://www.merchant.com"
            )));
            echo "<pre>";
            print_r($threedsecure);
            echo "</pre>";
            die;
        } else if ($threed_secure == 'lookup_enroll') {
            $threedsecure = $client->threeDSecureService()->getenrollmentChecks(new ThreeDEnrollment(array(
                'id' => $_POST['enrollment_id']
            )));
            echo "<pre>";
            print_r($threedsecure);
            echo "</pre>";
            die;
        } else if ($threed_secure == 'authentication_request') {
            $threedsecure = $client->threeDSecureService()->authentications(new Authentications(array(
                'merchantRefNum' => $_POST['merchant_ref_num'],
                'paRes'=>$_POST['paRes'],
                'id' => $_POST['enrollment_id']
            )));
            echo "<pre>";
            print_r($threedsecure);
            echo "</pre>";
            die;
        } else if ($threed_secure == 'lookup_authentication') {
            $threedsecure = $client->threeDSecureService()->getAuthentication(new Authentications(array(
                'id' => $_POST['authentication_id']
            )));
            echo "<pre>";
            print_r($threedsecure);
            echo "</pre>";
            die;
        } else if ($threed_secure == 'lookup_authentication_enroll') {
            $enrollmentlookup = FALSE;
            if (isset($_POST['enrollmentlookup']) && $_POST['enrollmentlookup'] == 'on') {
                $enrollmentlookup = "enrollmentchecks";
            }
            $threedsecure = $client->threeDSecureService()->getAuthentications(new Authentications(array(
                'id' => $_POST['authentication_id'])), $enrollmentlookup
            );
            echo "<pre>";
            print_r($threedsecure);
            echo "</pre>";
            die;
        } else if ($threed_secure == 'moniter_service') {
            $threedsecure = $client->threeDSecureService()->monitor();
            echo "<pre>";
            print_r($threedsecure);
            echo "</pre>";
            die;
        }
        die('Payment successful! ID: ' . $threedsecure->id);
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
    } catch (Paysafe\PaysafeException $e) {
        //for debug only, these errors should be properly handled before production
        var_dump($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paysafe SDK - CardPayment Simple</title>
    </head>
    <body>
        <form method="post">

			<fieldset>
				<legend>Order Details</legend>
				<table>
                                <tr>
                                    <td>

                                        Merchant Ref Num: </td>
				    <td>		<input type="input" name="merchant_ref_num" value="<?php
						if (isset($_POST['merchant_ref_num'])) {
							echo $_POST['merchant_ref_num'];
						} else {
							echo "merchantrf".uniqid(date('Ymd-'));
						}
						?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Amount: </td>
                                        <td>
						<input type="input" name="amount" value="<?php
						if (isset($_POST['amount'])) {
							echo $_POST['amount'];
						} else {
							echo "100.00";
						}
						?>"/>
					</td>
                                </tr>
                                <tr>
                                    <td>Card Number: </td>
                                    <td>
						<input type="input" autocomplete="off" name="card_number" value="<?php
						if (isset($_POST['card_number'])) {
							echo $_POST['card_number'];
						} else {
							echo "4107857757053670";
						}
						?>"/>
                                    </td>
                                </tr>
                                <tr> <td>CVV:</td>
                                    <td>
						<input type="input" autocomplete="off" name="card_cvv" value="<?php
						if (isset($_POST['card_cvv'])) {
							echo $_POST['card_cvv'];
						} else {
							echo "123";
						}
						?>"/>
				 </td>
                                </tr>
                                <tr>
                                    <td>Card Expiry: </td>
                                    <td>
						<select name="card_exp_month">
							<?php
							$currentMonth = Date('n');
							for ($i = 1; $i <= 12; $i++) {
								echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_month']) && $_POST['card_exp_month'] == $i) || (!isset($_POST['card_exp_month']) && $i == $currentMonth)) ? ' selected' : '') . '>' . DateTime::createFromFormat('!m', $i)->format('F') . '</option>';
							}
							?>
						</select>
				</td>
                                </tr>
                                <tr>
                                    <td>Card Expiry: </td>
                                    <td>
						<select name="card_exp_year">
							<?php
							$currentYear = Date('Y');
							for ($i = $currentYear; $i < $currentYear + 5; $i++) {
								echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_year']) && $_POST['card_exp_year'] == $i) || (!isset($_POST['card_exp_year']) && $i == $currentYear)) ? ' selected' : '') . '>' . $i . '</option>';
							}
							?>
						</select>
                              	 </td>
                                  </tr>
                                  <tr><td> Enrollment ID</td>
                                      <td>
						<input type="input" autocomplete="off" name="enrollment_id" value="<?php
						if (isset($_POST['enrollment_id'])) {
							echo $_POST['enrollment_id'];
						}
						?>"/>
                                                </td>
                                  </tr>
                                     <tr>
                             <td> paRes</td>
                             <td><input type="input" autocomplete="off" name="paRes" value="<?php
						if (isset($_POST['paRes'])) {
							echo $_POST['paRes'];
						}
						?>"/>
				</td>
                            </tr>
                                </table>
			</fieldset>
                    <fieldset>
                        <h4>Enrollment Lookups</h4>
                         <label>
                               <input type="radio" name="threed_secure" value="submit_enroll" />Submit an Enrollment Lookup Request
                           </label>


                        <br/>
                           <label>
                               <input type="radio" name="threed_secure" value="lookup_enroll" />Look up Enrollment Lookup Using an ID
                           </label>
                    </fieldset>

                      <fieldset>
                        <h4>Authentications</h4>
                        <table>
                            <tr>
                                <td> AUTHENTICATION ID</td>
                                <td><input type="input" autocomplete="off" name="authentication_id" value="<?php
						if (isset($_POST['authentication_id'])) {
							echo $_POST['authentication_id'];
						}
						?>"/>
                                </td>
                            </tr>

                        </table>



                            <label>
                                <input type="checkbox"  name="enrollmentlookup" checked/>enrollment in lookup
                            </label>
                        <a href="../../paysafe/trunk/Source Code/PHP SDK/sample/threed-secure.php"></a>

                            <label>
                               <input type="radio" name="threed_secure" value="authentication_request" />Submit an Authentications Request
                            </label><br/>


                            <label>
                               <input type="radio" name="threed_secure" value="lookup_authentication" />Look Up an Authentication Using an ID
                            </label><br/>
                             <label>
                               <input type="radio" name="threed_secure" value="lookup_authentication_enroll" />Look Up an Authentication and Corresponding Enrollment Check
                            </label>
                            <label>
                                <input type="radio" name="threed_secure" value="moniter_service" />Monitering Service.
                            </label>
                    </fieldset>
                	<input type="submit" />
		</form>
    </body>
</html>