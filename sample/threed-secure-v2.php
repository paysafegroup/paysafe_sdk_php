<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\ThreeDSecureV2\Authentications;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {

		$auth = $client->threeDSecureV2Service()->authentications(new Authentications(array(
             'merchantRefNum' => $_POST['merchant_ref_num'],
             'amount' => $_POST['amount'],
             'currency' => $_POST['currency'],
            'deviceFingerprintingId' => $_POST['deviceFingerprinting_Id'],
			 'card' => array(
                 'holderName' => $_POST['holder_Name'],
				  'cardNum' => $_POST['card_number'],
				  'cardExpiry' => array(
						'month' => $_POST['card_exp_month'],
						'year' => $_POST['card_exp_year']
				 )
             ),
             'merchantUrl' =>$_POST['merchant_Url'],
             'authenticationPurpose' => $_POST['authentication_Purpose'],
			 'deviceChannel' => $_POST['device_Channel'],
        'messageCategory' => $_POST['message_Category']
        )));

		die('Payment successful! ID: ' . $auth->id);
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
		<title>Paysafe SDK - ThreeD Secure V2</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Card Details</legend>
				<div>
					<label>
						Holder Name:
						<input type="input" name="holder_Name" value="<?php
						if (isset($_POST['holder_Name'])) {
							echo $_POST['holder_Name'];
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						Card Number:
						<input type="input" name="card_number" value="<?php
						if (isset($_POST['card_number'])) {
							echo $_POST['card_number'];
                        }
                        else {
							echo "4111111111111111";
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						card Expiry Month:
                        <select name="card_exp_month">
							<?php
							$currentMonth = Date('n');
							for ($i = 1; $i <= 12; $i++) {
								echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_month']) && $_POST['card_exp_month'] == $i) || (!isset($_POST['card_exp_month']) && $i == $currentMonth)) ? ' selected' : '') . '>' . DateTime::createFromFormat('!m', $i)->format('F') . '</option>';
							}
							?>
						</select>
					</label>
				</div>
				<div>
                card Expiry Year:
                <select name="card_exp_year">
                <?php
							$currentYear = Date('Y');
							for ($i = $currentYear; $i < $currentYear + 5; $i++) {
								echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_year']) && $_POST['card_exp_year'] == $i) || (!isset($_POST['card_exp_year']) && $i == $currentYear)) ? ' selected' : '') . '>' . $i . '</option>';
							}
							?>
						</select>
					</label>
				</div>
			</fieldset>
			<fieldset>

				<legend>Order Details</legend>
				<div>
					<label>
						Merchant Ref Num:
						<input type="input" name="merchant_ref_num" value="<?php
						if (isset($_POST['merchant_ref_num'])) {
							echo $_POST['merchant_ref_num'];
						} else {
							echo uniqid(date(''));
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
							echo "99999999";
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						Currency :
						<input type="input" autocomplete="off" name="currency" value="<?php
						if (isset($_POST['currency'])) {
							echo $_POST['currency'];
						} else {
							echo "USD";
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						deviceFingerprintingId :
						<input type="input" autocomplete="off" name="deviceFingerprinting_Id" value="<?php
						if (isset($_POST['deviceFingerprinting_Id'])) {
							echo $_POST['deviceFingerprinting_Id'];
						} else {
							echo "3bf74a2a-8668-4f14-b2bf-fd8e07ae2100";
						}
						?>"/>
					</label>
				</div>
				<div>
                <label>
						Merchant URL  :
						<input type="input" autocomplete="off" name="merchant_Url" value="<?php
						if (isset($_POST['merchant_Url'])) {
							echo $_POST['merchant_Url'];
						} else {
							echo "https://mysite.com";
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						Authentication Purpose :
                        <input type="input" autocomplete="off" name="authentication_Purpose" value="<?php
						if (isset($_POST['authentication_Purpose'])) {
							echo $_POST['authentication_Purpose'];
						} else {
							echo "PAYMENT_TRANSACTION";
						}
						?>"/>
					</label>
                </div>
                <div>
					<label>
						 Device Channel :
                        <input type="input" autocomplete="off" name="device_Channel" value="<?php
						if (isset($_POST['device_Channel'])) {
							echo $_POST['device_Channel'];
						} else {
							echo "BROWSER";
						}
						?>"/>
					</label>
                </div>
                <div>
					<label>
						Authentication Purpose :
                        <input type="input" autocomplete="off" name="message_Category" value="<?php
						if (isset($_POST['message_Category'])) {
							echo $_POST['message_Category'];
						} else {
							echo "PAYMENT";
						}
						?>"/>
					</label>
				</div>
			</fieldset>
			<br>
			<input type="submit" />
		</form>
	</body>
</html>