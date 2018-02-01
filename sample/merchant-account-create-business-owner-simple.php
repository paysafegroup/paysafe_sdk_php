<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {

		$auth = $client->merchantAccountService()->createMerchantAccountBusinessOwner(new \Paysafe\AccountManagement\MerchantAccountBusinessOwner(array(
            'firstName' => $_POST['firstName'],
            'middleName' => $_POST['cmiddleNameity'],
            'lastName' => $_POST['lastName'],
            'jobTitle' => $_POST['jobTitle'],
            'phone' => $_POST['phone'],
            'ssn' => $_POST['ssn'],
            'email' => $_POST['email'],
            'dateOfBirth' => array(
                'day' => $_POST['day'],
                'month' => $_POST['month'],
                'year' => $_POST['year']
            ),
            'nationality' => $_POST['nationality'],
            'customerIp' => $_POST['customerIp'],
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
		<title>Paysafe SDK - Creation Business Owner</title>
	</head>
	<body>
		<form method="post">
			<fieldset>
				<legend>Creation Business Owner</legend>
				<div>
					<label>
                        firstName:
						<input type="input" name="firstName" value="<?php
						if (isset($_POST['firstName'])) {
							echo $_POST['firstName'];
						} else {
                            echo "Joe";
                        }
						?>"/>
					</label>
                </div>
				<div>
					<label>
                        middleName:
						<input type="input" name="middleName" value="<?php
						if (isset($_POST['middleName'])) {
							echo $_POST['middleName'];
						} else {
                            echo "Xavier";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        lastName:
						<input type="input" name="lastName" value="<?php
						if (isset($_POST['lastName'])) {
							echo $_POST['lastName'];
						} else {
                            echo "Smith";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        jobTitle:
						<input type="input" name="jobTitle" value="<?php
						if (isset($_POST['jobTitle'])) {
							echo $_POST['jobTitle'];
						} else {
                            echo "CEO";
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
                            echo "5559998888";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        ssn:
						<input type="input" name="ssn" value="<?php
						if (isset($_POST['ssn'])) {
							echo $_POST['ssn'];
						} else {
                            echo "999888777";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        email:
						<input type="input" name="email" value="<?php
						if (isset($_POST['email'])) {
							echo $_POST['email'];
						} else {
                            echo "jamesr@email.com";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        day:
						<input type="input" name="day" value="<?php
						if (isset($_POST['day'])) {
							echo $_POST['day'];
						} else {
                            echo "19";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        month:
						<input type="input" name="month" value="<?php
						if (isset($_POST['month'])) {
							echo $_POST['month'];
						} else {
                            echo "8";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        year:
						<input type="input" name="year" value="<?php
						if (isset($_POST['year'])) {
							echo $_POST['year'];
						} else {
                            echo "1976";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        nationality:
						<input type="input" name="nationality" value="<?php
						if (isset($_POST['nationality'])) {
							echo $_POST['nationality'];
						} else {
                            echo "CA";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        customerIp:
						<input type="input" name="customerIp" value="<?php
						if (isset($_POST['customerIp'])) {
							echo $_POST['customerIp'];
						} else {
                            echo "127.0.0.1";
                        }
						?>"/>
					</label>
                </div>
			</fieldset>
			<input type="submit" />
		</form>
	</body>
</html>