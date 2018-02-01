<?php
require_once('config.php');

use Paysafe\PaysafeApiClient;
use Paysafe\Environment;

if ($_POST) {
	$client = new PaysafeApiClient($paysafeApiKeyId, $paysafeApiKeySecret, Environment::TEST, $paysafeAccountNumber);
	try {
        $result = $client->merchantAccountService()->createNewUser(new \Paysafe\AccountManagement\User(array(
			 'userName' => $_POST['userName'],
			 'password' => $_POST['password'],
			 'email' => $_POST['email'],
			 'recoveryQuestion' => array(
                 'questionId' => intval($_POST['questionId']),
                 'answer' => $_POST['answer']
             )
        )));
        echo'<pre>';

		die('successful! ');
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
		<title>Paysafe SDK - Creation New User</title>
	</head>
	<body>


		<form method="post">
			<fieldset>
				<legend>Creation New User</legend>
				<div>
					<label>
                        userName:
						<input type="input" name="userName" value="<?php
						if (isset($_POST['userName'])) {
							echo $_POST['userName'];
						} else {
                            echo "john_smith_2";
                        }
						?>"/>
					</label>
                </div>
				<div>
					<label>
                        password:
						<input type="input" name="password" value="<?php
						if (isset($_POST['password'])) {
							echo $_POST['password'];
						} else {
                            echo "Password123";
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
                            echo "johnsmith@gmail.com";
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        questionId:
						<input type="input" name="questionId" value="<?php
						if (isset($_POST['questionId'])) {
							echo $_POST['questionId'];
						} else {
                            echo 1;
                        }
						?>"/>
					</label>
                </div>
                <div>
					<label>
                        answer:
						<input type="input" name="answer" value="<?php
						if (isset($_POST['answer'])) {
							echo $_POST['answer'];
						} else {
                            echo "John";
                        }
						?>"/>
					</label>
                </div>
			</fieldset>
			<input type="submit" />
		</form>
	</body>
</html>