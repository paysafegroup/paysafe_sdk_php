<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {
	    if(isset($_POST['street'])){
            $result = $client->merchantAccountService()->createMerchantAccountBusinessOwnerAddress(new \Paysafe\AccountManagement\MerchantAccountBusinessOwnerAddress(array(
                'businnessOwnerId' => $_POST['businnessOwnerId'],
                'street' => $_POST['street'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'country' => $_POST['country'],
                'zip' => $_POST['zip'],
                'yearsAtAddress' => $_POST['yearsAtAddress'],
            )));
        }else{
            $result = $client->merchantAccountService()->createMerchantAccountBusinessOwnerAddressPrevious(new \Paysafe\AccountManagement\MerchantAccountBusinessOwnerAddress(array(
                'businnessOwnerId' => $_POST['businnessOwnerId_previous'],
                'street' => $_POST['street_previous'],
                'city' => $_POST['city_previous'],
                'state' => $_POST['state_previous'],
                'country' => $_POST['country_previous'],
                'zip' => $_POST['zip_previous'],
                'yearsAtAddress' => $_POST['yearsAtAddress_previous'],
            )));
        }

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
                street2:
                <input type="input" name="street2" value="<?php
                if (isset($_POST['street2'])) {
                    echo $_POST['street2'];
                } else {
                    echo "Apt. 245";
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
        <div>
            <label>
                yearsAtAddress:
                <input type="input" name="yearsAtAddress" value="<?php
                if (isset($_POST['yearsAtAddress'])) {
                    echo $_POST['yearsAtAddress'];
                } else {
                    echo "2";
                }
                ?>"/>
            </label>
        </div>
    </fieldset>
    <input type="submit" />
</form>
<form method="post">
    <fieldset>
        <legend>Creation Business Address (previous)</legend>
        <div>
            <label>
                businnessOwnerId:
                <input type="input" name="businnessOwnerId_previous" value="<?php
                if (isset($_POST['businnessOwnerId_previous'])) {
                    echo $_POST['businnessOwnerId_previous'];
                } else {
                    echo "";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                street:
                <input type="input" name="street_previous" value="<?php
                if (isset($_POST['street_previous'])) {
                    echo $_POST['street_previous'];
                } else {
                    echo "101 Queen Street West";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                street2:
                <input type="input" name="street2_previous" value="<?php
                if (isset($_POST['street2_previous'])) {
                    echo $_POST['street2_previous'];
                } else {
                    echo "Apt. 246";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                city:
                <input type="input" name="city_previous" value="<?php
                if (isset($_POST['city_previous'])) {
                    echo $_POST['city_previous'];
                } else {
                    echo "Toronto";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                state:
                <input type="input" name="state_previous" value="<?php
                if (isset($_POST['state_previous'])) {
                    echo $_POST['state_previous'];
                } else {
                    echo "ON";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                country:
                <input type="input" name="country_previous" value="<?php
                if (isset($_POST['country_previous'])) {
                    echo $_POST['country_previous'];
                } else {
                    echo "CA";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                zip:
                <input type="input" name="zip_previous" value="<?php
                if (isset($_POST['zip_previous'])) {
                    echo $_POST['zip_previous'];
                } else {
                    echo "M5H 2N2";
                }
                ?>"/>
            </label>
        </div>
        <div>
            <label>
                yearsAtAddress:
                <input type="input" name="yearsAtAddress_previous" value="<?php
                if (isset($_POST['yearsAtAddress_previous'])) {
                    echo $_POST['yearsAtAddress_previous'];
                } else {
                    echo "2";
                }
                ?>"/>
            </label>
        </div>
    </fieldset>
    <input type="submit" />
</form>
</body>
</html>