<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {

		$auth = $client->merchantAccountService()->createMerchantAccountAddress(new \Paysafe\AccountManagement\MerchantAccountAddress(array(
			 'street' => $_POST['street'],
			 'city' => $_POST['city'],
			 'state' => $_POST['state'],
			 'country' => $_POST['country'],
			 'zip' => $_POST['zip'],
            )));


               // var_dump($auth);die;
		die('successful! ID: ' . $auth->id);
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
		var_dump($e->getMessage());
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Paysafe SDK - Creation Merchant Account Address</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Creation Merchant Account Address</legend>
				<div>
					<label>
                        street:
						<input type="input" name="street" value="<?php
						if (isset($_POST['street'])) {
							echo $_POST['street'];
						} else {
                            echo "100 Queen Street West";
                        }
						?>"/>
					</label>
                </div>
				<div>
					<label>
                        city:
						<input type="input" name="city" value="<?php
						if (isset($_POST['city'])) {
							echo $_POST['city'];
						} else {
                            echo "Toronto";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        state:
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
                        country:
						<input type="input" name="country" value="<?php
						if (isset($_POST['country'])) {
							echo $_POST['country'];
						} else {
                            echo "CA";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        zip:
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
			<input type="submit" />
		</form>
	</body>
</html>