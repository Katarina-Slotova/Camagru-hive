<?php

session_start();

// Connect to database in order to create an account
require_once('connection.php');

function generate_activation_code(): string
{
	return bin2hex(random_bytes(16));
}

// Check if user clicked signup_btn
if(isset($_POST['signup_btn']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_conf'])){
	// Get the data about the user who wants to sign up
	$username = htmlspecialchars($_POST['username']);
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];
	$activation_code = generate_activation_code();
	$expiry = 1 * 24 * 60 * 60;
	$activation_expiry = date('Y-m-d H:i:s',  time() + $expiry);

	function send_activation_email(string $email, string $activation_code): void
	{	
		$APP_URL = 'http://localhost:8080';
		$SENDER_EMAIL_ADDRESS = 'no-reply@email.com';
		// create the activation link
		$activation_link = $APP_URL . "/camagru/src/auth.php?email=$email&activation_code=$activation_code";

		// set email subject & body
		$subject = 'Please activate your account';
		$message = "Hi, please click the following link to activate your account: $activation_link";
		// email header
		$header = "From:" . $SENDER_EMAIL_ADDRESS;

		// send the email
		mail($email, $subject, nl2br($message), $header);
	}

	// Check if the passwords match and are of proper length
	if($password !== $password_conf){
		header('location: signup.php?error_message=Passwords do not match');
		exit;
	}

	if(strlen($password) < 8){
		header('location: signup.php?error_message=Password is shorter than 8 characters');
		exit;
	}

	if(strlen($password) > 20){
		header('location: signup.php?error_message=Password too long, maximum 20 characters allowed.');
		exit;
	}

	// Check the length of username
	if(strlen($username) > 30){
		header('location: signup.php?error_message=Username too long, maximum 30 characters allowed.');
		exit;
	}

	// Check validity of email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('location: signup.php?error_message=Invalid email format.');
		exit;
	  }

	//  Check if user with this email address has already signed up
	try {
		// Connect to database and create a prepared statement
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
		// Bind parameters for markers
 		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->bindParam(2, $username, PDO::PARAM_STR);
		// Execute query
		$stmt->execute();

		if($stmt->fetch(PDO::FETCH_ASSOC)){
			header('location: signup.php?error_message=this user already exists');
			exit;
		}else{
			try {
				$conn = connect_db();
				$stmt = $conn->prepare("INSERT INTO users (username, email, password, activation_code) VALUES (?, ?, ?, ?)");

				// If user account created, return the user information to frontend
				if($stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $activation_code])){
					send_activation_email($email, $activation_code);
					header("location: login.php?ok_message=Verify your account by clicking the verification link sent to your mailbox.");
				}else{
					header('location: signup.php?error_message=error occured');
					exit;
				}
			} catch (PDOException $error) {
				echo $error->getMessage(); 
				exit;
			}
		}
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
}else{
	header('location: signup.php?error_message=error occured');
	exit;
}

?>