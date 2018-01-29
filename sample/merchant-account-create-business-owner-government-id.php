<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {
		$result = $client->merchantAccountService()->addBusinessOwnerIdentityDocument(new \Paysafe\AccountManagement\MerchantAccountBusinessOwnerIdentityDocument(array(
            'businnessOwnerId' => $_POST['businnessOwnerId'],
            'number' => $_POST['number'],
            'province' => $_POST['province'],

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
    <title>Paysafe SDK - Creation Business Address</title>
</head>
<body>
<form method="post">
    <fieldset>
        <legend>Creation Business Address</legend>
        <div>
            <label>
                businnessOwnerId:
                <input type="input" name="businnessOwnerId" value="<?php
                if (isset($_POST['businnessOwnerId'])) {
                    echo $_POST['businnessOwnerId'];
                } else {
                    echo "";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                number:
                <input type="input" name="number" value="<?php
                if (isset($_POST['number'])) {
                    echo $_POST['number'];
                } else {
                    echo "DL987654321";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                province:
                <input type="input" name="province" value="<?php
                if (isset($_POST['province'])) {
                    echo $_POST['province'];
                } else {
                    echo "ON";
                }
                ?>"/>
            </label>
        </div>
    </fieldset>
    <input type="submit" />
</form>
</body>
</html>