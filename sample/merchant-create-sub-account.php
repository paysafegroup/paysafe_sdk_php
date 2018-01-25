<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {

		$auth = $client->merchantAccountService()->createMerchantSubAccount(new \Paysafe\AccountManagement\MerchantSubAccount(array(
			 'name' => $_POST['name'],
			 'eftId' => $_POST['eftId'],
            )));

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
		<title>Paysafe SDK - Creation Merchant Account</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Create Merchant Account</legend>
				<div>
					<label>
                        eftId:
						<input type="input" name="eftId" value="<?php
						if (isset($_POST['eftId'])) {
							echo $_POST['eftId'];
						}
						?>"/>
					</label>
                </div>
				<div>
					<label>
                        Name:
						<input type="input" name="name" value="<?php
						if (isset($_POST['name'])) {
							echo $_POST['name'];
						} else {
                            echo "Settlement Account";
                        }
						?>"/>
					</label>
                </div>
            </fieldset>
			<input type="submit" />
		</form>
	</body>
</html>