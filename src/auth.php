<?php

require_once("connection.php");

function activate_user(string $email): bool
{
	try{
		$conn = connect_db();
		$sql = 'UPDATE users
				SET active = 1
				WHERE email=:email';
	
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
	
		$stmt->execute();

	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}

	return $stmt->rowCount();
}

function check_reset_code($activation_code)
{
	try{
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM users WHERE activation_code = ?");
		$stmt->bindParam(1, $activation_code, PDO::PARAM_STR);
		$stmt->execute();

	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}

	echo $stmt->rowCount();

	return $stmt->rowCount();
}

if(isset($_GET['email']) && isset($_GET['activation_code'])){
	$email = htmlspecialchars($_GET['email']);
	$activation_code = htmlspecialchars($_GET['activation_code']);

	if(!empty($activation_code) && check_reset_code($activation_code)){
		if (!empty($_GET['email']) && activate_user($email)) {
			header("location: login.php?ok_message=Your account was successfuly verified! Log in and start posting awesome pics!");
		} else {
			header("location: login.php?error_message=Error occured.");
			exit;
		}
	} else {
		header("location: login.php?error_message=Error occured.");
		exit;
	}
} else {
	header("location: login.php?error_message=Error occured.");
	exit;
}

?>