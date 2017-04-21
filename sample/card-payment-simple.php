<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {

		$auth = $client->cardPaymentService()->authorize(new Authorization(array(
			 'merchantRefNum' => $_POST['merchant_ref_num'],
			 'amount' => $_POST['amount'] * $currencyBaseUnitsMultiplier,
			 'settleWithAuth' => true,
			 'card' => array(
				  'cardNum' => $_POST['card_number'],
				  'cvv' => $_POST['card_cvv'],
				  'cardExpiry' => array(
						'month' => $_POST['card_exp_month'],
						'year' => $_POST['card_exp_year']
				 )
			 ),
			 'billingDetails' => array(
				  'street' => $_POST['street'],
				  'city' => $_POST['city'],
				  'state' => $_POST['state'],
				  'country' => $_POST['country'],
				  'zip' => $_POST['zip']
		))));
               // var_dump($auth);die;
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
		<title>Paysafe SDK - CardPayment Simple</title>
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
							echo $_POST['street'];
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						City:
						<input type="input" name="city" value="<?php
						if (isset($_POST['city'])) {
							echo $_POST['city'];
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
							echo "100.00";
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						Card Number:
						<input type="input" autocomplete="off" name="card_number" value="<?php
						if (isset($_POST['card_number'])) {
							echo $_POST['card_number'];
						} else {
							echo "4444333322221111";
						}
						?>"/>
					</label>
				</div>
				<div>
					<label>
						CVV:
						<input type="input" autocomplete="off" name="card_cvv" value="<?php
						if (isset($_POST['card_cvv'])) {
							echo $_POST['card_cvv'];
						} else {
							echo "123";
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
							for ($i = 1; $i <= 12; $i++) {
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
							for ($i = $currentYear; $i < $currentYear + 5; $i++) {
								echo '<option value="' . $i . '"' . (((isset($_POST['card_exp_year']) && $_POST['card_exp_year'] == $i) || (!isset($_POST['card_exp_year']) && $i == $currentYear)) ? ' selected' : '') . '>' . $i . '</option>';
							}
							?>
						</select>
					</label>
				</div>
			</fieldset>
			<input type="submit" />
		</form>
	</body>
</html>