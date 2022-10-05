<?php
	require_once('connection.php');

	function send_reset_email(string $email, string $reset_code): void
	{	
		$APP_URL = 'http://localhost:8000';
		$SENDER_EMAIL_ADDRESS = 'no-reply@email.com';
		// create the reset link
		$activation_link = $APP_URL . "/set_new_password.php?email=$email&activation_code=$reset_code";

		// set email subject & body
		$subject = 'Reset your password';
		$message = <<<MESSAGE
				Hi,
				Please click the following link to reset your password:
				$activation_link
				MESSAGE;
		// email header
		$header = "From:" . $SENDER_EMAIL_ADDRESS;

		// send the email
		mail($email, $subject, nl2br($message), $header);
	}

	function generate_activation_code(): string
	{
		return bin2hex(random_bytes(16));
	}

	if(isset($_POST['reset_pwd_btn']))
	{
		$email = $_POST['email'];
		$reset_code = generate_activation_code();
		try
		{
			$conn = connect_db();
			$stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
			$stmt->bindParam(1, $email, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->rowCount()){
				send_reset_email($email, $reset_code);
				header('location: login.php?ok_message=Reinitialisation email was sent to your mailbox.');
				require_once('create_new_password.php');
			} else {
				header('location: reset_password.php?error_message=No such email found.');
			}
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;

	} else {
		header('location: reset_password.php?error_message=Error occured.');
	}
?>