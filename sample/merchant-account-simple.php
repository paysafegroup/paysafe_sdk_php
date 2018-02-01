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
			 'category' => $_POST['category'],
			 'phone' => $_POST['phone'],
			 'yearlyVolumeRange' => $_POST['yearlyVolumeRange'],
			 'averageTransactionAmount' => $_POST['averageTransactionAmount'],
			 'merchantDescriptor' => [
			         'dynamicDescriptor' => $_POST['dynamicDescriptor'],
			         'phone' => $_POST['phone']
             ],
			 'caAccountDetails' => [
			         'type' => $_POST['type'],
			         'description' => $_POST['description'],
			         'isCardPresent' => false,
			         'hasPreviouslyProcessedCards' => true,
			         'federalTaxNumber' => $_POST['federalTaxNumber'],
             ],
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
                <div>
					<label>
                        category:
						<input type="input" name="category" value="<?php
						if (isset($_POST['category'])) {
							echo $_POST['category'];
						} else {
                            echo "RECREATION";
                        }
						?>"/>
					</label>
				</div>
                <div>
					<label>
                        phone:
						<input type="input" name="phone" value="<?php
						if (isset($_POST['phone'])) {
							echo $_POST['phone'];
						} else {
                            echo "555 888-9999";
                        }
						?>"/>
					</label>
				</div>
                <div>
					<label>
                        yearlyVolumeRange:
						<input type="input" name="yearlyVolumeRange" value="<?php
						if (isset($_POST['yearlyVolumeRange'])) {
							echo $_POST['yearlyVolumeRange'];
						} else {
                            echo "MEDIUM";
                        }
						?>"/>
					</label>
				</div>
                <div>
					<label>
                        averageTransactionAmount:
						<input type="input" name="averageTransactionAmount" value="<?php
						if (isset($_POST['averageTransactionAmount'])) {
							echo $_POST['averageTransactionAmount'];
						} else {
                            echo "9999";
                        }
						?>"/>
					</label>
				</div>
			</fieldset>
            <fieldset>
                <legend>merchantDescriptor</legend>
                <div>
                    <label>
                        dynamicDescriptor:
                        <input type="input" name="dynamicDescriptor" value="<?php
                        if (isset($_POST['dynamicDescriptor'])) {
                            echo $_POST['dynamicDescriptor'];
                        } else {
                            echo "megagym";
                        }
                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        phone:
                        <input type="input" name="phone" value="<?php
                        if (isset($_POST['phone'])) {
                            echo $_POST['phone'];
                        } else {
                            echo "555 888-9999";
                        }
                        ?>"/>
                    </label>
                </div>
            </fieldset>
            <fieldset>
                <legend>caAccountDetails</legend>
                <div>
                    <label>
                        type:
                        <input type="input" name="type" value="<?php
                        if (isset($_POST['type'])) {
                            echo $_POST['type'];
                        } else {
                            echo "CORP";
                        }
                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        description:
                        <input type="input" name="description" value="<?php
                        if (isset($_POST['description'])) {
                            echo $_POST['description'];
                        } else {
                            echo "Fitness";
                        }
                        ?>"/>
                    </label>
                </div>
                <div>
                    <label>
                        federalTaxNumber:
                        <input type="input" name="federalTaxNumber" value="<?php
                        if (isset($_POST['federalTaxNumber'])) {
                            echo $_POST['federalTaxNumber'];
                        } else {
                            echo "987654321";
                        }
                        ?>"/>
                    </label>
                </div>
            </fieldset>
			<input type="submit" />
		</form>
	</body>
</html>