<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
if ($_POST) {
	try {
		$result = $client->merchantAccountService()->acceptTermsAndConditions(new \Paysafe\AccountManagement\TermsAndConditions(array(
			 'version' => $_POST['version']
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
		<title>Paysafe SDK - Accept Our Terms and Conditions</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Accept Our Terms and Conditions</legend>
                <input type="input" name="version" value="1.0">
			</fieldset>
			<input type="submit" />
		</form>
        <div>
            <a href="<?php
            echo'https://'.$paysafeApiKeyId.':'.$paysafeApiKeySecret.'@api.test.paysafe.com/accountmanagement/v1/accounts/'.$paysafeAccountNumber.'/termsandconditions';
            ?>" >
                Terms and Conditions
            </a>

        </div>
    </body>
</html>