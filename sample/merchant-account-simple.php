<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, null);
	try {

		$auth = $client->merchantAccountService()->createMerchantAccount(new \Paysafe\AccountManagement\MerchantAccount(array(
			 'merchantId' => $_POST['merchantId'],
			 'name' => $_POST['name'],
			 'currency' => $_POST['currency'],
			 'region' => $_POST['region'],
			 'legalEntity' => $_POST['legalEntity'],
			 'productCode' => $_POST['productCode'],
            )));


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
		var_dump($e->getMessage());
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Paysafe SDK - Creation Merchant Account Simple</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Create Merchant Account</legend>
				<div>
					<label>
                       MerchantId:
						<input type="input" name="merchantId" value="<?php
						if (isset($_POST['merchantId'])) {
							echo $_POST['merchantId'];
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
                            echo "Popeye's Gym";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        Currency:
						<input type="input" name="currency" value="<?php
						if (isset($_POST['currency'])) {
							echo $_POST['currency'];
						} else {
                            echo "CAD";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        Region:
						<input type="input" name="region" value="<?php
						if (isset($_POST['region'])) {
							echo $_POST['region'];
						} else {
                            echo "CA";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        LegalEntity:
						<input type="input" name="legalEntity" value="<?php
						if (isset($_POST['legalEntity'])) {
							echo $_POST['legalEntity'];
						} else {
                            echo "Popeye's Inc";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        ProductCode:
						<input type="input" name="productCode" value="<?php
						if (isset($_POST['productCode'])) {
							echo $_POST['productCode'];
						} else {
                            echo "GOLD";
                        }
						?>"/>
					</label>
				</div>
			</fieldset>
			<input type="submit" />
		</form>
	</body>
</html>