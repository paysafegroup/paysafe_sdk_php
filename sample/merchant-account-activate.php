<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {
		$result = $client->merchantAccountService()->activateMerchantAccount(new \Paysafe\AccountManagement\MerchantAccount(array(
            )));
		die('successful! ID: ' . $result->id);
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
		<title>Paysafe SDK - Activate Merchant Account</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Activate Merchant Account</legend>
				<div>
					<label>
						<input type="hidden" name="test" value=""/>
					</label>
                </div>
			</fieldset>
			<input type="submit" />
		</form>
	</body>
</html>