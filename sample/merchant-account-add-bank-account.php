<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {
		$auth = $client->merchantAccountService()->addMerchantEftBankAccount(new \Paysafe\AccountManagement\MerchantEftBankAccount(array(
			 'accountNumber' => $_POST['accountNumber'],
			 'transitNumber' => $_POST['transitNumber'],
			 'institutionId' => $_POST['institutionId'],
			 'merchantId' => $_POST['merchantId'],
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
		<title>Paysafe SDK - Creation Merchant Banka Account</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Creation Merchant Banka Account (EFT)</legend>
				<div>
					<label>
                        merchantId:
						<input type="input" name="merchantId" value="<?php
						if (isset($_POST['merchantId'])) {
							echo $_POST['merchantId'];
						} else {
                            echo "";
                        }
						?>"/>
					</label>
                </div>
				<div>
					<label>
                        accountNumber:
						<input type="input" name="accountNumber" value="<?php
						if (isset($_POST['accountNumber'])) {
							echo $_POST['accountNumber'];
						} else {
                            echo "5807560412853954";
                        }
						?>"/>
					</label>
                </div>
				<div>
					<label>
                        transitNumber:
						<input type="input" name="transitNumber" value="<?php
						if (isset($_POST['transitNumber'])) {
							echo $_POST['transitNumber'];
						} else {
                            echo "52487";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        institutionId:
						<input type="input" name="institutionId" value="<?php
						if (isset($_POST['institutionId'])) {
							echo $_POST['institutionId'];
						} else {
                            echo "052";
                        }
						?>"/>
					</label>
                </div>
			</fieldset>
			<input type="submit" />
		</form>
	</body>
</html>