<?php

session_start();

// Connect to database in order to create an account
require_once('connection.php');

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

// Check if user clicked signup_btn
if(isset($_POST['signup_btn'])){
	// Get the data about the user who wants to sign up
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];
	$activation_code = generate_activation_code();
	$expiry = 1 * 24 * 60 * 60;
	$activation_expiry = date('Y-m-d H:i:s',  time() + $expiry);

	function send_activation_email(string $email, string $activation_code): void
	{	
		$APP_URL = 'http://localhost:8000';
		$SENDER_EMAIL_ADDRESS = 'no-reply@email.com';
		// create the activation link
		$activation_link = $APP_URL . "/auth.php?email=$email&activation_code=$activation_code";

		// set email subject & body
		$subject = 'Please activate your account';
		$message = <<<MESSAGE
				Hi,
				Please click the following link to activate your account:
				$activation_link
				MESSAGE;
		// email header
		$header = "From:" . $SENDER_EMAIL_ADDRESS;

		// send the email
		mail($email, $subject, nl2br($message), $header);
	}

	function delete_user_by_id(int $id, int $active = 0)
	{
		$conn = connect_db();
		$sql = 'DELETE FROM users
				WHERE id =:id and active=:active';
		$statement = $conn()->prepare($sql);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->bindValue(':active', $active, PDO::PARAM_INT);

		return $statement->execute();
	}

/* 	function find_unverified_user(string $activation_code, string $email)
	{
		$conn = connect_db();
		$sql = 'SELECT id, activation_code, activation_expiry < now() as expired
				FROM users
				WHERE active = 0 AND email=:email';

		$statement = $conn->prepare($sql);
		$statement->bindValue(':email', $email);
		$statement->execute();

		$user = $statement->fetch(PDO::FETCH_ASSOC);

		if ($user) {
			// already expired, delete the in active user with expired activation code
			if ((int)$user['expired'] === 1) {
				delete_user_by_id($user['id']);
				return null;
			}
			// verify the password
			if (password_verify($activation_code, $user['activation_code'])) {
				return $user;
			}
		}

		return null;
	}	 */

	// Check if the passwords match
	if($password !== $password_conf){
		header('location: signup.php?error_message=passwords do not match');
		exit;
	}

	if(strlen($password) < 8){
		header('location: signup.php?error_message=password is shorter than 8 characters');
		exit;
	}

	if(strlen($password) > 20){
		header('location: signup.php?error_message=password too long, maximum 20 characters allowed.');
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
/* 		// Store the result
		$stmt->store_result(); */

		if($stmt->fetch(PDO::FETCH_ASSOC)){
			header('location: signup.php?error_message=this user already exists');
			exit;
		}else{

			try {
				$conn = connect_db();
				$stmt = $conn->prepare("INSERT INTO users (username, email, password, activation_code, activation_expiry) VALUES (?, ?, ?, ?, ?)");
				/* 				$stmt->bindParam(1, $username, PDO::PARAM_STR);
				$stmt->bindParam(2, $email, PDO::PARAM_STR);
				$stmt->bindParam(3, md5($password), PDO::PARAM_STR);
				$stmt->bindParam(4, password_hash($activation_code, PASSWORD_DEFAULT));
				$stmt->bindParam(5, $activation_expiry, PDO::PARAM_STR); */


				// If user account created, return the user information to frontend
				if($stmt->execute([$username, $email, md5($password), password_hash($activation_code, PASSWORD_DEFAULT), $activation_expiry])){
					send_activation_email($email, $activation_code);
					header("location: login.php?ok_message=Verify your account by clicking the verification link sent to your mailbox.");
					/* $user = find_unverified_user($activation_code, $email); */
			
/* 					if ($user && activate_user($user['id'])) {
						header("location: login.php");
					/* 						redirect_with_message(
							'login.php',
							'You account has been activated successfully. Please login here.'
						);
					} */
/* 					try {
						$conn = connect_db();
						$stmt = $conn->prepare("SELECT id, username, email, image, following, followers, posts, bio, FROM users WHERE username = ?");
						$stmt->bindParam(1, $username, PDO::PARAM_STR);
						$stmt->execute();
						$stmt->fetch(PDO::FETCH_ASSOC);
/* 						// Bind variables to a prepared statement for result storage
						$stmt->bind_result($id, $username, $email, $image, $following, $followers, $posts, $bio);
						// Fetch the data from db
						$stmt->fetch(); */

/* 						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						// Save data in session
						$_SESSION['id'] = $row['id'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['image'] = $row['image'];
						$_SESSION['following'] = $row['following'];
						$_SESSION['followers'] = $row['followers'];
						$_SESSION['posts'] = $row['posts'];
						$_SESSION['bio'] = $row['bio'];
						//$_SESSION['token'] = $row['token'];

						//header('location: home.php');
					} catch (PDOException $error) {
						echo $error->getMessage(); 
						exit;
					} */
					require_once('auth.php');
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
	header('location: signup.php?error_message=error occured HERE');
	exit;
}

?>